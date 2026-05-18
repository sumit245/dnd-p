<?php
/**
 * BlogPosting JSON-LD — set $schemaBlog before including:
 *   headline, description, url, datePublished (Y-m-d or ISO), dateModified (optional), image (optional)
 */
if (empty($schemaBlog['headline']) || empty($schemaBlog['url'])) {
    return;
}
$logoUrl = defined('SITE_LOGO_URL') ? SITE_LOGO_URL : (SITE_URL . '/assets/logo.png');
$imageUrl = $schemaBlog['image'] ?? (SITE_URL . '/assets/img/og-image.jpg');
$datePublished = date('c', strtotime($schemaBlog['datePublished']));
$dateModified = !empty($schemaBlog['dateModified'])
    ? date('c', strtotime($schemaBlog['dateModified']))
    : $datePublished;
?>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BlogPosting",
  "mainEntityOfPage": {
    "@type": "WebPage",
    "@id": <?= json_encode($schemaBlog['url'], JSON_UNESCAPED_SLASHES) ?>
  },
  "headline": <?= json_encode($schemaBlog['headline'], JSON_UNESCAPED_UNICODE) ?>,
  "description": <?= json_encode($schemaBlog['description'] ?? '', JSON_UNESCAPED_UNICODE) ?>,
  "image": [<?= json_encode($imageUrl, JSON_UNESCAPED_SLASHES) ?>],
  "datePublished": <?= json_encode($datePublished) ?>,
  "dateModified": <?= json_encode($dateModified) ?>,
  "author": {
    "@type": "Organization",
    "name": <?= json_encode(SITE_NAME, JSON_UNESCAPED_UNICODE) ?>,
    "url": <?= json_encode(SITE_URL . '/', JSON_UNESCAPED_SLASHES) ?>
  },
  "publisher": {
    "@type": "Organization",
    "name": <?= json_encode(SITE_NAME, JSON_UNESCAPED_UNICODE) ?>,
    "logo": {
      "@type": "ImageObject",
      "url": <?= json_encode($logoUrl, JSON_UNESCAPED_SLASHES) ?>
    }
  }
}
</script>
