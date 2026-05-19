<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/portfolio-media.php';

$stmt = $pdo->query('SELECT * FROM blogs WHERE status = \'published\' ORDER BY created_at DESC');
$blogs = $stmt->fetchAll();

// Helper: compute read time
function getReadTime($blog) {
    if (!empty($blog['read_time'])) return (int)$blog['read_time'];
    $words = str_word_count(strip_tags($blog['content'] ?? ''));
    return max(1, (int)ceil($words / 200));
}

$page['title'] = 'Blog & Insights — ' . SITE_NAME;
$page['description'] = 'Read our latest insights, case studies, and guides on custom software development, ERP, CRM, and digital transformation for SMEs.';
$page['canonical'] = SITE_URL . '/blog/';
$page['og_title'] = 'Blog & Insights — ' . SITE_NAME;
$page['og_desc'] = 'Insights, guides and case studies on ERP, CRM, TMS and custom software development. Expert perspectives from Dashandots Technology, India.';
$page['og_image'] = SITE_URL . '/assets/img/og-image.jpg';
$page['active_nav'] = 'blog';

$schemaCollection = [
    'name' => 'Blog & Insights — ' . SITE_NAME,
    'description' => 'Insights, case studies, and guides on ERP, CRM, TMS, and custom software for growing businesses.',
    'url' => SITE_URL . '/blog/',
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php include __DIR__ . '/../includes/head.php'; ?>
<?php include __DIR__ . '/../includes/schema-collection-page.php'; ?>
<?php
$firstLcpImage = '';
if (!empty($blogs[0]['feature_image'])) {
    $firstLcpImage = absolute_public_url($blogs[0]['feature_image']);
}
?>
<?php if ($firstLcpImage !== ''): ?>
    <link rel="preload" as="image" href="<?= htmlspecialchars($firstLcpImage, ENT_QUOTES, 'UTF-8') ?>">
<?php endif; ?>
    <style>
        /* ═══════════════════════════════════════════
           BLOG LISTING — STYLES
        ═══════════════════════════════════════════ */

        .blog-header {
            padding: 100px 0 60px;
            background: var(--surface-2);
            text-align: center;
        }
        .blog-title {
            font-size: 42px;
            font-weight: 800;
            color: var(--text-1);
            margin-bottom: 20px;
        }

        /* ── Grid ─────────────────────────────────── */
        .blog-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
            gap: 30px;
            padding: 60px 0;
        }
        @media (max-width: 400px) {
            .blog-grid { grid-template-columns: 1fr; }
        }

        /* ── Card ─────────────────────────────────── */
        .blog-card {
            background: var(--surface-1);
            border-radius: var(--r-md);
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: flex;
            flex-direction: column;
        }
        .blog-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 24px rgba(0,0,0,0.1);
        }

        /* ── Thumbnail ────────────────────────────── */
        .blog-thumb {
            height: 200px;
            background: var(--surface-2);
            position: relative;
            overflow: hidden;
        }
        .blog-thumb a { display: block; height: 100%; }
        .blog-thumb img {
            width: 100%; height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }
        .blog-card:hover .blog-thumb img { transform: scale(1.05); }

        /* ── Category pill on image ───────────────── */
        .blog-cat-pill {
            position: absolute;
            top: 12px; left: 12px;
            background: rgba(0,0,0,.6);
            backdrop-filter: blur(6px);
            color: #fff;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .04em;
            padding: 4px 10px;
            border-radius: 20px;
            z-index: 1;
        }

        /* ── Body ─────────────────────────────────── */
        .blog-body {
            padding: 22px 24px 0;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        /* ── Meta row (date + read time) ──────────── */
        .blog-meta {
            display: flex;
            align-items: center;
            gap: 14px;
            font-size: 13px;
            color: var(--text-2);
            margin-bottom: 10px;
            font-weight: 500;
        }
        .blog-meta-sep {
            width: 3px; height: 3px;
            border-radius: 50%;
            background: var(--text-2);
            opacity: .5;
        }
        .blog-rt {
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        .blog-rt svg { color: var(--accent); flex-shrink: 0; }

        /* ── Title ────────────────────────────────── */
        .blog-h3 {
            font-size: 20px;
            font-weight: 700;
            margin: 0 0 12px 0;
            color: var(--text-1);
            line-height: 1.4;
        }
        .blog-h3 a {
            color: inherit;
            text-decoration: none;
            transition: color .2s;
        }
        .blog-card:hover .blog-h3 a { color: var(--accent); }

        /* ── Excerpt ──────────────────────────────── */
        .blog-excerpt {
            color: var(--text-2);
            line-height: 1.6;
            flex-grow: 1;
            font-size: 15px;
            margin-bottom: 0;
        }

        /* ── Card footer ─────────────────────────── */
        .blog-card-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 24px;
            margin-top: auto;
            border-top: 1px solid var(--border);
        }
        .blog-readmore {
            color: var(--accent);
            font-weight: 600;
            text-decoration: none;
            font-size: 14px;
            transition: gap .2s;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        .blog-readmore:hover { gap: 8px; text-decoration: underline; }

        /* ── Share buttons ────────────────────────── */
        .blog-share {
            display: flex;
            align-items: center;
            gap: 2px;
        }
        .share-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 32px; height: 32px;
            border: none;
            background: transparent;
            border-radius: 6px;
            cursor: pointer;
            color: var(--text-2);
            transition: all .2s;
            padding: 0;
            text-decoration: none;
        }
        .share-btn:hover { background: var(--surface-2); color: var(--accent); }
        .share-btn svg { width: 16px; height: 16px; }

        /* X/Twitter hover */
        .share-btn.x:hover { color: #000; }
        /* LinkedIn hover */
        .share-btn.li:hover { color: #0a66c2; }
        /* WhatsApp hover */
        .share-btn.wa:hover { color: #25d366; }
        /* Copy hover */
        .share-btn.cp:hover { color: var(--accent); }

        /* Copy tooltip */
        .share-btn.cp { position: relative; }
        .share-btn.cp .cp-tip {
            position: absolute;
            bottom: calc(100% + 6px);
            left: 50%;
            transform: translateX(-50%) scale(0.8);
            background: var(--text-1);
            color: #fff;
            font-size: 11px;
            font-weight: 600;
            padding: 4px 8px;
            border-radius: 4px;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: opacity .2s, transform .2s;
        }
        .share-btn.cp .cp-tip.show {
            opacity: 1;
            transform: translateX(-50%) scale(1);
        }
    </style>
</head>
<body>
    <?php include __DIR__ . '/../includes/header.php'; ?>

    <main id="main-content" tabindex="-1">
        <section class="blog-header">
            <div class="container">
                <p class="section-label" style="justify-content:center;">Insights</p>
                <h1 class="blog-title">Blog & Case Studies</h1>
                <p style="font-size: 18px; color: var(--text-2); max-width: 600px; margin: 0 auto;">Thoughts, guides, and stories about building technology for growing businesses.</p>
            </div>
        </section>

        <section class="container">
            <div class="blog-grid">
                <?php if (!empty($blogs)): ?>
                    <?php foreach ($blogs as $loopIndex => $blog):
                        $postUrl  = SITE_URL . '/blog/' . urlencode($blog['slug']);
                        $readTime = getReadTime($blog);
                        $postTitle = htmlspecialchars($blog['title']);
                        $encodedTitle = urlencode($blog['title']);
                        $encodedUrl   = urlencode($postUrl);
                    ?>
                        <div class="blog-card">
                            <!-- Thumbnail -->
                            <div class="blog-thumb">
                                <?php if (!empty($blog['category'])): ?>
                                    <span class="blog-cat-pill"><?php echo htmlspecialchars($blog['category']); ?></span>
                                <?php endif; ?>
                                <a href="<?php echo public_href('/blog/' . urlencode($blog['slug'])); ?>">
                                    <?php if (!empty($blog['feature_image'])): ?>
                                        <?php
                                        echo content_image_html(
                                            absolute_public_url($blog['feature_image']),
                                            $blog['title'],
                                            [
                                                'loading' => $loopIndex === 0 ? 'eager' : 'lazy',
                                                'fetchpriority' => $loopIndex === 0 ? 'high' : '',
                                                'style' => 'width:100%;height:100%;object-fit:cover',
                                            ]
                                        );
                                        ?>
                                    <?php else: ?>
                                        <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; color: var(--text-2); font-weight: 600; font-size: 18px;">Dashandots</div>
                                    <?php endif; ?>
                                </a>
                            </div>

                            <!-- Body -->
                            <div class="blog-body">
                                <div class="blog-meta">
                                    <span><?php echo date('M j, Y', strtotime($blog['created_at'])); ?></span>
                                    <span class="blog-meta-sep"></span>
                                    <span class="blog-rt">
                                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                        <?php echo $readTime; ?> min read
                                    </span>
                                </div>

                                <h3 class="blog-h3">
                                    <a href="<?php echo public_href('/blog/' . urlencode($blog['slug'])); ?>"><?php echo $postTitle; ?></a>
                                </h3>

                                <p class="blog-excerpt">
                                    <?php
                                        $plainText = strip_tags($blog['content']);
                                        echo htmlspecialchars(mb_strimwidth($plainText, 0, 140, '…'));
                                    ?>
                                </p>
                            </div>

                            <!-- Footer: Read more + Share -->
                            <div class="blog-card-footer">
                                <a href="<?php echo public_href('/blog/' . urlencode($blog['slug'])); ?>" class="blog-readmore">
                                    Read Article <span>&rarr;</span>
                                </a>
                                <div class="blog-share">
                                    <!-- X / Twitter -->
                                    <a href="https://twitter.com/intent/tweet?text=<?php echo $encodedTitle; ?>&url=<?php echo $encodedUrl; ?>"
                                       target="_blank" rel="noopener" class="share-btn x" title="Share on X" aria-label="Share on X">
                                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                                    </a>
                                    <!-- LinkedIn -->
                                    <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo $encodedUrl; ?>"
                                       target="_blank" rel="noopener" class="share-btn li" title="Share on LinkedIn" aria-label="Share on LinkedIn">
                                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                                    </a>
                                    <!-- WhatsApp -->
                                    <a href="https://api.whatsapp.com/send?text=<?php echo $encodedTitle . '%20' . $encodedUrl; ?>"
                                       target="_blank" rel="noopener" class="share-btn wa" title="Share on WhatsApp" aria-label="Share on WhatsApp">
                                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                    </a>
                                    <!-- Copy Link -->
                                    <button type="button" class="share-btn cp" title="Copy link" aria-label="Copy link"
                                            onclick="copyShareLink(this, '<?php echo htmlspecialchars($postUrl, ENT_QUOTES); ?>')">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
                                        <span class="cp-tip">Copied!</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="text-align:center; grid-column: 1 / -1; padding: 60px 0; color: var(--text-2); font-size: 18px;">New articles coming soon.</p>
                <?php endif; ?>
            </div>
        </section>
    </main>

    <?php include __DIR__ . '/../includes/footer.php'; ?>
<?php include __DIR__ . '/../includes/scripts.php'; ?>

    <script>
    function copyShareLink(btn, url) {
        navigator.clipboard.writeText(url).then(() => {
            const tip = btn.querySelector('.cp-tip');
            tip.classList.add('show');
            setTimeout(() => tip.classList.remove('show'), 1800);
        });
    }
    </script>
</body>
</html>
