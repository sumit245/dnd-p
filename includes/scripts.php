  <!-- App JS -->
<?php require_once __DIR__ . '/assets.php'; ?>
<?php include __DIR__ . '/consent-mode.php'; ?>
<?php if (defined('CONSENT_BANNER_ENABLED') && CONSENT_BANNER_ENABLED && defined('GTM_CONTAINER_ID') && GTM_CONTAINER_ID !== ''): ?>
  <script src="<?= asset_consent_js_src() ?>" defer></script>
<?php endif; ?>
  <script src="<?= asset_js_src() ?>" defer></script>
<?php include __DIR__ . '/gtm-head.php'; ?>
<?php include __DIR__ . '/clarity.php'; ?>
