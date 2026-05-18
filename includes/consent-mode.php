<?php
/**
 * Google Consent Mode v2 defaults — must run before GTM container snippet.
 */
if (!defined('GTM_CONTAINER_ID') || GTM_CONTAINER_ID === '') {
    return;
}
?>
<script>
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('consent', 'default', {
  ad_storage: 'denied',
  ad_user_data: 'denied',
  ad_personalization: 'denied',
  analytics_storage: 'denied',
  functionality_storage: 'denied',
  personalization_storage: 'denied',
  security_storage: 'granted',
  wait_for_update: 500
});
</script>
