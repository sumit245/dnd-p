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

$page['title']       = $portfolio['title'] . ' — ' . SITE_NAME;
$page['description'] = $portfolio['short_description'];
$page['canonical']   = SITE_URL . '/demo/' . $slug;
$page['og_title']    = $page['title'];
$page['og_desc']     = $page['description'];
$page['active_nav']  = 'portfolio';
if (!empty($portfolio['image_path'])) {
    require_once __DIR__ . '/../includes/portfolio-media.php';
    $page['og_image'] = SITE_URL . (asset_public_path($portfolio['image_path']) ?? '/assets/img/og-image.jpg');
}
// Pages with real content are indexable; an empty placeholder entry stays out of the index.
$hasContent = trim(strip_tags((string)($portfolio['detailed_description'] ?? ''))) !== '';
$page['robots']      = (!empty($portfolio['demo_url']) || $hasContent) ? 'index, follow' : 'noindex, nofollow';

include __DIR__ . '/_template.php';
