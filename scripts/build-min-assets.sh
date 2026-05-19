#!/usr/bin/env bash
# Regenerate style.min.css, app.min.js, and consent.min.js from sources.
set -euo pipefail

ROOT="$(cd "$(dirname "$0")/.." && pwd)"
CSS_SRC="$ROOT/assets/css/style.css"
CSS_MIN="$ROOT/assets/css/style.min.css"
JS_APP="$ROOT/assets/js/app.js"
JS_APP_MIN="$ROOT/assets/js/app.min.js"
JS_CONSENT="$ROOT/assets/js/consent.js"
JS_CONSENT_MIN="$ROOT/assets/js/consent.min.js"

if command -v npx >/dev/null 2>&1; then
  npx --yes clean-css-cli -o "$CSS_MIN" "$CSS_SRC"
  npx --yes terser "$JS_APP" -o "$JS_APP_MIN" -c -m
  if [[ -f "$JS_CONSENT" ]]; then
    npx --yes terser "$JS_CONSENT" -o "$JS_CONSENT_MIN" -c -m
  fi
  echo "Minified with clean-css-cli and terser."
  exit 0
fi

echo "npx not found. Install Node.js or run:"
echo "  npx clean-css-cli -o assets/css/style.min.css assets/css/style.css"
echo "  npx terser assets/js/app.js -o assets/js/app.min.js -c -m"
exit 1
