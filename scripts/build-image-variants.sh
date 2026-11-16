#!/usr/bin/env bash
#
# Generate responsive WebP variants for portfolio and content images.
#
# Every image was served at one size to every viewport: a 1600px-wide portfolio
# screenshot went to phones rendering it in a ~380px tile. This emits -640 and
# -1024 variants beside each source; includes/portfolio-media.php picks them up
# automatically through srcset when the files exist, so running this is safe at
# any time and skipping it changes nothing.
#
# Usage:
#   scripts/build-image-variants.sh                 # all image dirs
#   scripts/build-image-variants.sh assets/img/foo  # one directory
#
# Requires cwebp (brew install webp).

set -euo pipefail

ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
WIDTHS=(640 768 1024)
QUALITY=82

if ! command -v cwebp >/dev/null 2>&1; then
    echo "error: cwebp not found. Install it with: brew install webp" >&2
    exit 1
fi

DIRS=("${@:-assets/img assets/img/portfolio}")
read -r -a DIRS <<< "${DIRS[*]}"

made=0
skipped=0

for dir in "${DIRS[@]}"; do
    full="$ROOT/$dir"
    [ -d "$full" ] || { echo "skip: $dir (not a directory)"; continue; }

    # Only top-level files: assets/img and assets/img/portfolio are listed separately.
    while IFS= read -r src; do
        base="${src%.webp}"

        # Never treat an existing variant as a source.
        case "$base" in
            *-640|*-1024) continue ;;
        esac

        src_w=$(sips -g pixelWidth "$src" 2>/dev/null | awk '/pixelWidth/{print $2}')
        [ -n "${src_w:-}" ] || { echo "skip: $(basename "$src") (cannot read width)"; continue; }

        for w in "${WIDTHS[@]}"; do
            out="${base}-${w}.webp"

            # Pointless to upscale, and pointless to redo work.
            if [ "$src_w" -le "$w" ]; then
                continue
            fi
            if [ -f "$out" ] && [ "$out" -nt "$src" ]; then
                skipped=$((skipped + 1))
                continue
            fi

            cwebp -quiet -q "$QUALITY" -resize "$w" 0 "$src" -o "$out"
            echo "made: ${out#"$ROOT/"} (${src_w}px -> ${w}px)"
            made=$((made + 1))
        done
    done < <(find "$full" -maxdepth 1 -type f -name '*.webp' | sort)
done

echo
echo "done: $made written, $skipped already current"
