<?php
/**
 * CollectionPage JSON-LD — set $schemaCollection before including:
 *   name, description, url
 */
if (empty($schemaCollection['name']) || empty($schemaCollection['url'])) {
    return;
}
$logoUrl = defined('SITE_LOGO_URL') ? SITE_LOGO_URL : (SITE_URL . '/assets/logo.png');
?>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "CollectionPage",
  "name": <?= json_encode($schemaCollection['name'], JSON_UNESCAPED_UNICODE) ?>,
  "description": <?= json_encode($schemaCollection['description'] ?? '', JSON_UNESCAPED_UNICODE) ?>,
  "url": <?= json_encode($schemaCollection['url'], JSON_UNESCAPED_SLASHES) ?>,
  "publisher": {
    "@type": "Organization",
    "name": <?= json_encode(SITE_NAME, JSON_UNESCAPED_UNICODE) ?>,
    "url": <?= json_encode(SITE_URL . '/', JSON_UNESCAPED_SLASHES) ?>,
    "logo": {
      "@type": "ImageObject",
      "url": <?= json_encode($logoUrl, JSON_UNESCAPED_SLASHES) ?>
    }
  }
}
</script>
