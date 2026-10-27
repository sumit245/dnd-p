<?php
require __DIR__ . '/../includes/config.php';
require __DIR__ . '/../includes/db.php';

$slug = trim($_GET['slug'] ?? '');
if (!$slug) {
    header('Location: ' . BASE_PATH . '/portfolio');
    exit;
}

$stmt = $pdo->prepare('SELECT * FROM portfolios WHERE slug = ?');
$stmt->execute([$slug]);
$portfolio = $stmt->fetch();

require_once __DIR__ . '/../includes/portfolio-taxonomy.php';
// Client-only entries (no demo, no write-up) have nothing to show here.
if (!$portfolio || !portfolio_has_detail($portfolio)) {
    header('Location: ' . BASE_PATH . '/portfolio', true, 302);
    exit;
}

// Per-slug SEO overrides keep the <title> and meta description inside SERP
// limits without touching the H1, which still comes from portfolios.title.
$seoOverrides = include __DIR__ . '/../includes/demo-seo.php';
$seo          = $seoOverrides[$slug] ?? [];

$page['title']       = $seo['title'] ?? ($portfolio['title'] . ' | ' . SITE_NAME);
$page['description'] = $seo['description'] ?? $portfolio['short_description'];
$page['canonical']   = SITE_URL . '/demo/' . $slug;
$page['og_title']    = $page['title'];
$page['og_desc']     = $page['description'];
$page['active_nav']  = 'portfolio';
if (!empty($portfolio['image_path'])) {
    require_once __DIR__ . '/../includes/portfolio-media.php';
    $page['og_image'] = SITE_URL . (asset_public_path($portfolio['image_path']) ?? '/assets/img/og-image.jpg');
}
// Pages with real content are indexable; an empty placeholder entry stays out of the index.
// Graphics entries are one image and a caption: too thin to rank, and they
// dilute the product pages, so they stay linked from /portfolio but out of the
// index (sitemap.php excludes them for the same reason).
$hasContent = trim(strip_tags((string)($portfolio['detailed_description'] ?? ''))) !== '';
$isGraphics = ($portfolio['category'] ?? '') === 'graphics';
$page['robots']      = (!$isGraphics && (!empty($portfolio['demo_url']) || $hasContent)) ? 'index, follow' : 'noindex, nofollow';

// ── Structured data ───────────────────────────────────────────────
// These are the most commercial pages on the site and shipped with no schema
// at all. Emitted through $page['jsonld'] so head.php renders them inside
// <head>, which keeps _template.php (and its FAQPage block) untouched.
require_once __DIR__ . '/../includes/schema-breadcrumb.php';
$page['jsonld'][] = breadcrumb_schema_jsonld(breadcrumb_schema([
    ['name' => 'Portfolio', 'url' => '/portfolio'],
    ['name' => $portfolio['title'], 'url' => '/demo/' . $slug],
]));

// Product pages describe software; graphics entries are design work, so they
// get the breadcrumb only. No `offers` block anywhere: there is no public
// price, and an invented one is worse than none.
if (!$isGraphics) {
    require_once __DIR__ . '/../includes/service-schema.php';

    $appSchema = [
        '@context'            => 'https://schema.org',
        '@type'               => 'SoftwareApplication',
        '@id'                 => SITE_URL . '/demo/' . $slug . '#software',
        'name'                => $portfolio['title'],
        'description'         => $portfolio['short_description'],
        'url'                 => SITE_URL . '/demo/' . $slug,
        'applicationCategory' => 'BusinessApplication',
        'operatingSystem'     => ($portfolio['category'] ?? '') === 'mobile' ? 'Android' : 'Web browser',
        'provider'            => service_schema_provider(),
    ];
    if (!empty($page['og_image'])) {
        $appSchema['screenshot'] = $page['og_image'];
    }
    if (!empty($portfolio['demo_url'])) {
        $appSchema['installUrl'] = $portfolio['demo_url'];
    }

    $page['jsonld'][] = schema_jsonld($appSchema);
}

include __DIR__ . '/_template.php';
