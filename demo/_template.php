<?php
/**
 * Shared Demo Page Template
 * Included by erp.php / tms.php / hms.php after they set $portfolio + $page.
 * Requires: $portfolio (row from `portfolios` table), $page (set for head.php).
 */
require_once __DIR__ . '/../includes/portfolio-media.php';
$demoFaqs = include __DIR__ . '/../includes/demo-faqs.php';
$faqs     = $demoFaqs[$portfolio['slug'] ?? ''] ?? [];
$isMobileApp = ($portfolio['category'] ?? '') === 'mobile';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php include __DIR__ . '/../includes/head.php'; ?>
</head>
<body>

<?php include __DIR__ . '/../includes/header.php'; ?>

<main id="main-content">

  <!-- ══════════════════════════════════════════
       HERO: dark, full-width
  ══════════════════════════════════════════ -->
  <section class="demo-hero">

    <!-- Single-row: back link · title · badge -->
    <div class="demo-hero-topbar">
      <a href="<?= BASE_PATH ?>/portfolio" class="demo-back-link">
        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
          <path d="M19 12H5M12 5l-7 7 7 7"/>
        </svg>
        Back to Portfolio
      </a>

      <h1><?= htmlspecialchars($portfolio['title']) ?></h1>

      <div class="demo-hero-badge">
        <svg width="7" height="7" viewBox="0 0 8 8" fill="currentColor" aria-hidden="true">
          <circle cx="4" cy="4" r="4"/>
        </svg>
        <?= $isMobileApp ? 'Live on Google Play' : 'Live Demo Available' ?>
      </div>
    </div>

    <p class="demo-hero-desc"><?= htmlspecialchars($portfolio['short_description']) ?></p>

    <?php if (!empty($portfolio['demo_url'])): ?>
      <?php $demoHost = parse_url($portfolio['demo_url'], PHP_URL_HOST) ?: $portfolio['demo_url']; ?>
      <div class="demo-url-pill">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
          <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/>
          <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/>
        </svg>
        <?= htmlspecialchars($demoHost) ?>
      </div>
    <?php endif; ?>

    <!-- Credentials + Launch CTA -->
    <div class="demo-creds-card">

      <p class="demo-creds-title"><?= $isMobileApp ? 'Try the App' : 'Demo Credentials' ?></p>

      <?php $hasOpenCreds = !$isMobileApp && !empty($portfolio['username']) && !empty($portfolio['password']); ?>

      <?php if (!empty($portfolio['username'])): ?>
        <div class="demo-creds-row">
          <span class="demo-creds-label">Login</span>
          <span class="demo-creds-value" id="cred-user"><?= htmlspecialchars($portfolio['username']) ?></span>
          <button class="demo-copy-btn" onclick="demoCopy('cred-user', this)" type="button">Copy</button>
        </div>
      <?php endif; ?>

      <?php if ($hasOpenCreds): ?>
        <div class="demo-creds-row">
          <span class="demo-creds-label">Password</span>
          <span class="demo-creds-value" id="cred-pass"><?= htmlspecialchars($portfolio['password']) ?></span>
          <button class="demo-copy-btn" onclick="demoCopy('cred-pass', this)" type="button">Copy</button>
        </div>
      <?php endif; ?>

      <?php if ($hasOpenCreds): ?>
        <p class="demo-creds-note">
          Open access: nothing to request. Log in with the details above and click through the whole system.
          This demo runs on sample data only. Need a walkthrough on your own structure? Email
          <a href="mailto:<?= htmlspecialchars(SITE_EMAIL) ?>"><?= htmlspecialchars(SITE_EMAIL) ?></a>
          or use the <a href="<?= BASE_PATH ?>/#contact">contact form</a>.
        </p>
      <?php else: ?>
        <p class="demo-creds-note">
          <?= $isMobileApp ? 'Want a guided walkthrough or a white-labelled version for your business? Email' : 'Demo passwords are not published on this page. Email' ?>
          <a href="mailto:<?= htmlspecialchars(SITE_EMAIL) ?>"><?= htmlspecialchars(SITE_EMAIL) ?></a>
          or use the <a href="<?= BASE_PATH ?>/#contact">contact form</a> to request full demo access.
        </p>
      <?php endif; ?>

      <?php if (!empty($portfolio['demo_url'])): ?>
        <a href="<?= htmlspecialchars($portfolio['demo_url']) ?>"
           target="_blank" rel="noopener noreferrer"
           class="demo-launch-btn">
          <?= $isMobileApp ? 'Get it on Google Play' : 'Launch Live Demo' ?>
          <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
            <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/>
            <polyline points="15 3 21 3 21 9"/>
            <line x1="10" y1="14" x2="21" y2="3"/>
          </svg>
        </a>
      <?php endif; ?>

    </div><!-- /demo-creds-card -->

  </section>


  <!-- ══════════════════════════════════════════
       IMAGE GALLERY: 1 main + 4-6 thumbnails
  ══════════════════════════════════════════ -->
  <?php
    $galleryRaw  = $portfolio['gallery_images'] ?? '';
    $galleryUrls = [];
    if (!empty($galleryRaw)) {
      $galleryUrls = array_values(array_filter(array_map('trim',
        preg_split('/[\r\n,]+/', $galleryRaw)
      )));
    }
    $hasMain    = !empty($portfolio['image_path']);
    $hasGallery = count($galleryUrls) > 0;
    $mainImageMeta = $hasMain ? portfolio_image_meta($portfolio['image_path']) : null;
    $mainImageSrc = asset_url($mainImageMeta['webp'] ?? ($portfolio['image_path'] ?? ''));
  ?>

  <?php if ($hasMain || $hasGallery): ?>
  <section class="demo-gallery-section">
    <div class="container">

      <div class="demo-gallery<?= ($hasMain && $hasGallery) ? ' demo-gallery--split' : '' ?>">

        <?php if ($hasMain): ?>
        <!-- Main screenshot -->
        <div class="demo-gallery-main">
          <img
            id="demoMainImg"
            src="<?= htmlspecialchars($mainImageSrc) ?>"
            alt="<?= htmlspecialchars($portfolio['title']) ?>: dashboard overview"
            class="demo-main-img"
            width="<?= (int) ($mainImageMeta['width'] ?? 1200) ?>"
            height="<?= (int) ($mainImageMeta['height'] ?? 800) ?>"
            loading="eager">
        </div>
        <?php endif; ?>

        <?php if ($hasGallery): ?>
        <!-- Thumbnail column -->
        <div class="demo-gallery-thumbs" role="list" aria-label="Screenshot gallery">
          <?php foreach (array_slice($galleryUrls, 0, 6) as $i => $url): ?>
          <?php
            $thumbMeta = portfolio_image_meta($url);
            $thumbSrc = asset_url($thumbMeta['webp'] ?? $url);
          ?>
          <button
            class="demo-thumb"
            onclick="demoSetMain(this, '<?= htmlspecialchars($thumbSrc, ENT_QUOTES) ?>')"
            type="button"
            role="listitem"
            aria-label="View screenshot <?= $i + 1 ?>">
            <img
              src="<?= htmlspecialchars($thumbSrc) ?>"
              alt="<?= htmlspecialchars($portfolio['title']) ?> screenshot <?= $i + 1 ?>"
              width="<?= (int) ($thumbMeta['width'] ?? 320) ?>"
              height="<?= (int) ($thumbMeta['height'] ?? 220) ?>"
              loading="lazy">
          </button>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>

      </div><!-- /demo-gallery -->

    </div>
  </section>
  <?php endif; ?>


  <!-- ══════════════════════════════════════════
       RICH TEXT CONTENT from admin TinyMCE
  ══════════════════════════════════════════ -->
  <section class="demo-content-section">
    <div class="container">

      <?php if (!empty(trim(strip_tags($portfolio['detailed_description'] ?? '')))): ?>
        <div class="demo-rich-text">
          <?php // Content is authored with root-relative links; prefix BASE_PATH so they work on localhost too. ?>
          <?= str_replace('href="/demo/', 'href="' . BASE_PATH . '/demo/', $portfolio['detailed_description']) ?>
        </div>
      <?php else: ?>
        <div class="demo-empty-state">
          <p>Detailed content coming soon. Book a walkthrough to see this product in action.</p>
        </div>
      <?php endif; ?>

      <?php if (!empty($faqs)): ?>
        <div class="demo-faq-block">
          <h2>Common questions</h2>

          <div class="faq-list">
            <?php foreach ($faqs as $faq): ?>
              <div class="faq-item">
                <button class="faq-q" aria-expanded="false" type="button"><?= htmlspecialchars($faq['q'], ENT_QUOTES, 'UTF-8') ?><svg
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" aria-hidden="true">
                    <line x1="12" y1="5" x2="12" y2="19" />
                    <line x1="5" y1="12" x2="19" y2="12" />
                  </svg></button>
                <div class="faq-a">
                  <div class="faq-a-inner"><?= htmlspecialchars($faq['a'], ENT_QUOTES, 'UTF-8') ?></div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>

        <?php
          // FAQPage structured data, built from the same array as the markup above.
          $faqSchema = [
              '@context'   => 'https://schema.org',
              '@type'      => 'FAQPage',
              'mainEntity' => array_map(static fn(array $f): array => [
                  '@type'          => 'Question',
                  'name'           => $f['q'],
                  'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f['a']],
              ], $faqs),
          ];
        ?>
        <script type="application/ld+json">
<?= json_encode($faqSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_HEX_TAG | JSON_HEX_AMP) ?>
        </script>
      <?php endif; ?>

    </div>
  </section>


  <!-- ══════════════════════════════════════════
       CTA BANNER
  ══════════════════════════════════════════ -->
  <div class="demo-cta-banner">
    <h2>See How This Can Work<br>For Your Business</h2>
    <p>Every business is different. Book a free 20-minute walkthrough and we'll map our solution exactly to your workflow.</p>
    <a href="<?= BASE_PATH ?>/#contact" class="btn">Talk to a Product Expert →</a>
    <p class="demo-cta-note">No commitment. Most clients decide after one call.</p>
  </div>

</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>
<?php include __DIR__ . '/../includes/scripts.php'; ?>

<script>
function demoCopy(elemId, btn) {
  const text = (document.getElementById(elemId)?.textContent || '').trim();
  if (!text) return;
  const finish = () => {
    btn.textContent = 'Copied!';
    btn.classList.add('copied');
    setTimeout(() => { btn.textContent = 'Copy'; btn.classList.remove('copied'); }, 2000);
  };
  if (navigator.clipboard) {
    navigator.clipboard.writeText(text).then(finish).catch(() => fallbackCopy(text, finish));
  } else {
    fallbackCopy(text, finish);
  }
}
function fallbackCopy(text, cb) {
  const el = Object.assign(document.createElement('textarea'), { value: text });
  Object.assign(el.style, { position: 'fixed', opacity: '0' });
  document.body.appendChild(el);
  el.focus(); el.select();
  try { document.execCommand('copy'); } catch (e) {}
  document.body.removeChild(el);
  cb();
}
function demoSetMain(btn, url) {
  const mainImg = document.getElementById('demoMainImg');
  if (!mainImg) return;
  mainImg.src = url;
  // Update active state
  document.querySelectorAll('.demo-thumb').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
}
</script>

</body>
</html>
