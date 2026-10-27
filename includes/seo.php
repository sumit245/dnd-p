<?php
/**
 * SEO helpers: absolute URLs for OG/schema (production vs local BASE_PATH).
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

if (!function_exists('schema_jsonld')) {
    /**
     * Render any schema array as a JSON-LD block.
     *
     * Escapes tags and ampersands because some schema values come from
     * admin-editable rows (portfolios.title), and a value containing
     * "</script>" must not be able to break out of the block.
     */
    function schema_jsonld(array $schema): string
    {
        return '<script type="application/ld+json">' . "\n"
            . json_encode(
                $schema,
                JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
                    | JSON_HEX_TAG | JSON_HEX_AMP
            )
            . "\n</script>\n";
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
