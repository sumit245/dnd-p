<?php
/**
 * Shared Demo Page Template
 * Included by erp.php / tms.php / hms.php after they set $portfolio + $page.
 * Requires: $portfolio (row from `portfolios` table), $page (set for head.php).
 */
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
       HERO — dark, full-width
  ══════════════════════════════════════════ -->
  <section class="demo-hero">

    <!-- Single-row: back link · title · badge -->
    <div class="demo-hero-topbar">
      <a href="<?= BASE_PATH ?>/#portfolio" class="demo-back-link">
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
        Live Demo Available
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

      <p class="demo-creds-title">Demo Credentials</p>

      <?php if (!empty($portfolio['username'])): ?>
        <div class="demo-creds-row">
          <span class="demo-creds-label">Login</span>
          <span class="demo-creds-value" id="cred-user"><?= htmlspecialchars($portfolio['username']) ?></span>
          <button class="demo-copy-btn" onclick="demoCopy('cred-user', this)" type="button">Copy</button>
        </div>
      <?php endif; ?>

      <p class="demo-creds-note">
        Demo passwords are not published on this page. Email
        <a href="mailto:<?= htmlspecialchars(SITE_EMAIL) ?>"><?= htmlspecialchars(SITE_EMAIL) ?></a>
        or use the <a href="<?= BASE_PATH ?>/#contact">contact form</a> to request full demo access.
      </p>

      <?php if (!empty($portfolio['demo_url'])): ?>
        <a href="<?= htmlspecialchars($portfolio['demo_url']) ?>"
           target="_blank" rel="noopener noreferrer"
           class="demo-launch-btn">
          Launch Live Demo
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
       IMAGE GALLERY — 1 main + 4-6 thumbnails
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
            src="<?= htmlspecialchars($portfolio['image_path']) ?>"
            alt="<?= htmlspecialchars($portfolio['title']) ?> — dashboard overview"
            class="demo-main-img"
            loading="eager">
        </div>
        <?php endif; ?>

        <?php if ($hasGallery): ?>
        <!-- Thumbnail column -->
        <div class="demo-gallery-thumbs" role="list" aria-label="Screenshot gallery">
          <?php foreach (array_slice($galleryUrls, 0, 6) as $i => $url): ?>
          <button
            class="demo-thumb"
            onclick="demoSetMain(this, '<?= htmlspecialchars($url, ENT_QUOTES) ?>')"
            type="button"
            role="listitem"
            aria-label="View screenshot <?= $i + 1 ?>">
            <img
              src="<?= htmlspecialchars($url) ?>"
              alt="<?= htmlspecialchars($portfolio['title']) ?> screenshot <?= $i + 1 ?>"
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
          <?= $portfolio['detailed_description'] ?>
        </div>
      <?php else: ?>
        <div class="demo-empty-state">
          <p>Detailed content coming soon. Book a walkthrough to see this product in action.</p>
        </div>
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
