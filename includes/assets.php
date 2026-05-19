<?php
/**
 * Public asset URLs — prefers minified bundles when present.
 */
function asset_cdn_base(): string
{
    return defined('ASSET_CDN_URL') ? rtrim((string) ASSET_CDN_URL, '/') : '';
}

function asset_public_path(string $pathOrUrl): ?string
{
    if ($pathOrUrl === '') {
        return null;
    }

    $path = preg_match('#^https?://#i', $pathOrUrl)
        ? (string) parse_url($pathOrUrl, PHP_URL_PATH)
        : $pathOrUrl;

    if ($path === '') {
        return null;
    }

    if (defined('BASE_PATH') && BASE_PATH !== '' && str_starts_with($path, BASE_PATH . '/')) {
        $path = substr($path, strlen(BASE_PATH));
    }

    $path = '/' . ltrim($path, '/');

    return str_starts_with($path, '/assets/') ? $path : null;
}

function asset_url(string $pathOrUrl, ?int $version = null): string
{
    $assetPath = asset_public_path($pathOrUrl);
    if ($assetPath === null) {
        return $pathOrUrl;
    }

    $base = asset_cdn_base();
    $url = ($base !== '' ? $base : (defined('BASE_PATH') ? BASE_PATH : '')) . $assetPath;

    return $version !== null ? $url . '?v=' . $version : $url;
}

function asset_css_href(): string
{
    $min = __DIR__ . '/../assets/css/style.min.css';
    $file = file_exists($min) ? 'style.min.css' : 'style.css';

    return asset_url('/assets/css/' . $file, filemtime(__DIR__ . '/../assets/css/' . $file));
}

function asset_js_src(): string
{
    $min = __DIR__ . '/../assets/js/app.min.js';
    $file = file_exists($min) ? 'app.min.js' : 'app.js';

    return asset_url('/assets/js/' . $file, filemtime(__DIR__ . '/../assets/js/' . $file));
}

function asset_consent_js_src(): string
{
    $min = __DIR__ . '/../assets/js/consent.min.js';
    $file = file_exists($min) ? 'consent.min.js' : 'consent.js';

    return asset_url('/assets/js/' . $file, filemtime(__DIR__ . '/../assets/js/' . $file));
}
