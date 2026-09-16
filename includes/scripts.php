  <!-- App JS -->
<?php require_once __DIR__ . '/assets.php'; ?>
<?php include __DIR__ . '/consent-mode.php'; ?>
<?php if (defined('CONSENT_BANNER_ENABLED') && CONSENT_BANNER_ENABLED && defined('GTM_CONTAINER_ID') && GTM_CONTAINER_ID !== ''): ?>
  <script src="<?= asset_consent_js_src() ?>" defer></script>
<?php endif; ?>
  <script src="<?= asset_js_src() ?>" defer></script>
<?php foreach (($page['extra_js'] ?? []) as $extraJs): ?>
  <script src="<?= htmlspecialchars(asset_prefer_min($extraJs), ENT_QUOTES, 'UTF-8') ?>" defer></script>
<?php endforeach; ?>
<?php include __DIR__ . '/gtm-head.php'; ?>
<?php include __DIR__ . '/clarity.php'; ?>
