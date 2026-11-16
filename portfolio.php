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

$page['title'] = 'ERP, CRM & Mobile System Demos | Dashandots';
$page['description'] = '30+ systems running in production: ERP, CRM, transport, mobile apps. Browse projects by industry, try live demos, or start yours.';
$page['keywords'] = 'ERP software portfolio India, custom CRM case studies, transport management system demo, business software demos India';
$page['canonical'] = SITE_URL . '/portfolio';
$page['og_title'] = $page['title'];
$page['og_desc'] = $page['description'];
$page['active_nav'] = 'portfolio';
$page['extra_css'] = ['/assets/css/portfolio.css'];
$page['extra_js'] = ['/assets/js/portfolio.js'];
$page['preload_fonts'] = ['/assets/fonts/ArchivoBlack-Regular.woff2'];

require_once __DIR__ . '/includes/schema-breadcrumb.php';
$page['jsonld'][] = breadcrumb_schema_jsonld(breadcrumb_schema([
  ['name' => 'Portfolio', 'url' => '/portfolio'],
]));

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
            <p class="pf-lead">Custom ERP, CRM, logistics, and mobile systems we built for Indian businesses; and still support. Browse by industry or try a live demo.</p>
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
          <?php
            // Per-tile custom properties are collected here and emitted as one
            // stylesheet below the grid, so no tile carries a style attribute
            // (SEO audit: "Remove Inline Styles").
            $shown = 0;
            $tileRules = [];
          ?>
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
              <?php $tileRules[$row['slug']] = '--c:' . portfolio_tile_color($row) . ';--reveal-delay:' . $delay . 'ms'; ?><?= $show ? '' : ' hidden' ?>
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
          <?php if ($tileRules !== []): ?>
            <style>
              <?php foreach ($tileRules as $slug => $rule): ?>
              .pf-tile[data-slug="<?= $h($slug) ?>"]{<?= $h($rule) ?>}
              <?php endforeach; ?>
            </style>
          <?php endif; ?>

          <!-- CTA plate: always visible, drops into the last gap of the grid -->
          <article class="pf-tile pf-tile--c reveal" data-cta>
            <div class="pf-cta">
              <h2>Need something<br>like this<span>?</span></h2>
              <div>
                <a href="<?= BASE_PATH ?>/#contact" data-track="cta" data-cta-location="portfolio-page">Talk to Our Team</a>
                <a href="<?= BASE_PATH ?>/#ai-brief" data-track="cta" data-cta-location="portfolio-page">Brief Us on Yours</a>
              </div>
            </div>
          </article>
        </div>

        <p class="pf-empty pf-micro" id="pf-empty" <?= $visibleCount > 0 ? ' hidden' : '' ?>>No projects in this industry
          yet. We've built systems in adjacent industries; ask us.</p>

      </div>

      <section class="pf-notes">
        <h2>How to read this portfolio</h2>
        <p>Every tile above is a system we built and still support. Tiles marked with a demo link open a working build you can click through; the rest are client deployments we cannot open to the public, so they show a screenshot and a short description instead.</p>
        <p>Treat a demo as a look at the interface and the workflow, not a quote. Module scope, integrations, hardware and reporting all get agreed separately for your project.</p>

        <h2>What these systems have in common</h2>
        <ul>
          <li><strong>Built around an existing operation.</strong> Each one replaced a mix of spreadsheets, paper and a packaged tool that had stopped fitting. We map the current process first, then build to it.</li>
          <li><strong>Used daily by non-technical staff.</strong> Operators, drivers, store keepers and front-desk teams are the main users, so the screens are short and the error states matter more than the dashboards.</li>
          <li><strong>Run on your own data.</strong> There is no per-user licence on the custom application, and ownership and handover follow the project agreement.</li>
          <li><strong>Supported after go-live.</strong> Most of these have been running for more than a year, with changes going in as the business changes.</li>
        </ul>

        <h2>Industries we have built for</h2>
        <p>The filters above cover manufacturing, logistics and transport, healthcare, recycling, travel and professional services. If your industry is not listed, the underlying work is usually close enough to adapt: stock, jobs, approvals and billing behave much the same across sectors.</p>
        <p>For the service behind these builds, see <a href="<?= BASE_PATH ?>/services/erp-development/">ERP and CRM development</a>, <a href="<?= BASE_PATH ?>/services/manufacturing-erp/">manufacturing ERP</a>, <a href="<?= BASE_PATH ?>/services/industry-systems/">industry-specific systems</a> or <a href="<?= BASE_PATH ?>/services/web-mobile-apps/">web and mobile apps</a>.</p>

        <h2>Starting your own</h2>
        <p>Send us the shape of the problem: how many people will use it, what they do now, and which systems it has to talk to. Run it through the <a href="<?= BASE_PATH ?>/#ai-brief">scoping tool</a> for a rough cost and timeline, or <a href="<?= BASE_PATH ?>/#contact">talk to our team</a> directly.</p>
      </section>
    </div>
  </main>

  <?php include __DIR__ . '/includes/footer.php'; ?>
  <?php include __DIR__ . '/includes/scripts.php'; ?>

</body>

</html>