<?php
/**
 * Google Consent Mode v2 defaults — must run before GTM container snippet.
 */
if (!defined('ANALYTICS_ENABLED') || !ANALYTICS_ENABLED) {
    return;
}
$analyticsDefault = defined('CONSENT_ANALYTICS_DEFAULT') ? CONSENT_ANALYTICS_DEFAULT : 'denied';
?>
<script>
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('consent', 'default', {
  ad_storage: 'denied',
  ad_user_data: 'denied',
  ad_personalization: 'denied',
  analytics_storage: '<?= $analyticsDefault ?>',
  functionality_storage: '<?= $analyticsDefault ?>',
  personalization_storage: 'denied',
  security_storage: 'granted',
  wait_for_update: 500
});
</script>
