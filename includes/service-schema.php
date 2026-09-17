<?php
/**
 * Shared schema.org Service JSON-LD builder for /services/* pages.
 *
 * Usage (in a service page, after config.php and $page[] setup):
 *   require_once __DIR__ . '/../../includes/service-schema.php';
 *   $serviceSchema = service_schema([
 *     'slug'        => 'erp-development',
 *     'name'        => 'Custom ERP & CRM Development',
 *     'serviceType' => ['ERP development', 'CRM development'],
 *     'description' => $page['description'],
 *     'catalogName' => 'ERP and CRM services',
 *     'offers'      => ['Finance & accounting module', 'Inventory module'],
 *   ]);
 * Then emit with service_schema_jsonld($serviceSchema) before footer.php.
 */

function service_schema_provider(): array
{
    $provider = [
        '@type' => 'Organization',
        '@id'   => SITE_URL . '/#organization',
        'name'  => SITE_NAME,
        'url'   => SITE_URL . '/',
        'logo'  => SITE_LOGO_URL,
    ];
    if (defined('SITE_ADDRESS') && SITE_ADDRESS !== '') {
        $provider['address'] = [
            '@type'          => 'PostalAddress',
            'streetAddress'  => SITE_ADDRESS,
            'addressCountry' => 'IN',
        ];
    }
    return $provider;
}

function service_schema(array $o): array
{
    $slug = trim((string)($o['slug'] ?? ''), '/');
    $url  = SITE_URL . '/services/' . $slug . '/';

    $offers = [];
    foreach ((array)($o['offers'] ?? []) as $name) {
        $offers[] = ['@type' => 'Offer', 'itemOffered' => ['@type' => 'Service', 'name' => $name]];
    }

    return [
        '@context'    => 'https://schema.org',
        '@type'       => 'Service',
        '@id'         => $url . '#service',
        'name'        => (string)($o['name'] ?? ''),
        'serviceType' => array_values((array)($o['serviceType'] ?? [])),
        'description' => (string)($o['description'] ?? ''),
        'url'         => $url,
        'provider'    => service_schema_provider(),
        'areaServed'  => [
            ['@type' => 'Country', 'name' => 'India'],
            ['@type' => 'AdministrativeArea', 'name' => 'Delhi NCR'],
        ],
        'audience' => [
            '@type'        => 'BusinessAudience',
            'audienceType' => 'SMEs and growing businesses',
        ],
        'offers' => [
            '@type'        => 'Offer',
            'availability' => 'https://schema.org/InStock',
            'priceSpecification' => [
                '@type'         => 'PriceSpecification',
                'priceCurrency' => 'INR',
                'description'   => 'Custom scope and timeline are confirmed after discovery; pricing follows in the proposal.',
            ],
            'url' => SITE_URL . '/#ai-brief',
        ],
        'hasOfferCatalog' => [
            '@type'           => 'OfferCatalog',
            'name'            => (string)($o['catalogName'] ?? ($o['name'] ?? '')),
            'itemListElement' => $offers,
        ],
    ];
}

function service_schema_jsonld(array $schema): string
{
    return '<script type="application/ld+json">' . "\n"
        . json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
        . "\n</script>\n";
}
