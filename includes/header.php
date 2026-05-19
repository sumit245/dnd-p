<?php include __DIR__ . '/gtm-noscript.php'; ?>
<?php require_once __DIR__ . '/assets.php'; ?>
<a class="skip-link" href="#main-content">Skip to main content</a>
<!-- ═══════════════════════════════ NAVBAR ═══════════════════════════════ -->
<header>
  <nav class="navbar" id="navbar" aria-label="Primary navigation">
    <div class="nav-inner">
      <a href="<?= BASE_PATH ?>/" class="nav-logo" aria-label="Dashandots Technology home">
        <picture>
          <source srcset="<?= asset_url('/assets/logo-64.webp') ?>" type="image/webp">
          <img src="<?= asset_url('/assets/logo-64.png') ?>" alt="Dashandots Technology logo" width="64" height="64">
        </picture>
        <span>Dashandots</span>
      </a>
      <ul class="nav-links">
        <li><a href="<?= BASE_PATH ?>/#home" <?= ($page['active_nav'] ?? '') === 'home' ? ' class="active"' : '' ?>>Home</a></li>
        <li><a href="<?= BASE_PATH ?>/#about" <?= ($page['active_nav'] ?? '') === 'about' ? ' class="active"' : '' ?>>About</a></li>
        <li><a href="<?= BASE_PATH ?>/#services" <?= ($page['active_nav'] ?? '') === 'services' ? ' class="active"' : '' ?>>Services</a></li>
        <li><a href="<?= BASE_PATH ?>/#industries">Industries</a></li>
        <li><a href="<?= BASE_PATH ?>/#solutions">Solutions</a></li>
        <li><a href="<?= BASE_PATH ?>/#portfolio" <?= ($page['active_nav'] ?? '') === 'portfolio' ? ' class="active"' : '' ?>>Portfolio</a></li>
        <li><a href="<?= BASE_PATH ?>/blog/" <?= ($page['active_nav'] ?? '') === 'blog' ? ' class="active"' : '' ?>>Blog</a>
        </li>
      </ul>
      <div class="nav-actions">
        <?php if (defined('SITE_WHATSAPP_URL') && SITE_WHATSAPP_URL !== ''): ?>
          <a href="<?= htmlspecialchars(SITE_WHATSAPP_URL, ENT_QUOTES, 'UTF-8') ?>" class="btn btn-outline" target="_blank" rel="noopener noreferrer" data-track="whatsapp" data-cta-location="nav" aria-label="Talk to us on WhatsApp (opens in a new tab)">Talk to us</a>
        <?php else: ?>
          <a href="<?= BASE_PATH ?>/#portfolio" class="btn btn-outline" data-track="cta" data-cta-location="nav">See Work</a>
        <?php endif; ?>
        <a href="<?= BASE_PATH ?>/#ai-brief" class="btn btn-primary" data-track="cta" data-cta-location="nav">Get Instant Estimate</a>
      </div>
      <button class="hamburger" id="hamburgerBtn" aria-label="Open navigation menu" aria-expanded="false">
        <span></span><span></span><span></span>
      </button>
    </div>
  </nav>
  <div class="mobile-menu" id="mobileMenu" role="dialog" aria-modal="true" aria-label="Mobile navigation" aria-hidden="true">
    <a href="<?= BASE_PATH ?>/" class="mobile-link">Home</a>
    <a href="<?= BASE_PATH ?>/#services" class="mobile-link">Services</a>
    <a href="<?= BASE_PATH ?>/#solutions" class="mobile-link">Solutions</a>
    <a href="<?= BASE_PATH ?>/#industries" class="mobile-link">Industries</a>
    <a href="<?= BASE_PATH ?>/#portfolio" class="mobile-link">Portfolio</a>
    <a href="<?= BASE_PATH ?>/blog/" class="mobile-link">Blog</a>
    <a href="<?= BASE_PATH ?>/#about" class="mobile-link">About</a>
    <a href="<?= BASE_PATH ?>/#faq" class="mobile-link">FAQ</a>
    <a href="<?= BASE_PATH ?>/#ai-brief" class="btn btn-primary" data-track="cta" data-cta-location="mobile-menu">Get Instant Estimate</a>
  </div>
  <div class="mobile-sticky-cta" aria-label="Quick contact options">
    <?php if (defined('SITE_WHATSAPP_URL') && SITE_WHATSAPP_URL !== ''): ?>
      <a href="<?= htmlspecialchars(SITE_WHATSAPP_URL, ENT_QUOTES, 'UTF-8') ?>" target="_blank" rel="noopener noreferrer" data-track="whatsapp" data-cta-location="sticky-mobile" aria-label="Talk to us on WhatsApp (opens in a new tab)">Talk to us</a>
    <?php endif; ?>
    <?php if (defined('SITE_PHONE') && SITE_PHONE !== ''): ?>
      <a href="tel:<?= htmlspecialchars(preg_replace('/\s+/', '', SITE_PHONE), ENT_QUOTES, 'UTF-8') ?>" data-track="phone" data-cta-location="sticky-mobile">Call</a>
    <?php endif; ?>
    <a href="<?= BASE_PATH ?>/#ai-brief" data-track="cta" data-cta-location="sticky-mobile" aria-label="Get instant estimate">Estimate</a>
  </div>
</header>
