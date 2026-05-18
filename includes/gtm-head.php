<?php
/**
 * Google Tag Manager — head snippet (include once per page, early in <head>).
 * Requires GTM_CONTAINER_ID in config.php.
 */
if (!defined('GTM_CONTAINER_ID') || GTM_CONTAINER_ID === '') {
    return;
}
$gtmId = htmlspecialchars(GTM_CONTAINER_ID, ENT_QUOTES, 'UTF-8');
?>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','<?= $gtmId ?>');</script>
<!-- End Google Tag Manager -->
