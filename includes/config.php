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
define('SITE_EMAIL', 'dashandots@gmail.com');

// Base path for asset URLs — empty string for production root
define('BASE_PATH', '/dashandots');

// Default page context — pages override before including head.php
$page = [
    'title' => SITE_NAME . ' — ' . SITE_TAGLINE,
    'description' => 'Custom ERP, CRM, Hotel PMS & project management software developer in Delhi, India. Mobile apps and enterprise management systems for Indian SMEs.',
    'keywords' => implode(', ', [
        // ── SHORT-TAIL (Head Terms) ──────────────────────────────────────
        'ERP software India',                                       // 1
        'CRM software India',                                       // 2
        'TMS software',                                             // 3
        'HMS software',                                             // 4
        'custom software development',                              // 5
        'hotel PMS software',                                       // 6
        'mobile app development India',                             // 7
        'web development company',                                  // 8
        'IoT development India',                                    // 9
        'business automation software',                             // 10

        // ── MEDIUM-TAIL (Service + Modifier) ─────────────────────────────
        'custom ERP development India',                             // 11
        'CRM development company India',                            // 12
        'transport management system India',                        // 13
        'hospital management system India',                         // 14
        'custom software development Gurugram',                     // 15
        'ERP software for manufacturing',                           // 16
        'CRM software for small business India',                    // 17
        'fleet management software India',                          // 18
        'hotel property management system',                         // 19
        'e-commerce development company India',                     // 20
        'Laravel development company India',                        // 21
        'React Native app development India',                       // 22
        'Flutter app development company',                          // 23
        'accounting software development India',                    // 24
        'inventory management software India',                      // 25
        'custom web application development',                       // 26
        'SaaS product development India',                           // 27
        'enterprise software development company',                  // 28
        'GST billing software India',                               // 29
        'logistics software development India',                     // 30

        // ── LONG-TAIL (Buyer-Intent & Niche Queries) ─────────────────────
        'custom ERP software for SMEs in India',                    // 31
        'affordable ERP development company Gurugram',              // 32
        'best hospital management software for clinics India',      // 33
        'transport management system for logistics companies',      // 34
        'custom CRM development for sales teams India',             // 35
        'hotel PMS software with channel manager India',            // 36
        'mobile-first ERP software for Indian businesses',          // 37
        'custom web and mobile app development company India',      // 38
        'ERP with Tally integration India',                         // 39
        'fleet tracking and dispatch software India',               // 40
        'patient management software for hospitals India',          // 41
        'B2B e-commerce portal development India',                  // 42
        'IoT dashboard development for manufacturing',              // 43
        'custom inventory and procurement software India',          // 44
        'HR and payroll module ERP India',                           // 45

        // ── INDUSTRY-SPECIFIC LONG-TAIL ──────────────────────────────────
        'manufacturing ERP software India',                         // 46
        'retail POS software development India',                    // 47
        'healthcare software development company India',            // 48
        'hospitality technology solutions India',                   // 49
        'education management system development',                  // 50
        'startup MVP development company India',                    // 51
        'warehouse management software India',                      // 52
        'clinic management software India',                         // 53
        'freight billing software for transporters India',          // 54
        'pharmacy management system India',                         // 55

        // ── GEO + SERVICE COMBINATIONS ───────────────────────────────────
        'software development company Gurugram',                    // 56
        'IT company Gurugram Haryana',                              // 57
        'app development company Delhi NCR',                        // 58
        'ERP development company Delhi NCR',                        // 59
        'software company near me India',                           // 60

        // ── AEO / QUESTION-INTENT KEYWORDS ───────────────────────────────
        'best ERP software for small business India',               // 61
        'how much does custom ERP cost in India',                   // 62
        'best TMS software for fleet owners India',                 // 63
        'how to choose hospital management software',               // 64
        'what is the best CRM for Indian startups',                 // 65
    ]),
    'canonical' => SITE_URL . '/',
    'og_title' => 'Software Developer in India | ERP, CRM, Hotel PMS & Management Systems — ' . SITE_NAME,
    'og_desc' => 'Custom ERP, CRM, Hotel PMS, hospital management & project management software developer in Delhi NCR, India. Mobile apps and enterprise systems for SMEs.',
    'og_image' => SITE_URL . '/assets/img/og-image.jpg',
    'body_class' => '',
    'active_nav' => 'home',
];
