  <meta charset="UTF-8">
<?php require_once __DIR__ . '/assets.php'; ?>
<?php require_once __DIR__ . '/env.php'; ?>
<?php include __DIR__ . '/consent-mode.php'; ?>
<?php include __DIR__ . '/gtm-head.php'; ?>
<?php include __DIR__ . '/clarity.php'; ?>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($page['title']) ?></title>
  <meta name="description" content="<?= htmlspecialchars($page['description']) ?>">
<?php if (!empty($page['keywords'])): ?>
  <meta name="keywords" content="<?= htmlspecialchars($page['keywords']) ?>">
<?php endif; ?>
  <meta name="author" content="<?= SITE_NAME ?>">
<?php
  $robotsMeta = $page['robots'] ?? 'index, follow';
?>
  <meta name="robots" content="<?= htmlspecialchars($robotsMeta, ENT_QUOTES, 'UTF-8') ?>">
<?php
  $gscVerify = site_env('GOOGLE_SITE_VERIFICATION', defined('GOOGLE_SITE_VERIFICATION') ? GOOGLE_SITE_VERIFICATION : '');
  if ($gscVerify !== ''):
?>
  <meta name="google-site-verification" content="<?= htmlspecialchars($gscVerify, ENT_QUOTES, 'UTF-8') ?>">
<?php endif; ?>
  <link rel="canonical" href="<?= htmlspecialchars($page['canonical']) ?>">

  <!-- Open Graph -->
<?php $ogType = $page['og_type'] ?? 'website'; ?>
  <meta property="og:type" content="<?= htmlspecialchars($ogType, ENT_QUOTES, 'UTF-8') ?>">
  <meta property="og:url" content="<?= htmlspecialchars($page['canonical']) ?>">
  <meta property="og:title" content="<?= htmlspecialchars($page['og_title'] ?? $page['title']) ?>">
  <meta property="og:description" content="<?= htmlspecialchars($page['og_desc'] ?? $page['description']) ?>">
  <meta property="og:image" content="<?= htmlspecialchars($page['og_image']) ?>">
  <meta property="og:site_name" content="<?= SITE_NAME ?>">
  <meta property="og:locale" content="en_IN">
<?php if ($ogType === 'article' && !empty($page['article_section'])): ?>
  <meta property="article:section" content="<?= htmlspecialchars($page['article_section'], ENT_QUOTES, 'UTF-8') ?>">
<?php endif; ?>
<?php if ($ogType === 'article' && !empty($page['article_published'])): ?>
  <meta property="article:published_time" content="<?= htmlspecialchars($page['article_published'], ENT_QUOTES, 'UTF-8') ?>">
<?php endif; ?>
<?php if ($ogType === 'article' && !empty($page['article_modified'])): ?>
  <meta property="article:modified_time" content="<?= htmlspecialchars($page['article_modified'], ENT_QUOTES, 'UTF-8') ?>">
<?php endif; ?>

  <!-- Twitter Card -->
  <meta name="twitter:card" content="summary_large_image">
<?php if (defined('TWITTER_SITE') && TWITTER_SITE !== ''): ?>
  <meta name="twitter:site" content="<?= htmlspecialchars(TWITTER_SITE, ENT_QUOTES, 'UTF-8') ?>">
<?php endif; ?>
  <meta name="twitter:title" content="<?= htmlspecialchars($page['og_title'] ?? $page['title']) ?>">
  <meta name="twitter:description" content="<?= htmlspecialchars($page['og_desc'] ?? $page['description']) ?>">
  <meta name="twitter:image" content="<?= htmlspecialchars($page['og_image']) ?>">

  <!-- Favicon -->
  <link rel="icon" href="<?= BASE_PATH ?>/assets/logo.png" type="image/png">
  <link rel="apple-touch-icon" href="<?= BASE_PATH ?>/assets/logo.png">

  <!-- Fonts -->
  <link rel="preload"
    href="https://fonts.gstatic.com/s/inter/v13/UcCO3FwrK3iLTeHuS_fvQtMwCp50KnMw2boKoduKmMEVuLyfAZ9hiJ-Ek-_EeA.woff2"
    as="font" type="font/woff2" crossorigin>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet">

  <!-- Stylesheet -->
  <link rel="stylesheet" href="<?= asset_css_href() ?>">
