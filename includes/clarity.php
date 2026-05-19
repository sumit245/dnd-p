<?php
/**
 * Optional Microsoft Clarity tracking.
 * Set MICROSOFT_CLARITY_ID in .env to enable session recordings.
 */
if (!defined('MICROSOFT_CLARITY_ID') || MICROSOFT_CLARITY_ID === '') {
    return;
}
$clarityId = preg_replace('/[^a-zA-Z0-9]/', '', MICROSOFT_CLARITY_ID);
if ($clarityId === '') {
    return;
}
?>
<script>
(function(c,l,a,r,i,t,y){
  c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
  t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;
  y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
})(window, document, "clarity", "script", "<?= htmlspecialchars($clarityId, ENT_QUOTES, 'UTF-8') ?>");
</script>
