<?php
/**
 * Portfolio taxonomy + card helpers.
 * Single source for industry slugs/labels used by the home section,
 * /portfolio page, admin form and the seed script.
 */
declare(strict_types=1);

const PORTFOLIO_INDUSTRIES = [
    'manufacturing' => 'Manufacturing',
    'service'       => 'Service',
    'travel'        => 'Tour & Travel',
    'logistics'     => 'Logistics',
    'healthcare'    => 'Healthcare',
    'education'     => 'Education',
    'food-retail'   => 'Food & Retail',
    'energy'        => 'Energy & Infrastructure',
    'construction'  => 'Construction',
    'organisations' => 'Membership Orgs',
];

// Chips shown on the home page (the rest live behind "More filters →").
const PORTFOLIO_HOME_INDUSTRIES = ['manufacturing', 'service', 'travel'];
const PORTFOLIO_HOME_MAX = 6;

if (!function_exists('portfolio_industries')) {
    function portfolio_industries(): array
    {
        return PORTFOLIO_INDUSTRIES;
    }
}

if (!function_exists('portfolio_industry_is_valid')) {
    function portfolio_industry_is_valid(?string $slug): bool
    {
        return $slug !== null && isset(PORTFOLIO_INDUSTRIES[$slug]);
    }
}

if (!function_exists('portfolio_industry_label')) {
    function portfolio_industry_label(?string $slug): string
    {
        return PORTFOLIO_INDUSTRIES[$slug ?? ''] ?? '';
    }
}

if (!function_exists('portfolio_requested_industry')) {
    /** Sanitised ?industry= value, or 'all'. */
    function portfolio_requested_industry(): string
    {
        $q = isset($_GET['industry']) ? strtolower(trim((string)$_GET['industry'])) : '';

        return portfolio_industry_is_valid($q) ? $q : 'all';
    }
}

if (!function_exists('portfolio_url')) {
    function portfolio_url(string $industry = 'all'): string
    {
        $url = BASE_PATH . '/portfolio';
        if ($industry !== 'all' && portfolio_industry_is_valid($industry)) {
            $url .= '?industry=' . rawurlencode($industry);
        }

        return $url;
    }
}

if (!function_exists('portfolio_has_detail')) {
    /** True when the entry has its own /demo/{slug} page worth linking to. */
    function portfolio_has_detail(array $row): bool
    {
        if (!empty($row['demo_url'])) {
            return true;
        }

        return trim(strip_tags((string)($row['detailed_description'] ?? ''))) !== '';
    }
}

if (!function_exists('portfolio_card_link')) {
    /**
     * @return array{href:string,external:bool,label:string}|null
     */
    function portfolio_card_link(array $row): ?array
    {
        if (portfolio_has_detail($row)) {
            return [
                'href'     => BASE_PATH . '/demo/' . rawurlencode((string)$row['slug']),
                'external' => false,
                'label'    => ($row['category'] ?? '') === 'mobile' ? 'View App' : 'View Demo',
            ];
        }

        $url = trim((string)($row['client_url'] ?? ''));
        if ($url !== '' && preg_match('#^https?://#i', $url)) {
            return ['href' => $url, 'external' => true, 'label' => 'Visit site'];
        }

        return null;
    }
}

if (!function_exists('portfolio_initials')) {
    /** Two-character mark for entries without a screenshot. */
    function portfolio_initials(array $row): string
    {
        // Product name first (Ghumantoo → "Gh"), client name only as a fallback.
        $name = trim(explode(' — ', (string)($row['title'] ?? ''))[0]);
        if ($name === '') {
            $name = trim((string)($row['client_name'] ?? ''));
        }
        $words = preg_split('/\s+/u', $name) ?: [];
        $words = array_values(array_filter($words, static fn($w) => $w !== '' && preg_match('/^[\p{L}\p{N}]/u', $w)));

        // Short acronym-style first word ("RS Robotics", "SP Constructs") reads better whole.
        if (count($words) >= 2 && mb_strlen($words[0]) <= 3 && mb_strtoupper($words[0]) === $words[0]) {
            return $words[0];
        }
        if (count($words) >= 2) {
            return mb_strtoupper(mb_substr($words[0], 0, 1)) . mb_strtoupper(mb_substr($words[1], 0, 1));
        }

        return mb_substr($name, 0, 2);
    }
}

if (!function_exists('portfolio_tile_color')) {
    function portfolio_tile_color(array $row): string
    {
        $c = trim((string)($row['tile_color'] ?? ''));

        return preg_match('/^#[0-9a-f]{6}$/i', $c) ? $c : '#C8293E';
    }
}
