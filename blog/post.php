<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/portfolio-media.php';

$slug = $_GET['slug'] ?? '';
if (!$slug) {
    site_redirect('/blog/');
}

$stmt = $pdo->prepare('SELECT * FROM blogs WHERE slug = ? AND status = \'published\'');
$stmt->execute([$slug]);
$blog = $stmt->fetch();

if (!$blog) {
    site_redirect('/blog/');
}

$canonicalUrl = SITE_URL . '/blog/' . rawurlencode($slug);
$excerpt = mb_strimwidth(strip_tags($blog['content']), 0, 150, '...');
$ogImage = !empty($blog['feature_image'])
    ? absolute_public_url($blog['feature_image'])
    : SITE_URL . '/assets/img/og-image.jpg';
$featureImageSrc = !empty($blog['feature_image'])
    ? absolute_public_url($blog['feature_image'])
    : '';
$publishedIso = date('c', strtotime($blog['created_at']));
$modifiedIso = date('c', strtotime($blog['updated_at'] ?? $blog['created_at']));

$page['title'] = $blog['title'] . ' — Dashandots Blog';
$page['description'] = $excerpt;
$page['canonical'] = $canonicalUrl;
$page['og_title'] = $blog['title'];
$page['og_desc'] = $excerpt;
$page['og_image'] = $ogImage;
$page['og_type'] = 'article';
$page['article_section'] = $blog['category'] ?? '';
$page['article_published'] = $publishedIso;
$page['article_modified'] = $modifiedIso;
$page['active_nav'] = 'blog';
if (!empty($blog['keywords'])) {
    $page['keywords'] = $blog['keywords'];
}

$schemaBlog = [
    'headline' => $blog['title'],
    'description' => $excerpt,
    'url' => $canonicalUrl,
    'datePublished' => $blog['created_at'],
    'dateModified' => $blog['updated_at'] ?? $blog['created_at'],
    'image' => $ogImage,
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php include __DIR__ . '/../includes/head.php'; ?>
<?php include __DIR__ . '/../includes/schema-blog-posting.php'; ?>
<?php if ($ogImage !== ''): ?>
    <link rel="preload" as="image" href="<?= htmlspecialchars($ogImage, ENT_QUOTES, 'UTF-8') ?>">
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

    <main id="main-content" class="container" tabindex="-1">
        <article>
            <header class="post-header">
                <span class="post-date">
                    Published <?php echo date('F j, Y', strtotime($blog['created_at'])); ?>
                    <?php if (!empty($blog['updated_at']) && strtotime($blog['updated_at']) > strtotime($blog['created_at'])): ?>
                        · Updated <?php echo date('F j, Y', strtotime($blog['updated_at'])); ?>
                    <?php endif; ?>
                </span>
                <h1 class="post-title"><?php echo htmlspecialchars($blog['title']); ?></h1>
            </header>

            <?php if ($featureImageSrc !== ''): ?>
                <?php
                echo content_image_html(
                    $featureImageSrc,
                    $blog['title'],
                    [
                        'loading' => 'eager',
                        'fetchpriority' => 'high',
                        'class' => 'post-feature-img',
                        'style' => 'width:100%;max-width:1000px;height:auto;margin:0 auto 60px;display:block;border-radius:var(--r-md);box-shadow:0 10px 30px rgba(0,0,0,0.1);object-fit:cover',
                    ]
                );
                ?>
            <?php endif; ?>

            <div class="post-content">
                <?php echo $blog['content']; ?>
            </div>
        </article>

        <section class="mid-cta" aria-label="Related service links">
            <div>
                <h3>Turn this idea into a working business system</h3>
                <p>Explore ERP/CRM implementation, industry systems, demos, or generate a quick project estimate.</p>
            </div>
            <div class="hero-actions">
                <a href="<?= public_href('/services/erp-development/') ?>" class="btn btn-primary" data-track="cta" data-cta-location="blog-related">ERP/CRM Services</a>
                <a href="<?= public_href('/#ai-brief') ?>" class="btn btn-outline" data-track="cta" data-cta-location="blog-related">Get Estimate</a>
            </div>
        </section>

        <div style="text-align: center; margin-bottom: 80px; padding-top: 40px; border-top: 1px solid var(--border);">
            <a href="<?= public_href('/blog/') ?>" class="btn btn-outline">&larr; Back to all articles</a>
        </div>
    </main>

    <?php include __DIR__ . '/../includes/footer.php'; ?>
<?php include __DIR__ . '/../includes/scripts.php'; ?>
</body>
</html>
