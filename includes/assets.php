<?php
/**
 * Public asset URLs — prefers minified bundles when present.
 */
function asset_css_href(): string
{
    $min = __DIR__ . '/../assets/css/style.min.css';
    $file = file_exists($min) ? 'style.min.css' : 'style.css';
    $path = BASE_PATH . '/assets/css/' . $file;

    return $path . '?v=' . filemtime(__DIR__ . '/../assets/css/' . $file);
}

function asset_js_src(): string
{
    $min = __DIR__ . '/../assets/js/app.min.js';
    $file = file_exists($min) ? 'app.min.js' : 'app.js';
    $path = BASE_PATH . '/assets/js/' . $file;

    return $path . '?v=' . filemtime(__DIR__ . '/../assets/js/' . $file);
}

function asset_consent_js_src(): string
{
    $min = __DIR__ . '/../assets/js/consent.min.js';
    $file = file_exists($min) ? 'consent.min.js' : 'consent.js';
    $path = BASE_PATH . '/assets/js/' . $file;

    return $path . '?v=' . filemtime(__DIR__ . '/../assets/js/' . $file);
}
