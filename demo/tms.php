<?php
require __DIR__ . '/../includes/config.php';
require __DIR__ . '/../includes/db.php';

$slug = 'tms';

$stmt = $pdo->prepare('SELECT * FROM portfolios WHERE slug = ?');
$stmt->execute([$slug]);
$portfolio = $stmt->fetch();

if (!$portfolio) {
    header('Location: ' . BASE_PATH . '/#portfolio');
    exit;
}

$page['title']       = htmlspecialchars($portfolio['title']) . ' Demo — ' . SITE_NAME;
$page['description'] = htmlspecialchars($portfolio['short_description']);
$page['canonical']   = SITE_URL . '/demo/' . $slug;
$page['og_title']    = $page['title'];
$page['og_desc']     = $page['description'];
$page['active_nav']  = 'portfolio';
$page['robots']      = 'noindex, nofollow';

include __DIR__ . '/_template.php';
