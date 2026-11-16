<?php
/**
 * Dashandots Technology: Site Configuration
 * ───────────────────────────────────────────
 * Loaded by every page before any output.
 */

// Starts the output buffer that strips template indentation, so it must run
// before a page prints anything. Non-HTML handlers are skipped there.
require_once __DIR__ . '/html-minify.php';

define('SITE_NAME', 'Dashandots Technology');
define('SITE_URL', 'https://dashandots.com');
// Analytics: both overridable in .env. GTM_CONTAINER_ID must be a GTM-XXXX container id
// (NOT a G- measurement id); GA4_MEASUREMENT_ID (G-XXXX) loads gtag.js directly so events
// reach GA4 even when the GTM container has no tags yet.
require_once __DIR__ . '/env.php';
$gtmEnv = strtoupper(trim(site_env('GTM_CONTAINER_ID', '')));
$ga4Env = strtoupper(trim(site_env('GA4_MEASUREMENT_ID', '')));
// Forgive a G- measurement id pasted into the GTM slot: use it as the GA4 id instead.
if ($ga4Env === '' && preg_match('/^G-[A-Z0-9]{4,14}$/', $gtmEnv)) {
    $ga4Env = $gtmEnv;
}
// Empty/invalid GTM value → the site's known container, never "analytics off".
define('GTM_CONTAINER_ID', preg_match('/^GTM-[A-Z0-9]{4,12}$/', $gtmEnv) ? $gtmEnv : 'GTM-TJ3ZLPNJ');
define('GA4_MEASUREMENT_ID', preg_match('/^G-[A-Z0-9]{4,14}$/', $ga4Env) ? $ga4Env : '');
define('ANALYTICS_ENABLED', GTM_CONTAINER_ID !== '' || GA4_MEASUREMENT_ID !== '');
// Consent Mode default for analytics_storage: 'denied' (EU-style opt-in) or 'granted' (opt-out).
define('CONSENT_ANALYTICS_DEFAULT', site_env('CONSENT_ANALYTICS_DEFAULT', 'denied') === 'granted' ? 'granted' : 'denied');

// Optional: paste Google Search Console HTML tag content, or set GOOGLE_SITE_VERIFICATION in .env
define('GOOGLE_SITE_VERIFICATION', '');

// Cookie banner + Consent Mode (disable with CONSENT_BANNER_ENABLED=0 in .env)
define('CONSENT_BANNER_ENABLED', site_env_bool('CONSENT_BANNER_ENABLED', true));
define('ASSET_CDN_URL', rtrim(site_env('ASSET_CDN_URL', ''), '/'));
define('SITE_LOGO_URL', (ASSET_CDN_URL !== '' ? ASSET_CDN_URL : SITE_URL) . '/assets/logo.webp');
define('SITE_TAGLINE', 'Custom ERP, CRM, TMS & HMS Software India');
define('SITE_PUBLIC_EMAIL', site_env('SITE_PUBLIC_EMAIL', ''));
define('SITE_EMAIL', SITE_PUBLIC_EMAIL);
define('SITE_PHONE', site_env('SITE_PHONE', ''));
define('SITE_WHATSAPP_URL', site_env('SITE_WHATSAPP_URL', ''));
// Structured postal address. SEO/GEO crawlers and schema.org want the parts
// separately; SITE_ADDRESS stays the human-readable display string and is
// assembled from the parts when it is not set explicitly.
define('SITE_STREET', site_env('SITE_STREET', ''));
define('SITE_LOCALITY', site_env('SITE_LOCALITY', 'Gurugram'));
define('SITE_REGION', site_env('SITE_REGION', 'Haryana'));
define('SITE_POSTAL_CODE', site_env('SITE_POSTAL_CODE', ''));
define('SITE_COUNTRY', site_env('SITE_COUNTRY', 'IN'));
define('SITE_COUNTRY_NAME', site_env('SITE_COUNTRY_NAME', 'India'));

if (!function_exists('site_address_parts')) {
    /** Non-empty address components, in display order. */
    function site_address_parts(): array
    {
        return array_values(array_filter([
            SITE_STREET,
            SITE_LOCALITY,
            SITE_REGION,
            SITE_POSTAL_CODE,
            SITE_COUNTRY_NAME,
        ], static fn($v): bool => is_string($v) && $v !== ''));
    }
}

if (!function_exists('site_address_street_fallback')) {
    /**
     * Street line recovered from the single SITE_ADDRESS string, for sites that
     * set it before the structured parts existed. Drops the segments already
     * carried by SITE_LOCALITY / SITE_REGION / SITE_POSTAL_CODE / country, so
     * the schema does not repeat "Gurugram" in two different fields.
     */
    function site_address_street_fallback(): string
    {
        if (!defined('SITE_ADDRESS') || SITE_ADDRESS === '') {
            return '';
        }
        $known = array_filter([
            mb_strtolower(SITE_LOCALITY),
            mb_strtolower(SITE_REGION),
            mb_strtolower(SITE_POSTAL_CODE),
            mb_strtolower(SITE_COUNTRY_NAME),
            mb_strtolower(SITE_COUNTRY),
        ], static fn(string $v): bool => $v !== '');

        $kept = [];
        foreach (explode(',', SITE_ADDRESS) as $segment) {
            $segment = trim($segment);
            if ($segment === '' || in_array(mb_strtolower($segment), $known, true)) {
                continue;
            }
            $kept[] = $segment;
        }
        return implode(', ', $kept);
    }
}

if (!function_exists('site_postal_address_schema')) {
    /** schema.org PostalAddress built from the configured parts. */
    function site_postal_address_schema(): array
    {
        $a = ['@type' => 'PostalAddress'];
        $street = SITE_STREET !== '' ? SITE_STREET : site_address_street_fallback();
        if ($street !== '')          { $a['streetAddress']   = $street; }
        if (SITE_LOCALITY !== '')    { $a['addressLocality'] = SITE_LOCALITY; }
        if (SITE_REGION !== '')      { $a['addressRegion']   = SITE_REGION; }
        if (SITE_POSTAL_CODE !== '') { $a['postalCode']      = SITE_POSTAL_CODE; }
        $a['addressCountry'] = SITE_COUNTRY !== '' ? SITE_COUNTRY : 'IN';
        return $a;
    }
}

$siteAddressEnv = site_env('SITE_ADDRESS', '');
define('SITE_ADDRESS', $siteAddressEnv !== '' ? $siteAddressEnv : implode(', ', site_address_parts()));
unset($siteAddressEnv);
if (!function_exists('site_email_link')) {
    /**
     * Obfuscated email anchor. The address never appears in the served HTML as
     * plain text, so harvesters (and the "Email Privacy" audit check) find
     * nothing; app.js rebuilds the mailto: href on load. Without JavaScript the
     * link still works -- it falls back to the on-page contact form.
     *
     * @param string $label    Link text shown before JS runs.
     * @param bool   $showAddr Replace the label with the real address after JS runs.
     */
    function site_email_link(string $label = 'Email us', bool $showAddr = false, string $ctaLocation = ''): string
    {
        if (!defined('SITE_EMAIL') || SITE_EMAIL === '' || strpos(SITE_EMAIL, '@') === false) {
            return '';
        }
        [$user, $domain] = explode('@', SITE_EMAIL, 2);
        $esc = static fn(string $v): string => htmlspecialchars($v, ENT_QUOTES, 'UTF-8');
        $fallback = (defined('BASE_PATH') ? BASE_PATH : '') . '/#contact';

        $attrs = 'class="email-obf" href="' . $esc($fallback) . '"'
            . ' data-eu="' . $esc($user) . '" data-ed="' . $esc($domain) . '"';
        if ($showAddr) {
            $attrs .= ' data-email-show="1"';
        }
        if ($ctaLocation !== '') {
            $attrs .= ' data-track="cta" data-cta-location="' . $esc($ctaLocation) . '"';
        }
        return '<a ' . $attrs . '>' . $esc($label) . '</a>';
    }
}

define('SITE_FOUNDER_NAME', site_env('SITE_FOUNDER_NAME', ''));
define('SITE_FOUNDER_TITLE', site_env('SITE_FOUNDER_TITLE', 'Founder, Dashandots Technology'));
define('SITE_FOUNDER_LINKEDIN', site_env('SITE_FOUNDER_LINKEDIN', ''));
define('MICROSOFT_CLARITY_ID', site_env('MICROSOFT_CLARITY_ID', ''));

// Optional twitter:site meta. Set only after confirming the active handle.
define('TWITTER_SITE', site_env('TWITTER_SITE', ''));

// Base path for links and asset URLs. The site runs at the document root in
// production and under /dashandots on local XAMPP, so this cannot be a constant:
// hardcoding the local path ships /dashandots/assets/... to production, where
// every stylesheet, script and image 404s.
// Order: explicit BASE_PATH in .env wins; otherwise local hosts get /dashandots
// and everything else (including CLI, which has no HTTP_HOST) gets the root.
$basePathEnv = site_env('BASE_PATH', '__unset__');
if ($basePathEnv !== '__unset__') {
    define('BASE_PATH', $basePathEnv === '/' ? '' : rtrim($basePathEnv, '/'));
} else {
    $siteHost = strtolower(trim((string) ($_SERVER['HTTP_HOST'] ?? '')));
    $siteIsLocal = (bool) preg_match('/^(localhost|127\.0\.0\.1|\[::1\])(:\d+)?$/', $siteHost);
    define('BASE_PATH', $siteIsLocal ? '/dashandots' : '');
}
unset($basePathEnv, $siteHost, $siteIsLocal);

require_once __DIR__ . '/seo.php';

// Default page context: pages override before including head.php
$page = [
    'title' => SITE_NAME . ' | ' . SITE_TAGLINE,
    'description' => 'Dashandots builds custom ERP, CRM, Hotel PMS, project management software and mobile apps for Indian SMEs in Gurugram and Delhi NCR, with secure delivery and long-term support.',
    'keywords' => 'custom ERP development India, CRM development company India, business software for Indian SMEs',
    'canonical' => SITE_URL . '/',
    // Kept under ~70 chars so social previews do not truncate it.
    'og_title' => 'ERP, CRM & Management Systems | ' . SITE_NAME,
    'og_desc' => 'Custom ERP, CRM, Hotel PMS, hospital management & project management software developer in Delhi NCR, India. Mobile apps and enterprise systems for SMEs.',
    'og_image' => SITE_URL . '/assets/img/og-image.jpg',
    'body_class' => '',
    'active_nav' => 'home',
    // Pre-rendered <script type="application/ld+json"> blocks; head.php emits each.
    'jsonld' => [],
];
