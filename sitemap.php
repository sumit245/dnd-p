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

// ── lastmod helpers ───────────────────────────────────────────────
// Dates were hard-coded until Oct 2026 and went six months stale. They are now
// derived: filemtime() for file-backed pages, MAX(updated_at) for pages whose
// content lives in the database. Everything is clamped to today so a skewed
// server clock can never advertise a future lastmod.
$sitemapToday = date('Y-m-d');

/** Y-m-d mtime of a template, clamped to today; $fallback when it is missing. */
function sitemap_file_lastmod(string $relativePath, string $fallback): string
{
    $full = __DIR__ . '/' . ltrim($relativePath, '/');
    if (!is_file($full)) {
        return $fallback;
    }
    $stamp = @filemtime($full);

    return $stamp ? min(date('Y-m-d', $stamp), date('Y-m-d')) : $fallback;
}

/** MAX() of one or more datetime columns, clamped to today. */
function sitemap_db_lastmod(PDO $pdo, array $queries, string $fallback): string
{
    $latest = null;
    foreach ($queries as $sql) {
        try {
            $value = $pdo->query($sql)->fetchColumn();
        } catch (PDOException $e) {
            continue;
        }
        if (!$value) {
            continue;
        }
        $stamp = strtotime((string)$value);
        if ($stamp && ($latest === null || $stamp > $latest)) {
            $latest = $stamp;
        }
    }

    return $latest ? min(date('Y-m-d', $latest), date('Y-m-d')) : $fallback;
}

// Homepage hero/About copy lives in site_settings; its tiles come from portfolios.
$homeLastmod = sitemap_db_lastmod($pdo, [
    'SELECT MAX(updated_at) FROM site_settings',
    'SELECT MAX(updated_at) FROM portfolios',
], sitemap_file_lastmod('index.php', '2026-04-26'));

$portfolioLastmod = sitemap_db_lastmod($pdo, [
    'SELECT MAX(updated_at) FROM portfolios',
], sitemap_file_lastmod('portfolio.php', '2026-09-12'));

$blogIndexLastmod = sitemap_db_lastmod($pdo, [
    "SELECT MAX(updated_at) FROM blogs WHERE status = 'published'",
], sitemap_file_lastmod('blog/index.php', '2026-04-26'));

// ── Static pages ──────────────────────────────────────────────────
$staticPages = [
    ['loc' => SITE_URL . '/',                       'changefreq' => 'weekly',  'priority' => '1.0', 'lastmod' => $homeLastmod],
    ['loc' => SITE_URL . '/blog/',                  'changefreq' => 'weekly',  'priority' => '0.8', 'lastmod' => $blogIndexLastmod],
    ['loc' => SITE_URL . '/portfolio',              'changefreq' => 'weekly',  'priority' => '0.8', 'lastmod' => $portfolioLastmod],
    ['loc' => SITE_URL . '/services/erp-development/',     'changefreq' => 'monthly', 'priority' => '0.8', 'lastmod' => sitemap_file_lastmod('services/erp-development/index.php', '2026-04-26')],
    ['loc' => SITE_URL . '/services/web-mobile-apps/',     'changefreq' => 'monthly', 'priority' => '0.7', 'lastmod' => sitemap_file_lastmod('services/web-mobile-apps/index.php', '2026-04-26')],
    ['loc' => SITE_URL . '/services/ecommerce/',           'changefreq' => 'monthly', 'priority' => '0.7', 'lastmod' => sitemap_file_lastmod('services/ecommerce/index.php', '2026-04-26')],
    ['loc' => SITE_URL . '/services/industry-systems/',    'changefreq' => 'monthly', 'priority' => '0.7', 'lastmod' => sitemap_file_lastmod('services/industry-systems/index.php', '2026-04-26')],
    ['loc' => SITE_URL . '/services/data-analytics/',      'changefreq' => 'monthly', 'priority' => '0.7', 'lastmod' => sitemap_file_lastmod('services/data-analytics/index.php', '2026-04-26')],
    ['loc' => SITE_URL . '/services/iot-embedded/',        'changefreq' => 'monthly', 'priority' => '0.7', 'lastmod' => sitemap_file_lastmod('services/iot-embedded/index.php', '2026-04-26')],
    ['loc' => SITE_URL . '/privacy-policy',         'changefreq' => 'yearly',  'priority' => '0.3', 'lastmod' => sitemap_file_lastmod('privacy-policy.php', '2026-04-26')],
    ['loc' => SITE_URL . '/terms',                  'changefreq' => 'yearly',  'priority' => '0.3', 'lastmod' => sitemap_file_lastmod('terms.php', '2026-04-26')],
];

// ── Static blog articles (blog/{slug}.php) ────────────────────────
// lastmod comes from the file itself, not a literal — the 2024 dates these
// carried were years out of step with every other date on the site.
$staticBlogPages = [
    ['slug' => 'future-of-custom-erp'],
    ['slug' => 'mobile-first-design-b2b'],
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
            'lastmod'    => min(date('Y-m-d', strtotime($lastmod)), $sitemapToday),
        ];
    }
} catch (PDOException $e) {
    // Silently skip DB errors — static pages still output
}

// ── Portfolio / product pages from DB (only those with a live URL) ──
$portfolioPages = [];
try {
    // Graphics entries are thin by design (one image, a caption) and are
    // noindex in demo/view.php, so they stay out of the sitemap too.
    $stmt = $pdo->query("SELECT slug, updated_at, created_at FROM portfolios WHERE category <> 'graphics' AND ((demo_url IS NOT NULL AND demo_url <> '') OR (detailed_description IS NOT NULL AND detailed_description <> '')) ORDER BY sort_order ASC, created_at ASC");
    while ($row = $stmt->fetch()) {
        $lastmod = !empty($row['updated_at']) ? $row['updated_at'] : $row['created_at'];
        $portfolioPages[] = [
            'loc'        => SITE_URL . '/demo/' . rawurlencode($row['slug']),
            'changefreq' => 'monthly',
            'priority'   => '0.7',
            'lastmod'    => min(date('Y-m-d', strtotime($lastmod)), $sitemapToday),
        ];
    }
} catch (PDOException $e) {
    // Silently skip
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
        'lastmod'    => sitemap_file_lastmod('blog/' . $static['slug'] . '.php', $sitemapToday),
    ];
}

// ── Output XML ────────────────────────────────────────────────────
echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
        http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
<?php foreach (array_merge($staticPages, $portfolioPages, $blogPosts) as $url): ?>
  <url>
    <loc><?php echo htmlspecialchars($url['loc']); ?></loc>
    <lastmod><?php echo $url['lastmod']; ?></lastmod>
    <changefreq><?php echo $url['changefreq']; ?></changefreq>
    <priority><?php echo $url['priority']; ?></priority>
  </url>
<?php endforeach; ?>
</urlset>
