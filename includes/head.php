  <meta charset="UTF-8">
<?php require_once __DIR__ . '/assets.php'; ?>
<?php require_once __DIR__ . '/env.php'; ?>
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
  <link rel="icon" href="<?= asset_url('/assets/logo-64.webp') ?>" type="image/webp">
  <link rel="apple-touch-icon" href="<?= asset_url('/assets/apple-touch-icon.png') ?>">

  <!-- Critical CSS -->
<?php include __DIR__ . '/critical-css.php'; ?>

  <!-- Resource hints -->
<?php if (asset_cdn_base() !== ''): ?>
  <link rel="preconnect" href="<?= htmlspecialchars(asset_cdn_base(), ENT_QUOTES, 'UTF-8') ?>" crossorigin>
<?php endif; ?>

<?php foreach (($page['preload_images'] ?? []) as $preloadImage): ?>
  <link rel="preload" href="<?= htmlspecialchars(asset_url($preloadImage), ENT_QUOTES, 'UTF-8') ?>" as="image" fetchpriority="high">
<?php endforeach; ?>

  <!-- Stylesheet -->
<?php $stylesheetHref = asset_css_href(); ?>
  <link rel="preload" href="<?= htmlspecialchars($stylesheetHref, ENT_QUOTES, 'UTF-8') ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
  <noscript><link rel="stylesheet" href="<?= htmlspecialchars($stylesheetHref, ENT_QUOTES, 'UTF-8') ?>"></noscript>
