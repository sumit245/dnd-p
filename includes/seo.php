<?php
/**
 * SEO helpers — absolute URLs for OG/schema (production vs local BASE_PATH).
 */
declare(strict_types=1);

if (!function_exists('absolute_public_url')) {
    function absolute_public_url(string $pathOrUrl): string
    {
        if ($pathOrUrl === '') {
            return '';
        }
        if (preg_match('#^https?://#i', $pathOrUrl)) {
            return $pathOrUrl;
        }

        $path = $pathOrUrl;
        if (defined('BASE_PATH') && BASE_PATH !== '' && str_starts_with($path, BASE_PATH . '/')) {
            $path = substr($path, strlen(BASE_PATH));
        } elseif (defined('BASE_PATH') && BASE_PATH !== '' && $path === BASE_PATH) {
            $path = '/';
        }

        return rtrim(SITE_URL, '/') . '/' . ltrim($path, '/');
    }
}

if (!function_exists('site_redirect')) {
    /** Redirect to a path on the public site (always uses SITE_URL). */
    function site_redirect(string $path): never
    {
        $path = '/' . ltrim($path, '/');
        header('Location: ' . rtrim(SITE_URL, '/') . $path);
        exit;
    }
}

if (!function_exists('public_href')) {
    /** HTML href for internal links (respects BASE_PATH on localhost). */
    function public_href(string $path = '/'): string
    {
        $path = '/' . ltrim($path, '/');
        $base = defined('BASE_PATH') ? BASE_PATH : '';

        return $base . $path;
    }
}
