<?php include __DIR__ . '/gtm-noscript.php'; ?>
<a class="skip-link" href="#main-content">Skip to main content</a>
<!-- ═══════════════════════════════ NAVBAR ═══════════════════════════════ -->
<header>
  <nav class="navbar" id="navbar" aria-label="Primary navigation">
    <div class="nav-inner">
      <a href="<?= BASE_PATH ?>/" class="nav-logo" aria-label="Dashandots Technology home">
        <img src="<?= BASE_PATH ?>/assets/logo.png" alt="Dashandots Technology logo">
        <span>Dashandots</span>
      </a>
      <ul class="nav-links">
        <li><a href="<?= BASE_PATH ?>/#home" <?= ($page['active_nav'] ?? '') === 'home' ? ' class="active"' : '' ?>>Home</a></li>
        <li><a href="<?= BASE_PATH ?>/#about" <?= ($page['active_nav'] ?? '') === 'about' ? ' class="active"' : '' ?>>About</a></li>
        <li><a href="<?= BASE_PATH ?>/#services" <?= ($page['active_nav'] ?? '') === 'services' ? ' class="active"' : '' ?>>Services</a></li>
        <li><a href="<?= BASE_PATH ?>/#industries">Industries</a></li>
        <li><a href="<?= BASE_PATH ?>/#solutions">Solutions</a></li>
        <li><a href="<?= BASE_PATH ?>/#portfolio" <?= ($page['active_nav'] ?? '') === 'portfolio' ? ' class="active"' : '' ?>>Portfolio</a></li>
        <li><a href="<?= BASE_PATH ?>/blog" <?= ($page['active_nav'] ?? '') === 'blog' ? ' class="active"' : '' ?>>Blog</a>
        </li>
        <li><a href="<?= BASE_PATH ?>/#ai-brief">Get Estimate</a></li>

      </ul>
      <div class="nav-actions">
        <a href="<?= BASE_PATH ?>/#portfolio" class="btn btn-outline">View Portfolio</a>
        <a href="<?= BASE_PATH ?>/#contact" class="btn btn-primary">Start a Project</a>
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
    <a href="<?= BASE_PATH ?>/blog" class="mobile-link">Blog</a>
    <a href="<?= BASE_PATH ?>/#about" class="mobile-link">About</a>
    <a href="<?= BASE_PATH ?>/#ai-brief" class="mobile-link">Get Estimate ✦</a>
    <a href="<?= BASE_PATH ?>/#faq" class="mobile-link">FAQ</a>
    <a href="<?= BASE_PATH ?>/#contact" class="btn btn-primary">Start a Project</a>
  </div>
</header>