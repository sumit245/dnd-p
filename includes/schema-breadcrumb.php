<?php
/**
 * Shared schema.org BreadcrumbList builder.
 *
 * The site has had visual breadcrumbs ("Services › ERP & CRM", "Back to
 * Portfolio") for a while but no structured data behind them, so they earned no
 * breadcrumb trail in search results. This builds that trail from the same
 * labels.
 *
 * Usage (after $page[] is set up, before head.php is included):
 *   require_once __DIR__ . '/../includes/schema-breadcrumb.php';
 *   $page['jsonld'][] = breadcrumb_schema_jsonld(breadcrumb_schema([
 *     ['name' => 'Services',    'url' => '/services/erp-development/'],
 *     ['name' => 'ERP & CRM'],   // last crumb: current page, no url needed
 *   ]));
 *
 * Home is prepended automatically. A crumb without a url is still emitted:
 * Google accepts a trailing item with no `item` property.
 */
declare(strict_types=1);

require_once __DIR__ . '/seo.php';

if (!function_exists('breadcrumb_schema')) {
    /**
     * @param array<int,array{name:string,url?:string}> $trail Crumbs after Home.
     */
    function breadcrumb_schema(array $trail): array
    {
        $items = [];
        $position = 1;

        $crumbs = array_merge([['name' => 'Home', 'url' => '/']], $trail);

        foreach ($crumbs as $crumb) {
            $name = trim((string)($crumb['name'] ?? ''));
            if ($name === '') {
                continue;
            }

            $item = [
                '@type'    => 'ListItem',
                'position' => $position++,
                'name'     => $name,
            ];

            $url = trim((string)($crumb['url'] ?? ''));
            if ($url !== '') {
                $item['item'] = absolute_public_url($url);
            }

            $items[] = $item;
        }

        return [
            '@context'        => 'https://schema.org',
            '@type'           => 'BreadcrumbList',
            'itemListElement' => $items,
        ];
    }
}

if (!function_exists('breadcrumb_schema_jsonld')) {
    /** Thin alias for schema_jsonld() (includes/seo.php), kept for symmetry with service-schema.php. */
    function breadcrumb_schema_jsonld(array $schema): string
    {
        return schema_jsonld($schema);
    }
}
