<?php
/**
 * Portfolio image helpers: WebP + dimensions for LCP/CLS.
 */
require_once __DIR__ . '/assets.php';

function portfolio_resolve_filesystem_path(string $url): ?string
{
    if ($url === '') {
        return null;
    }

    if (strpos($url, 'http://') === 0 || strpos($url, 'https://') === 0) {
        $path = parse_url($url, PHP_URL_PATH);
    } else {
        $path = $url;
    }

    if (!is_string($path) || $path === '') {
        return null;
    }

    if (defined('BASE_PATH') && BASE_PATH !== '' && strpos($path, BASE_PATH) === 0) {
        $path = substr($path, strlen(BASE_PATH));
    }

    $full = realpath(__DIR__ . '/..' . $path);

    return ($full && is_file($full)) ? $full : null;
}

/**
 * @return array{width:int,height:int,src:string,webp:?string}|null
 */
function portfolio_image_meta(string $url): ?array
{
    $full = portfolio_resolve_filesystem_path($url);
    if (!$full) {
        return null;
    }

    $info = @getimagesize($full);
    if (!$info) {
        return null;
    }

    $webpPath = preg_replace('/\.(png|jpe?g)$/i', '.webp', $full);
    $webpPublic = null;
    if ($webpPath && is_file($webpPath)) {
        $publicPath = preg_replace('/\.(png|jpe?g)$/i', '.webp', $url);
        $webpPublic = $publicPath;
    }

    return [
        'width' => (int) $info[0],
        'height' => (int) $info[1],
        'src' => $url,
        'webp' => $webpPublic,
    ];
}

/**
 * Normalize absolute or BASE_PATH URLs to a site-relative path for filesystem lookup.
 */
function content_image_public_path(string $url): string
{
    $url = trim($url);
    if ($url === '') {
        return '';
    }

    if (defined('SITE_URL') && strpos($url, SITE_URL) === 0) {
        return substr($url, strlen(rtrim(SITE_URL, '/')));
    }

    return $url;
}

/**
 * Responsive image markup for blog/CMS paths (WebP + dimensions when files exist locally).
 */
function content_image_html(string $url, string $alt, array $attrs = []): string
{
    $path = content_image_public_path($url);
    if ($path !== '' && portfolio_resolve_filesystem_path($path)) {
        return portfolio_picture_html($path, $alt, $attrs);
    }

    $loading = $attrs['loading'] ?? 'lazy';
    $fetchpriority = $attrs['fetchpriority'] ?? '';
    $class = $attrs['class'] ?? '';
    // No explicit style: use the .port-media-fill class instead of an inline
    // style attribute (SEO audit: "Remove Inline Styles"). Callers that pass
    // their own style still get it inline.
    $style = isset($attrs['style']) ? (string) $attrs['style'] : '';
    if ($style === '') {
        $class = trim($class . ' port-media-fill');
    }
    $width = (int) ($attrs['width'] ?? 800);
    $height = (int) ($attrs['height'] ?? 450);
    $safeAlt = htmlspecialchars($alt, ENT_QUOTES, 'UTF-8');
    $src = htmlspecialchars(asset_url($url), ENT_QUOTES, 'UTF-8');

    $extra = '';
    if ($fetchpriority !== '') {
        $extra .= ' fetchpriority="' . htmlspecialchars($fetchpriority, ENT_QUOTES, 'UTF-8') . '"';
    }
    if ($class !== '') {
        $extra .= ' class="' . htmlspecialchars($class, ENT_QUOTES, 'UTF-8') . '"';
    }

    return sprintf(
        '<img src="%s" alt="%s" width="%d" height="%d" loading="%s" decoding="async"%s%s>',
        $src,
        $safeAlt,
        $width,
        $height,
        htmlspecialchars($loading, ENT_QUOTES, 'UTF-8'),
        $extra,
        $style !== '' ? ' style="' . htmlspecialchars($style, ENT_QUOTES, 'UTF-8') . '"' : ''
    );
}

/**
 * Responsive WebP candidates for an image.
 *
 * scripts/build-image-variants.sh writes "-640.webp" / "-768.webp" /
 * "-1024.webp" beside each
 * source. Tiles render around 380-600px wide, so serving the full-size file to
 * every viewport is what the audit flags as a poorly optimised image. Returns a
 * srcset string with width descriptors, or '' when no variants exist.
 */
function portfolio_webp_srcset(string $webpPublic, int $intrinsicWidth): string
{
    static $cache = [];
    if (isset($cache[$webpPublic])) {
        return $cache[$webpPublic];
    }

    $candidates = [];
    foreach ([640, 768, 1024] as $w) {
        if ($intrinsicWidth > 0 && $w >= $intrinsicWidth) {
            continue;
        }
        $variantPublic = preg_replace('/\.webp$/i', '-' . $w . '.webp', $webpPublic);
        if (!is_string($variantPublic)) {
            continue;
        }
        if (portfolio_resolve_filesystem_path($variantPublic) !== null) {
            $candidates[] = htmlspecialchars(asset_url($variantPublic), ENT_QUOTES, 'UTF-8') . ' ' . $w . 'w';
        }
    }

    if ($candidates === []) {
        return $cache[$webpPublic] = '';
    }

    if ($intrinsicWidth > 0) {
        $candidates[] = htmlspecialchars(asset_url($webpPublic), ENT_QUOTES, 'UTF-8') . ' ' . $intrinsicWidth . 'w';
    }

    return $cache[$webpPublic] = implode(', ', $candidates);
}

function portfolio_picture_html(string $url, string $alt, array $attrs = []): string
{
    $meta = portfolio_image_meta($url);
    $loading = $attrs['loading'] ?? 'lazy';
    $fetchpriority = $attrs['fetchpriority'] ?? '';
    $class = $attrs['class'] ?? '';
    // No explicit style: use the .port-media-fill class instead of an inline
    // style attribute (SEO audit: "Remove Inline Styles"). Callers that pass
    // their own style still get it inline.
    $style = isset($attrs['style']) ? (string) $attrs['style'] : '';
    if ($style === '') {
        $class = trim($class . ' port-media-fill');
    }

    $width = $meta['width'] ?? 600;
    $height = $meta['height'] ?? 400;
    $safeAlt = htmlspecialchars($alt, ENT_QUOTES, 'UTF-8');

    $extra = '';
    if ($fetchpriority !== '') {
        $extra .= ' fetchpriority="' . htmlspecialchars($fetchpriority, ENT_QUOTES, 'UTF-8') . '"';
    }
    if ($class !== '') {
        $extra .= ' class="' . htmlspecialchars($class, ENT_QUOTES, 'UTF-8') . '"';
    }

    $img = sprintf(
        '<img src="%s" alt="%s" width="%d" height="%d" loading="%s" decoding="async"%s%s>',
        htmlspecialchars(asset_url($url), ENT_QUOTES, 'UTF-8'),
        $safeAlt,
        $width,
        $height,
        htmlspecialchars($loading, ENT_QUOTES, 'UTF-8'),
        $extra,
        $style !== '' ? ' style="' . htmlspecialchars($style, ENT_QUOTES, 'UTF-8') . '"' : ''
    );

    if (!empty($meta['webp'])) {
        $srcset = portfolio_webp_srcset($meta['webp'], $width);
        if ($srcset === '') {
            $srcset = htmlspecialchars(asset_url($meta['webp']), ENT_QUOTES, 'UTF-8');
            $sizesAttr = '';
        } else {
            // Measured slot widths: ~91vw on phones, ~31vw up to the 1200px container
            // cap, then a fixed ~371px column. Keep these honest -- an over-stated width
            // makes the browser fetch the 1024px file for a 310px tile, which is the
            // waste being fixed here.
            $sizes = $attrs['sizes'] ?? '(max-width: 600px) 92vw, (max-width: 1248px) 31vw, 380px';
            $sizesAttr = ' sizes="' . htmlspecialchars((string) $sizes, ENT_QUOTES, 'UTF-8') . '"';
        }

        return sprintf(
            '<picture><source srcset="%s"%s type="image/webp">%s</picture>',
            $srcset,
            $sizesAttr,
            $img
        );
    }

    return $img;
}
