<?php
/**
 * Per-product SEO overrides for demo pages, keyed by portfolio slug.
 *
 * Why this exists: demo/view.php builds the <title> as
 * `portfolios.title . ' | ' . SITE_NAME`, and uses short_description as the
 * meta description. Both are written for the page itself (the H1 and the
 * intro paragraph) so they run well past what a SERP will show
 * (the HRMX title lands at 73 characters that way, the description past 200).
 *
 * An entry here overrides the <title> and meta/OG description for that slug
 * only. The H1 still comes from portfolios.title, which is intentional: the
 * title tag targets the query, the H1 speaks to the reader.
 *
 * Keep `title` under 60 characters and `description` under 155. The override
 * is used verbatim (SITE_NAME is NOT appended) so include the brand if you
 * want it. Slugs with no entry keep the existing behaviour untouched.
 */

return [

    'hms' => [
        'title'       => 'Hospital Management System Demo | Dashandots',
        'description' => 'Explore the Dashandots hospital management system demo for appointments, patient records, pharmacy and billing. Review workflows before scoping a custom HMS.',
    ],

    'hrmx' => [
        // 56 chars. Leads with the headcount band: the strongest qualifier we
        // have, and it filters out navigational traffic for the other brands
        // on this SERP (hrmx.in, hrmx.ai, hrmx.tech) that was never going to
        // convert anyway.
        'title'       => 'HRMX HRMS: Payroll, Attendance & Leave for 20–1000 Staff',

        // 138 chars. Every claim here is verifiable: one-time build fee plus
        // AMC, no per-employee licence, client owns the IP, 8–10 week rollout.
        'description' => 'HRMX runs HR, attendance and payroll for 20 to 1,200+ employees. One-time build, no per-employee fee, you own the IP. Live in 8–10 weeks.',
    ],


    // The three rows below sit in the 54-59 char band: too long for a brand
    // suffix, short enough that the generator returned portfolios.title
    // unchanged, so <title> and H1 came out identical (Semrush, 15 Nov 2026).
    // These titles lead with the query instead; the H1 keeps the product name.

    'crm' => [
        // 48 chars. The product name means nothing in search; "custom CRM
        // software" plus the market is what the page can actually rank for.
        'title' => 'Custom CRM Software for Indian SMEs | Dashandots',
    ],

    'ghumantoo-app' => [
        // 45 chars. Platform in the title because the row is Android-only.
        'title'       => 'Bus Ticket Booking App (Android) | Dashandots',
        // 137 chars. The DB copy runs to 204 and was being cut at 155.
        'description' => 'Android bus booking app: search routes, pick seats on a visual layout, pay online and travel on a QR e-ticket with live trip status.',
    ],

    'waba' => [
        // 53 chars. "DnD Connect" is unsearched; the API name carries it.
        'title'       => 'WhatsApp Business API Platform for Teams | Dashandots',
        // 141 chars. The DB copy runs to 210.
        'description' => 'WhatsApp Business API platform on the official Meta Cloud API: shared team inbox, chatbot flows, broadcasts, templates and webhooks.',
    ],

];
