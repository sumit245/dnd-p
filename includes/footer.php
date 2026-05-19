<!-- ═══════════════════════════════ FOOTER ═══════════════════════════════ -->
<footer>
  <div class="container">
    <div class="footer-grid">
      <div>
        <div class="footer-brand">
          <img src="<?= BASE_PATH ?>/assets/logo.png" alt="Dashandots Technology logo">
          Dashandots Technology
        </div>
        <p class="footer-desc">Custom ERP, CRM, dashboards, portals, and mobile apps for growing businesses that need clearer operations and long-term technical support.</p>
        <div class="footer-social">
          <a href="https://www.linkedin.com/company/102707174/" target="_blank" rel="noopener noreferrer"
            class="footer-soc-link" aria-label="LinkedIn">
            <svg viewBox="0 0 24 24" fill="currentColor">
              <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z" />
              <rect x="2" y="9" width="4" height="12" />
              <circle cx="4" cy="4" r="2" />
            </svg>
          </a>
          <a href="https://twitter.com/dashandots" target="_blank" rel="noopener noreferrer" class="footer-soc-link"
            aria-label="Twitter">
            <svg viewBox="0 0 24 24" fill="currentColor">
              <path
                d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
            </svg>
          </a>
        </div>
      </div>
      <div class="footer-col">
        <h4>Services</h4>
        <ul>
          <li><a href="<?= BASE_PATH ?>/services/erp-development/">ERP &amp; CRM</a></li>
          <li><a href="<?= BASE_PATH ?>/services/industry-systems/">HMS, TMS &amp; PMS</a></li>
          <li><a href="<?= BASE_PATH ?>/services/ecommerce/">E‑commerce &amp; Portals</a></li>
          <li><a href="<?= BASE_PATH ?>/services/data-analytics/">Dashboards &amp; Analytics</a></li>
          <li><a href="<?= BASE_PATH ?>/services/web-mobile-apps/">Web &amp; Mobile Apps</a></li>
          <li><a href="<?= BASE_PATH ?>/services/iot-embedded/">IoT &amp; Embedded</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h4>Solutions</h4>
        <ul>
          <li><a href="<?= BASE_PATH ?>/services/erp-development/">ERP Platform</a></li>
          <li><a href="<?= BASE_PATH ?>/services/erp-development/">CRM Platform</a></li>
          <li><a href="<?= BASE_PATH ?>/services/industry-systems/">TMS</a></li>
          <li><a href="<?= BASE_PATH ?>/services/industry-systems/">HMS</a></li>
          <li><a href="<?= BASE_PATH ?>/services/industry-systems/">Hotel PMS</a></li>
          <li><a href="<?= BASE_PATH ?>/services/data-analytics/">Business Dashboards</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h4>Company</h4>
        <ul>
          <li><a href="<?= BASE_PATH ?>/#about">About Us</a></li>
          <li><a href="<?= BASE_PATH ?>/#portfolio">Portfolio</a></li>
          <li><a href="<?= BASE_PATH ?>/#case-studies">Case Studies</a></li>
          <li><a href="<?= BASE_PATH ?>/blog">Blog</a></li>
          <li><a href="<?= BASE_PATH ?>/#faq">FAQ</a></li>
          <?php if (defined('SITE_EMAIL') && SITE_EMAIL !== ''): ?>
            <li><a href="mailto:<?= htmlspecialchars(SITE_EMAIL, ENT_QUOTES, 'UTF-8') ?>" data-track="cta" data-cta-location="footer">Email</a></li>
          <?php endif; ?>
          <?php if (defined('SITE_PHONE') && SITE_PHONE !== ''): ?>
            <li><a href="tel:<?= htmlspecialchars(preg_replace('/\s+/', '', SITE_PHONE), ENT_QUOTES, 'UTF-8') ?>" data-track="phone" data-cta-location="footer">Call</a></li>
          <?php endif; ?>
          <?php if (defined('SITE_WHATSAPP_URL') && SITE_WHATSAPP_URL !== ''): ?>
            <li><a href="<?= htmlspecialchars(SITE_WHATSAPP_URL, ENT_QUOTES, 'UTF-8') ?>" target="_blank" rel="noopener" data-track="whatsapp" data-cta-location="footer">WhatsApp</a></li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
    <div class="footer-bottom">
      <p class="footer-copy">&copy; <?= date('Y') ?> <?= SITE_NAME ?>. All rights reserved.
        &nbsp;·&nbsp; <a href="<?= BASE_PATH ?>/privacy-policy">Privacy Policy</a> &nbsp;·&nbsp; <a
          href="<?= BASE_PATH ?>/terms">Terms</a></p>
      <p class="footer-tagline">Fast · Mobile‑first · Privacy‑respecting</p>
    </div>
  </div>
</footer>

<?php include __DIR__ . '/consent-banner.php'; ?>

<!-- Back to top -->
<button class="back-to-top" id="backToTop" aria-label="Back to top">
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
    aria-hidden="true">
    <polyline points="18,15 12,9 6,15" />
  </svg>
</button>
