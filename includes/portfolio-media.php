<?php
/**
 * Portfolio image helpers — WebP + dimensions for LCP/CLS.
 */

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
    $style = $attrs['style'] ?? 'width:100%;height:100%;object-fit:cover';
    $width = (int) ($attrs['width'] ?? 800);
    $height = (int) ($attrs['height'] ?? 450);
    $safeAlt = htmlspecialchars($alt, ENT_QUOTES, 'UTF-8');
    $src = htmlspecialchars($url, ENT_QUOTES, 'UTF-8');

    $extra = '';
    if ($fetchpriority !== '') {
        $extra .= ' fetchpriority="' . htmlspecialchars($fetchpriority, ENT_QUOTES, 'UTF-8') . '"';
    }
    if ($class !== '') {
        $extra .= ' class="' . htmlspecialchars($class, ENT_QUOTES, 'UTF-8') . '"';
    }

    return sprintf(
        '<img src="%s" alt="%s" width="%d" height="%d" loading="%s" decoding="async"%s style="%s">',
        $src,
        $safeAlt,
        $width,
        $height,
        htmlspecialchars($loading, ENT_QUOTES, 'UTF-8'),
        $extra,
        htmlspecialchars($style, ENT_QUOTES, 'UTF-8')
    );
}

function portfolio_picture_html(string $url, string $alt, array $attrs = []): string
{
    $meta = portfolio_image_meta($url);
    $loading = $attrs['loading'] ?? 'lazy';
    $fetchpriority = $attrs['fetchpriority'] ?? '';
    $class = $attrs['class'] ?? '';
    $style = $attrs['style'] ?? 'width:100%;height:100%;object-fit:cover';

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
        '<img src="%s" alt="%s" width="%d" height="%d" loading="%s" decoding="async"%s style="%s">',
        htmlspecialchars($url, ENT_QUOTES, 'UTF-8'),
        $safeAlt,
        $width,
        $height,
        htmlspecialchars($loading, ENT_QUOTES, 'UTF-8'),
        $extra,
        htmlspecialchars($style, ENT_QUOTES, 'UTF-8')
    );

    if (!empty($meta['webp'])) {
        return sprintf(
            '<picture><source srcset="%s" type="image/webp">%s</picture>',
            htmlspecialchars($meta['webp'], ENT_QUOTES, 'UTF-8'),
            $img
        );
    }

    return $img;
}
