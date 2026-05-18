<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/db.php';

$slug = $_GET['slug'] ?? '';
if (!$slug) {
    header('Location: ' . BASE_PATH . '/blog/');
    exit;
}

$stmt = $pdo->prepare('SELECT * FROM blogs WHERE slug = ? AND status = \'published\'');
$stmt->execute([$slug]);
$blog = $stmt->fetch();

if (!$blog) {
    header('Location: ' . BASE_PATH . '/blog/');
    exit;
}

// Ensure proper SEO URL structure dynamically using host
$baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
$currentUrl = $baseUrl . $_SERVER['REQUEST_URI'];
// Canonical uses production domain + clean /blog/{slug} path (T-03)
$canonicalUrl = SITE_URL . '/blog/' . rawurlencode($slug);
// OG image — always absolute URL, strip BASE_PATH prefix (T-09)
// Stored paths use /dashandots/ prefix for localhost; on production the site is at root.
$ogImage = '';
if (!empty($blog['feature_image'])) {
    $fi = $blog['feature_image'];
    if (strpos($fi, 'http') === 0) {
        $ogImage = $fi; // already absolute
    } else {
        // Strip BASE_PATH (/dashandots) from relative path so production URL is correct
        if (!empty(BASE_PATH) && strpos($fi, BASE_PATH . '/') === 0) {
            $fi = substr($fi, strlen(BASE_PATH));
        }
        $ogImage = SITE_URL . $fi;
    }
} else {
    $ogImage = SITE_URL . '/assets/img/og-image.jpg';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php include __DIR__ . '/../includes/gtm-head.php'; ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($blog['title']); ?> - Dashandots Blog</title>
    
    <!-- Basic SEO -->
    <meta name="description" content="<?php echo htmlspecialchars(mb_strimwidth(strip_tags($blog['content']), 0, 150, '...')); ?>">
    <?php if (!empty($blog['keywords'])): ?>
    <meta name="keywords" content="<?php echo htmlspecialchars($blog['keywords']); ?>">
    <?php endif; ?>
    <link rel="canonical" href="<?php echo htmlspecialchars($canonicalUrl); ?>">
    <meta name="robots" content="index, follow">

    <!-- Open Graph (Facebook/LinkedIn) -->
    <meta property="og:type" content="article">
    <meta property="og:title" content="<?php echo htmlspecialchars($blog['title']); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars(mb_strimwidth(strip_tags($blog['content']), 0, 150, '...')); ?>">
    <meta property="og:url" content="<?php echo htmlspecialchars($canonicalUrl); ?>">
    <meta property="og:image" content="<?php echo htmlspecialchars($ogImage); ?>">
    <?php if (!empty($blog['category'])): ?>
    <meta property="article:section" content="<?php echo htmlspecialchars($blog['category']); ?>">
    <?php endif; ?>

    <!-- Twitter Cards -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo htmlspecialchars($blog['title']); ?>">
    <meta name="twitter:description" content="<?php echo htmlspecialchars(mb_strimwidth(strip_tags($blog['content']), 0, 150, '...')); ?>">
    <meta name="twitter:image" content="<?php echo htmlspecialchars($ogImage); ?>">

    <!-- Article Schema (AEO/SEO) -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "BlogPosting",
      "mainEntityOfPage": {
        "@type": "WebPage",
        "@id": "<?php echo htmlspecialchars($canonicalUrl); ?>"
      },
      "headline": "<?php echo htmlspecialchars($blog['title']); ?>",
      "image": ["<?php echo htmlspecialchars($ogImage); ?>"],
      <?php if (!empty($blog['keywords'])): ?>
      "keywords": "<?php echo htmlspecialchars($blog['keywords']); ?>",
      <?php endif; ?>
      <?php if (!empty($blog['category'])): ?>
      "articleSection": "<?php echo htmlspecialchars($blog['category']); ?>",
      <?php endif; ?>
      "datePublished": "<?php echo date('c', strtotime($blog['created_at'])); ?>",
      "dateModified": "<?php echo date('c', strtotime($blog['updated_at'] ?? $blog['created_at'])); ?>",
      "author": {
        "@type": "Organization",
        "name": "Dashandots Technology",
        "url": "<?php echo htmlspecialchars(SITE_URL); ?>/"
      },
      "publisher": {
        "@type": "Organization",
        "name": "Dashandots Technology",
        "logo": {
          "@type": "ImageObject",
          "url": "<?php echo htmlspecialchars(SITE_LOGO_URL); ?>"
        }
      }
    }
    </script>

<?php require_once __DIR__ . '/../includes/assets.php'; ?>
    <link rel="stylesheet" href="<?= asset_css_href() ?>">
<?php if (!empty($ogImage)): ?>
    <link rel="preload" as="image" href="<?php echo htmlspecialchars($ogImage); ?>">
<?php endif; ?>
    <style>
        .post-header {
            padding: 80px 0 40px;
            text-align: center;
            max-width: 800px;
            margin: 0 auto;
        }
        .post-date {
            color: var(--accent);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 16px;
            display: block;
        }
        .post-title {
            font-size: 48px;
            font-weight: 800;
            color: var(--text-1);
            line-height: 1.2;
            margin: 0;
        }
        .post-feature-img {
            width: 100%;
            max-width: 1000px;
            margin: 0 auto 60px;
            display: block;
            border-radius: var(--r-md);
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .post-content {
            max-width: 760px;
            margin: 0 auto 80px;
            font-size: 18px;
            line-height: 1.8;
            color: var(--text-1);
        }
        
        /* Rich Text Styling overrides */
        .post-content h2, .post-content h3, .post-content h4 {
            margin-top: 40px;
            margin-bottom: 16px;
            color: var(--text-1);
            line-height: 1.3;
        }
        .post-content h2 { font-size: 32px; font-weight: 800; }
        .post-content h3 { font-size: 24px; font-weight: 700; }
        .post-content p { margin-bottom: 24px; }
        .post-content img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin: 30px 0;
        }
        .post-content a {
            color: var(--accent);
            text-decoration: underline;
        }
        .post-content a:hover {
            color: var(--accent-hover);
        }
        .post-content ul, .post-content ol {
            margin-bottom: 24px;
            padding-left: 24px;
        }
        .post-content li {
            margin-bottom: 10px;
        }
        .post-content blockquote {
            border-left: 4px solid var(--accent);
            margin: 30px 0;
            padding: 20px 24px;
            background: var(--surface-2);
            border-radius: 0 var(--r-sm) var(--r-sm) 0;
            font-style: italic;
            font-size: 20px;
            color: var(--text-2);
        }
        .post-content table {
            width: 100%;
            border-collapse: collapse;
            margin: 30px 0;
        }
        .post-content th, .post-content td {
            border: 1px solid var(--border);
            padding: 12px;
            text-align: left;
        }
        .post-content th {
            background: var(--surface-2);
            font-weight: 600;
        }
    </style>
</head>
<body>
    <?php include __DIR__ . '/../includes/header.php'; ?>

    <main id="main-content" class="container">
        <article>
            <header class="post-header">
                <span class="post-date"><?php echo date('F j, Y', strtotime($blog['created_at'])); ?></span>
                <h1 class="post-title"><?php echo htmlspecialchars($blog['title']); ?></h1>
            </header>

            <?php if (!empty($blog['feature_image'])): ?>
                <img src="<?php echo htmlspecialchars($blog['feature_image']); ?>"
                     alt="<?php echo htmlspecialchars($blog['title']); ?>"
                     class="post-feature-img"
                     fetchpriority="high"
                     decoding="async"
                     width="1000" height="560">
            <?php endif; ?>

            <div class="post-content">
                <?php echo $blog['content']; ?>
            </div>
        </article>

        <div style="text-align: center; margin-bottom: 80px; padding-top: 40px; border-top: 1px solid var(--border);">
            <a href="<?= BASE_PATH ?>/blog/" class="btn btn-outline">&larr; Back to all articles</a>
        </div>
    </main>

    <?php include __DIR__ . '/../includes/footer.php'; ?>
<?php require_once __DIR__ . '/../includes/assets.php'; ?>
<?php include __DIR__ . '/../includes/scripts.php'; ?>
</body>
</html>
