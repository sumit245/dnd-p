<?php
/**
 * GA4 via gtag.js — loaded directly when GA4_MEASUREMENT_ID is set, so page views
 * and dataLayer events reach GA4 without depending on tags inside the GTM container.
 * If you later add a GA4 Configuration tag in GTM, remove GA4_MEASUREMENT_ID from .env
 * to avoid double counting.
 */
if (!defined('GA4_MEASUREMENT_ID') || GA4_MEASUREMENT_ID === '') {
    return;
}
$ga4Id = htmlspecialchars(GA4_MEASUREMENT_ID, ENT_QUOTES, 'UTF-8');
?>
<!-- Google Analytics 4 -->
<script async src="https://www.googletagmanager.com/gtag/js?id=<?= $ga4Id ?>"></script>
<script>
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('js', new Date());
gtag('config', '<?= $ga4Id ?>', { send_page_view: true });
window.DND_GA4_ID = '<?= $ga4Id ?>';
</script>
<!-- End Google Analytics 4 -->
