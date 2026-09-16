<?php
require __DIR__ . '/includes/config.php';
require __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/portfolio-media.php';
require_once __DIR__ . '/includes/portfolio-taxonomy.php';

$active = portfolio_requested_industry();
$rows = $pdo->query('SELECT * FROM portfolios ORDER BY sort_order ASC, created_at ASC')->fetchAll();

$visibleCount = 0;
foreach ($rows as $r) {
  if ($active === 'all' || ($r['industry'] ?? '') === $active) {
    $visibleCount++;
  }
}

$page['title'] = 'ERP, CRM & Mobile Systems — Live Demos | ' . SITE_NAME;
$page['description'] = '30+ systems running in production — ERP, CRM, transport, mobile apps. Browse projects by industry, try live demos, or start yours.';
$page['canonical'] = SITE_URL . '/portfolio';
$page['og_title'] = $page['title'];
$page['og_desc'] = $page['description'];
$page['active_nav'] = 'portfolio';
$page['extra_css'] = ['/assets/css/portfolio.css'];
$page['extra_js'] = ['/assets/js/portfolio.js'];
$page['preload_fonts'] = ['/assets/fonts/ArchivoBlack-Regular.woff2'];

$schemaCollection = [
  'name' => 'Dashandots Portfolio',
  'description' => $page['description'],
  'url' => $page['canonical'],
];

$itemList = [];
foreach ($rows as $i => $r) {
  $link = portfolio_card_link($r);
  if (!$link) {
    continue;
  }
  $itemList[] = [
    '@type' => 'ListItem',
    'position' => count($itemList) + 1,
    'name' => $r['title'],
    'url' => $link['external'] ? $link['href'] : SITE_URL . '/demo/' . rawurlencode($r['slug']),
  ];
}

$h = static fn($v): string => htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php include __DIR__ . '/includes/head.php'; ?>
  <?php include __DIR__ . '/includes/schema-collection-page.php'; ?>
  <script type="application/ld+json">
<?= json_encode(['@context' => 'https://schema.org', '@type' => 'ItemList', 'name' => 'Dashandots portfolio', 'itemListElement' => $itemList], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?>
  </script>
</head>

<body>

  <?php include __DIR__ . '/includes/header.php'; ?>

  <main id="main-content">
    <div class="pf">
      <div class="pf-wrap">

        <div class="pf-head">
          <div class="pf-sechead">
            <p class="pf-micro pf-meta"><span>[ 01 ]</span> Portfolio</p>
            <h1 class="pf-display">Systems in<br>daily use<span class="pf-accent">.</span></h1>
            <p class="pf-lead">Custom ERP, CRM, logistics, and mobile systems we built for Indian businesses — and still support. Browse by industry or try a live demo.</p>
            <!-- <p class="pf-micro" id="pf-count" aria-live="polite"><?= (int) $visibleCount ?> <?= $visibleCount === 1 ? 'project' : 'projects' ?></p> -->
          </div>
          <div class="pf-filters" role="group" aria-label="Filter portfolio by industry">
            <button class="pf-chip<?= $active === 'all' ? ' is-active' : '' ?>" type="button" data-filter="all"
              aria-pressed="<?= $active === 'all' ? 'true' : 'false' ?>">All</button>
            <?php foreach (portfolio_industries() as $slug => $label): ?>
              <button class="pf-chip<?= $active === $slug ? ' is-active' : '' ?>" type="button"
                data-filter="<?= $h($slug) ?>"
                aria-pressed="<?= $active === $slug ? 'true' : 'false' ?>"><?= $h($label) ?></button>
            <?php endforeach; ?>
          </div>
        </div>

        <div class="pf-grid" id="pf-grid">
          <?php $shown = 0; ?>
          <?php foreach ($rows as $index => $row): ?>
            <?php
            $show = $active === 'all' || ($row['industry'] ?? '') === $active;
            $link = portfolio_card_link($row);
            $imgMeta = !empty($row['image_path']) ? portfolio_image_meta($row['image_path']) : null;
            $hasImg = $imgMeta !== null;
            $delay = $show ? ($shown % 6) * 60 : 0;
            if ($show) {
              $shown++;
            }
            $badge = trim((string) ($row['badge'] ?? '')) !== '' ? $row['badge'] : strtoupper($row['slug']);
            $meta = trim(portfolio_industry_label($row['industry'] ?? null) . ' · ' . ($row['client_name'] ?: 'Live demo'), ' ·');
            $ariaLbl = $link ? $link['label'] . ': ' . $row['title'] : $row['title'];

            // Tile shape (see portfolio.css unit system):
            //   d desktop 4×3 (16:9) · p portrait 2×4 (9:16) · q square 2×2 · l landscape 2×1
            $cat = $row['category'] ?? '';
            $ratio = $hasImg && $imgMeta['height'] > 0 ? $imgMeta['width'] / $imgMeta['height'] : 1;
            if ($cat === 'mobile') {
              $shape = 'p';
            } elseif ($cat === 'graphics') {
              $shape = $ratio >= 1.5 ? 'l' : ($ratio <= 0.8 ? 'p' : 'q');
            } else {
              $shape = 'd'; // desktop systems keep their slot even before a screenshot is uploaded
            }
            $large = in_array($shape, ['d', 'p'], true);
            // Phone plates prefer a single portrait screenshot ({slug}-portrait.png) over the landscape composite.
            $imgPath = $row['image_path'];
            if ($shape === 'p' && $hasImg) {
              $portrait = preg_replace('/\.(png|jpe?g)$/i', '-portrait.$1', $row['image_path']);
              if ($portrait && portfolio_image_meta($portrait)) {
                $imgPath = $portrait;
              }
            }
            $tag = $link ? 'a' : 'div';
            ?>
            <article class="pf-tile pf-tile--<?= $shape ?> reveal" data-industry="<?= $h($row['industry'] ?? '') ?>"
              data-slug="<?= $h($row['slug']) ?>" data-shape="<?= $shape ?>"
              style="--c:<?= $h(portfolio_tile_color($row)) ?>;--reveal-delay:<?= $delay ?>ms" <?= $show ? '' : ' hidden' ?>
              <?= $large ? '' : ' title="' . $h($row['title']) . '"' ?>>
              <<?= $tag ?> class="pf-tile__link"<?= $link ? ' href="' . $h($link['href']) . '"' . ($link['external'] ? ' target="_blank" rel="noopener noreferrer"' : '') . ' aria-label="' . $h($ariaLbl) . '" data-track="' . ($link['external'] ? 'cta' : 'demo') . '" data-cta-location="portfolio-page" data-demo-slug="' . $h($row['slug']) . '"' : ' aria-label="' . $h($row['title']) . '"' ?>>
                <div class="pf-tile__frame">
                  <?php if ($hasImg): ?>
                    <?= portfolio_picture_html($imgPath, $row['title'] . ' screenshot', ['class' => 'pf-media', 'style' => '']) ?>
                  <?php else: ?>
                    <div class="pf-initials" aria-hidden="true">
                      <span><?= $h(portfolio_initials($row)) ?></span>
                      <em><?= $h($row['client_name'] ?: $row['title']) ?></em>
                    </div>
                  <?php endif; ?>
                </div>
                <span class="pf-tile__tl"><?= $h($badge) ?></span>
                <span class="pf-tile__tr"><?= str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) ?></span>
                <?php if ($large): ?>
                  <div class="pf-tile__cap">
                    <div>
                      <h2 class="pf-tile__title"><?= $h($row['title']) ?></h2>
                      <p class="pf-micro"><?= $h($meta) ?></p>
                    </div>
                    <?php if ($link): ?><span class="pf-link"><?= $h($link['label']) ?> &rarr;</span><?php endif; ?>
                  </div>
                <?php endif; ?>
              </<?= $tag ?>>
            </article>
          <?php endforeach; ?>

          <!-- CTA plate: always visible, drops into the last gap of the grid -->
          <article class="pf-tile pf-tile--c reveal" data-cta>
            <div class="pf-cta">
              <h2>Need something<br>like this<span>?</span></h2>
              <div>
                <a href="<?= BASE_PATH ?>/#contact" data-track="cta" data-cta-location="portfolio-page">Start your project</a>
                <a href="<?= BASE_PATH ?>/#ai-brief" data-track="cta" data-cta-location="portfolio-page">Get a free brief</a>
              </div>
            </div>
          </article>
        </div>

        <p class="pf-empty pf-micro" id="pf-empty" <?= $visibleCount > 0 ? ' hidden' : '' ?>>No projects in this industry
          yet — ask us, we have probably built something close.</p>

      </div>
    </div>
  </main>

  <?php include __DIR__ . '/includes/footer.php'; ?>
  <?php include __DIR__ . '/includes/scripts.php'; ?>

</body>

</html>