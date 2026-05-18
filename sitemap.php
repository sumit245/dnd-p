<?php
/**
 * Dynamic XML Sitemap — Dashandots Technology
 * Queries DB for live blog posts so phantom URLs never appear.
 * Replace sitemap.xml reference with this file in robots.txt.
 */
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/db.php';

header('Content-Type: application/xml; charset=utf-8');
header('X-Robots-Tag: noindex');

// ── Static pages ──────────────────────────────────────────────────
$staticPages = [
    ['loc' => SITE_URL . '/',                       'changefreq' => 'weekly',  'priority' => '1.0', 'lastmod' => '2026-04-26'],
    ['loc' => SITE_URL . '/blog/',                  'changefreq' => 'weekly',  'priority' => '0.8', 'lastmod' => '2026-04-26'],
    ['loc' => SITE_URL . '/services/erp-development',     'changefreq' => 'monthly', 'priority' => '0.8', 'lastmod' => '2026-04-26'],
    ['loc' => SITE_URL . '/services/web-mobile-apps',     'changefreq' => 'monthly', 'priority' => '0.7', 'lastmod' => '2026-04-26'],
    ['loc' => SITE_URL . '/services/ecommerce',           'changefreq' => 'monthly', 'priority' => '0.7', 'lastmod' => '2026-04-26'],
    ['loc' => SITE_URL . '/services/industry-systems',    'changefreq' => 'monthly', 'priority' => '0.7', 'lastmod' => '2026-04-26'],
    ['loc' => SITE_URL . '/services/data-analytics',      'changefreq' => 'monthly', 'priority' => '0.7', 'lastmod' => '2026-04-26'],
    ['loc' => SITE_URL . '/services/iot-embedded',        'changefreq' => 'monthly', 'priority' => '0.7', 'lastmod' => '2026-04-26'],
    ['loc' => SITE_URL . '/privacy-policy',         'changefreq' => 'yearly',  'priority' => '0.3', 'lastmod' => '2026-04-26'],
    ['loc' => SITE_URL . '/terms',                  'changefreq' => 'yearly',  'priority' => '0.3', 'lastmod' => '2026-04-26'],
];

// ── Static blog articles (blog/{slug}.php) ────────────────────────
$staticBlogPages = [
    ['slug' => 'future-of-custom-erp',      'lastmod' => '2024-04-10'],
    ['slug' => 'mobile-first-design-b2b',   'lastmod' => '2024-04-18'],
];

// ── Published blog posts from DB ──────────────────────────────────
$blogPosts = [];
$dbSlugs = [];
try {
    $stmt = $pdo->query("SELECT slug, updated_at, created_at FROM blogs WHERE status = 'published' ORDER BY created_at DESC");
    while ($row = $stmt->fetch()) {
        $dbSlugs[$row['slug']] = true;
        $lastmod = !empty($row['updated_at']) ? $row['updated_at'] : $row['created_at'];
        $blogPosts[] = [
            'loc'        => SITE_URL . '/blog/' . rawurlencode($row['slug']),
            'changefreq' => 'monthly',
            'priority'   => '0.7',
            'lastmod'    => date('Y-m-d', strtotime($lastmod)),
        ];
    }
} catch (PDOException $e) {
    // Silently skip DB errors — static pages still output
}

foreach ($staticBlogPages as $static) {
    if (!empty($dbSlugs[$static['slug']])) {
        continue;
    }
    $phpFile = __DIR__ . '/blog/' . $static['slug'] . '.php';
    if (!is_file($phpFile)) {
        continue;
    }
    $blogPosts[] = [
        'loc'        => SITE_URL . '/blog/' . rawurlencode($static['slug']),
        'changefreq' => 'monthly',
        'priority'   => '0.7',
        'lastmod'    => $static['lastmod'],
    ];
}

// ── Output XML ────────────────────────────────────────────────────
echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
        http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
<?php foreach (array_merge($staticPages, $blogPosts) as $url): ?>
  <url>
    <loc><?php echo htmlspecialchars($url['loc']); ?></loc>
    <lastmod><?php echo $url['lastmod']; ?></lastmod>
    <changefreq><?php echo $url['changefreq']; ?></changefreq>
    <priority><?php echo $url['priority']; ?></priority>
  </url>
<?php endforeach; ?>
</urlset>
