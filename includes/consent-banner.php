<?php
/**
 * Cookie / analytics consent UI (shown until a choice is stored in localStorage).
 */
if (!defined('CONSENT_BANNER_ENABLED') || !CONSENT_BANNER_ENABLED) {
    return;
}
if (!defined('GTM_CONTAINER_ID') || GTM_CONTAINER_ID === '') {
    return;
}
?>
<div id="consentBanner" class="consent-banner" role="dialog" aria-labelledby="consentTitle" aria-describedby="consentDesc" aria-hidden="true" hidden>
  <div class="consent-banner-inner">
    <p id="consentTitle" class="consent-banner-title">Cookies &amp; analytics</p>
    <p id="consentDesc" class="consent-banner-text">
      We use cookies and Google Tag Manager to understand site usage and improve our services.
      You can accept analytics cookies or continue with essential cookies only.
      <a href="<?= BASE_PATH ?>/privacy-policy#cookies">Privacy policy</a>
    </p>
    <div class="consent-banner-actions">
      <button type="button" class="btn btn-ghost btn-sm" id="consentReject" data-consent="reject">Essential only</button>
      <button type="button" class="btn btn-primary btn-sm" id="consentAccept" data-consent="accept">Accept analytics</button>
    </div>
  </div>
</div>
