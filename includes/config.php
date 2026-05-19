<?php
/**
 * Dashandots Technology — Site Configuration
 * ───────────────────────────────────────────
 * Loaded by every page before any output.
 */

define('SITE_NAME', 'Dashandots Technology');
define('SITE_URL', 'https://dashandots.com');
define('SITE_LOGO_URL', SITE_URL . '/assets/logo.png');
define('GTM_CONTAINER_ID', 'GTM-TJ3ZLPNJ');

// Optional: paste Google Search Console HTML tag content, or set GOOGLE_SITE_VERIFICATION in .env
define('GOOGLE_SITE_VERIFICATION', '');

// Cookie banner + Consent Mode (disable with CONSENT_BANNER_ENABLED=0 in .env)
require_once __DIR__ . '/env.php';
define('CONSENT_BANNER_ENABLED', site_env_bool('CONSENT_BANNER_ENABLED', true));
define('SITE_TAGLINE', 'Custom ERP, CRM, TMS & HMS Software India');
define('SITE_PUBLIC_EMAIL', site_env('SITE_PUBLIC_EMAIL', ''));
define('SITE_EMAIL', SITE_PUBLIC_EMAIL);
define('SITE_PHONE', site_env('SITE_PHONE', ''));
define('SITE_WHATSAPP_URL', site_env('SITE_WHATSAPP_URL', ''));
define('SITE_ADDRESS', site_env('SITE_ADDRESS', ''));
define('SITE_FOUNDER_NAME', site_env('SITE_FOUNDER_NAME', ''));
define('SITE_FOUNDER_TITLE', site_env('SITE_FOUNDER_TITLE', 'Founder, Dashandots Technology'));
define('SITE_FOUNDER_LINKEDIN', site_env('SITE_FOUNDER_LINKEDIN', ''));
define('MICROSOFT_CLARITY_ID', site_env('MICROSOFT_CLARITY_ID', ''));

// Optional twitter:site meta. Set only after confirming the active handle.
define('TWITTER_SITE', site_env('TWITTER_SITE', ''));

// Base path for asset URLs — empty string for production root
define('BASE_PATH', '/dashandots');

require_once __DIR__ . '/seo.php';

// Default page context — pages override before including head.php
$page = [
    'title' => SITE_NAME . ' — ' . SITE_TAGLINE,
    'description' => 'Custom ERP, CRM, Hotel PMS & project management software developer in Gurugram, Delhi NCR. Mobile apps & management systems for Indian SMEs.',
    'keywords' => 'custom ERP development India, CRM development company India, business software for Indian SMEs',
    'canonical' => SITE_URL . '/',
    'og_title' => 'Software Developer in India | ERP, CRM, Hotel PMS & Management Systems — ' . SITE_NAME,
    'og_desc' => 'Custom ERP, CRM, Hotel PMS, hospital management & project management software developer in Delhi NCR, India. Mobile apps and enterprise systems for SMEs.',
    'og_image' => SITE_URL . '/assets/img/og-image.jpg',
    'body_class' => '',
    'active_nav' => 'home',
];
