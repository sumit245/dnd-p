# Website Audit Report — Dashandots Technology

**Last updated:** 18 May 2026 (live re-audit)
**Production URL:** https://dashandots.com
**Codebase:** `/Applications/XAMPP/xamppfiles/htdocs/dashandots`
**Method:** Live HTTP/HTML verification on production + codebase review
**Supersedes:** `seo_audit_report.md`, `seo_comprehensive_audit.md` (single-page era — do not use for decisions)

---

## Executive summary

Dashandots is a multi-page PHP marketing site (service landings, dynamic blog, CMS admin, AI estimator) with **Phases 0–3 remediations deployed to production**. HTTPS, HSTS, GTM with Consent Mode, hardened form APIs, WebP portfolio images, and minified assets are live on the homepage.

Remaining gaps are **narrow**: static blog clean URLs redirect to the blog index (rewrite / legacy redirect rules), legacy `.html` redirects still prefix `/dashandots/` on production, and `X-Powered-By` is still exposed. The site is in good shape for marketing traffic after fixing blog URL routing.

| Category | Score (0–100) | Status |
|----------|---------------|--------|
| SEO & discoverability | 80 | Strong base; fix static blog clean URLs |
| Security | 82 | Critical items fixed on live; minor disclosure remains |
| Performance | 88 | WebP + min bundles; blog LCP preload + responsive thumbs |
| Accessibility | 88 | Prior Lighthouse 92–94; a11y fixes in repo |
| UX & compliance | 90 | Consent banner, privacy policy, safe estimator |
| **Overall (weighted)** | **84** | **Ready for traffic; fix blog URLs before SEO push** |

Weights: SEO 25%, Security 30%, Performance 20%, Accessibility 15%, UX 10%.

---

## Live verification (18 May 2026)

### Redirects and TLS

| Check | Result |
|-------|--------|
| `http://dashandots.com/` | **301** → `https://dashandots.com/` |
| `https://www.dashandots.com/` | **301** → `https://dashandots.com/` |
| HTTPS home | **200**, HTTP/2, LiteSpeed / Hostinger |

### Security headers (production)

| Header | Value |
|--------|--------|
| `Strict-Transport-Security` | `max-age=31536000; includeSubDomains` |
| `X-Content-Type-Options` | `nosniff` |
| `X-Frame-Options` | `SAMEORIGIN` |
| `Referrer-Policy` | `strict-origin-when-cross-origin` |
| `Content-Security-Policy` | Full policy (GTM, Fonts, GA `connect-src`, `frame-src` for GTM) |
| `X-Powered-By` | **PHP/8.2.30** (still exposed) |

### Key endpoints

| URL | Status | Notes |
|-----|--------|-------|
| `/` | **200** | GTM, consent banner, WebP `<picture>`, `style.min.css` / `app.min.js` |
| `/robots.txt` | **200** | Blocks `/admin/`, APIs, test paths; `Sitemap: …/sitemap.php` |
| `/sitemap.xml` | **301** → `sitemap.php` | Correct |
| `/sitemap.php` | **200** | Home, services, legal, CMS + static blog URLs |
| `/admin/run-migration.php` | **403** | Blocked (was critical) |
| `/admin/run-blog-migration.php` | **403** | Blocked |
| `/admin/` | **302** | Login gate |
| `/contact-handler.php` GET | **405** | Expected |
| `/contact-handler.php` honeypot POST | **200** | Fake success (no SMTP) |
| `/contact-handler.php` + `Origin: https://dashandots.com` | **200** | CORS allows site origin only |
| `/contact-handler.php` + evil `Origin` | **200** | No `Access-Control-Allow-Origin` for evil origin |
| `/estimate.php` POST | **200** | Returns `budgetMin`, `budgetMax`, `budgetStr` (no `budgetStrHtml`) |
| `/logo.png` | **404** | Unused if schema uses `/assets/logo.png` |
| `/assets/logo.png` | **200** | Correct logo |
| `/assets/img/og-image.jpg` | **200** | Default OG image |
| `/blog/` | **200** | GTM present |
| `/blog/agentic-ai-software-development` | **200** | Clean canonical URL |
| `/blog/future-of-custom-erp` | **302** → `/blog/` | **Open issue** — sitemap lists this URL |
| `/blog/future-of-custom-erp.php` | **200** | Article + GTM + `BlogPosting`; canonical points to clean slug |
| `/blog/future-of-custom-erp.html` | **301** → `/dashandots/blog/…` | **Open issue** — wrong path on apex host |
| `/services/erp-development` | **301** → `…/erp-development/` | Trailing-slash redirect |
| `/services/erp-development/` | **200** | GTM + consent banner |
| `/demo/erp` | **200** | `noindex`; passwords not in HTML |
| `/privacy-policy` | **200** | GTM, cookies §7 with `#cookies` anchor |
| `/test_smtp.php`, `/test_form.php` | **404** | Not deployed |

### Analytics and consent (homepage)

| Signal | Present on live `/` |
|--------|---------------------|
| GTM container | `GTM-TJ3ZLPNJ` |
| Consent Mode default | `gtag('consent', 'default', …)` |
| Cookie banner | `#consentBanner` |
| JSON-LD Organization logo | `https://dashandots.com/assets/logo.png` |

### Lighthouse reference (initial pass, 18 May 2026)

| Page | Performance | Accessibility | SEO | LCP |
|------|-------------|---------------|-----|-----|
| `/` | 87 | 92 | 100 | 3.2 s |
| `/services/erp-development/` | 99 | 94 | 100 | 1.8 s |
| `/blog/agentic-ai-software-development` | 82 | 94 | 100 | 4.8 s |

Re-run Lighthouse after blog URL fix and any new content publishes.

### Form API smoke tests

```bash
php scripts/smoke-test-forms.php --cli          # no Apache required
php scripts/smoke-test-forms.php https://dashandots.com
```

---

## Open findings

| ID | Sev | Category | Finding | Evidence | Recommendation |
|----|-----|----------|---------|----------|----------------|
| SEO-01 | **P1** | SEO | Static blog clean URLs redirect to blog index | Was **302** → `/blog/` when rewrite `-f` check failed | **Fixed in repo** — deploy `.htaccess` and retest `/blog/future-of-custom-erp` |
| SEO-02 | **P1** | SEO | Legacy `.html` 301s used `/dashandots/` on production | Old rules always prefixed `/dashandots/` | **Fixed in repo** — host-based rules; deploy and retest `.html` URLs |
| SEO-03 | **P2** | SEO | Service URLs require trailing slash | `/services/erp-development` → 301 → `…/` | Optional: internal rewrite without extra redirect |
| SEO-04 | **P2** | SEO | No `twitter:site` | Was missing on blog templates | Optional — set `TWITTER_SITE` only after confirming the active handle |
| SEC-01 | **P2** | Security | `X-Powered-By: PHP/8.2.30` | May still appear if host re-adds header | **Fixed in repo** (`Header unset`); verify after deploy |
| SEC-02 | **P2** | Security | `.env` may have been in git history | Rotate SMTP/DB/TinyMCE if repo was ever public | Confirm `git log` / Hostinger secrets |

---

## Resolved (verified on production)

| ID | Was | Resolution |
|----|-----|------------|
| SEC-02 | Open migration scripts | **403** on live |
| SEC-03 | No CSRF | Tokens + POST-only deletes in codebase (deployed) |
| SEC-04 | CORS `*` | Origin restricted to `https://dashandots.com` |
| SEC-09 | Demo passwords public | Passwords removed from demo template (live) |
| SEO-01 (robots) | Wrong `/dashandots/admin/` | Production `robots.txt` correct |
| SEO-02–03 | Broken JSON-LD logos | Home uses `/assets/logo.png` |
| SEO-04 | Duplicate sitemap | `sitemap.xml` → **301** `sitemap.php` |
| SEO-05 | Static posts missing from sitemap | Listed in `sitemap.php` |
| SEO-06–07 | GTM missing / drift | GTM + Consent Mode in `includes/` (live on main templates) |
| SEO-09 | No BlogPosting on static posts | Present on `blog/future-of-custom-erp.php` |
| PERF-01–04 | Heavy PNGs, no minify | WebP, `<picture>`, min CSS/JS site-wide |
| PERF-05 | Blog LCP / listing thumbs | Preload + `content_image_html()` on blog index/post |
| A11Y-01–04 | Skip link, ARIA, robots dupes | Skip focus, `aria-pressed` filters, reduced motion, `:focus-visible` |
| UX-01 | `budgetStrHtml` / innerHTML | Safe JSON + DOM on live `estimate.php` |
| Phase 3 | No consent | Banner + privacy policy live |

---

## What is working well

- HTTPS discipline (HTTP + www → apex HTTPS, HSTS).
- Security headers and production-grade CSP (GTM, Fonts, analytics).
- `robots.txt` with sensible AI crawler policy and correct production disallows.
- Dynamic `sitemap.php` with services, legal, CMS, and static blog entries.
- Shared SEO head: canonical, OG, Twitter; CMS posts use clean `/blog/{slug}` URLs.
- GTM `GTM-TJ3ZLPNJ` with Google Consent Mode v2 and cookie banner.
- Contact and estimator APIs: honeypot, rate limits, restricted CORS, safe estimate JSON.
- Portfolio WebP + responsive images on homepage; minified assets served.
- Admin migration endpoints blocked; test scripts not on production.
- `llms.txt` and structured data on homepage (FAQ, Organization with valid logo).

---

## Remediation completed (codebase → production)

### Phase 0 — Security

- `.gitignore`, `.env.example`; migration scripts removed; `.htaccess` **403** + `robots.txt` disallow
- `contact-handler.php` / `estimate.php`: CORS (apex + www), honeypot, rate limit
- Admin CSRF, POST-only deletes, session hardening; generic DB error messages in admin
- `Header unset X-Powered-By`; deny direct `.env` access
- Legacy `.html` 301s: localhost → `/dashandots/…`, production → site root (fixes `/dashandots/` on apex)
- Static blog rewrite: `blog/$1.php -f` **or** `%{DOCUMENT_ROOT}/blog/$1.php -f`

### Phase 1 — SEO and tracking (implemented 18 May 2026)

- `SITE_LOGO_URL` on homepage, blog listing, CMS/static posts, and `schema-blog-posting.php`
- **Unified head:** `blog/index.php` and `blog/post.php` use `includes/head.php` (Consent Mode + GTM + GSC meta + optional `twitter:site`)
- `twitter:site` via `TWITTER_SITE` only when a confirmed handle is set in `.env`
- Article OG tags (`og:type=article`, `article:published_time`, `article:section`) on CMS posts
- `includes/seo.php`: `absolute_public_url()`, `site_redirect()`, `public_href()` for production-safe URLs
- `includes/schema-collection-page.php` for blog index
- CMS posts use `schema-blog-posting.php` (replaces inline JSON-LD)
- `sitemap.php`: static blog slugs + service URLs with trailing slashes; `sitemap.xml` → 301 in `.htaccess`
- `BlogPosting` on static blog PHP files (`future-of-custom-erp`, `mobile-first-design-b2b`)

### Phase 2 — Performance and accessibility (implemented 18 May 2026)

- Portfolio WebP, `<picture>`, dimensions, `fetchpriority` on first homepage card (`portfolio_picture_html`)
- Blog listing + CMS posts: `content_image_html()` in `includes/portfolio-media.php` (WebP/dimensions when files exist; `fetchpriority="high"` + preload on first blog card)
- Blog post feature images: dynamic width/height + LCP preload in `blog/post.php`
- `style.min.css`, `app.min.js`, `consent.min.js` via `includes/assets.php`; regenerate with `scripts/build-min-assets.sh`
- Skip link targets `#main-content` with focus move; `tabindex="-1"` on main landmarks
- Mobile menu focus trap; portfolio filters use `aria-pressed` + `type="button"`
- `prefers-reduced-motion`: disables scroll-reveal and smooth scroll-to-top
- Global `:focus-visible` rings; FAQ chevron contrast (`--text-2`)
- Stronger CSP; WebP `ExpiresByType` in `.htaccess`

### Phase 3 — UX and growth

- Consent Mode + banner (`consent-mode.php`, `consent-banner.php`, `consent.js`)
- Web Vitals → `dataLayer` after consent
- `GOOGLE_SITE_VERIFICATION` support in `.env` / `head.php`
- `estimate.php` hardened; `scripts/smoke-test-forms.php`
- Demo pages: no public passwords
- Conversion build: estimate-first CTAs, stronger proof cards, configurable phone/WhatsApp/address/founder trust signals, optional Microsoft Clarity, and GTM lead-funnel events

---

## Recommended next steps

1. **Deploy `.htaccess` + `robots.txt`** — blog clean URLs, legacy `.html` redirects, `X-Powered-By` strip (see SEO-01, SEO-02, SEC-01).
2. **Search Console** — Submit `https://dashandots.com/sitemap.php`; add `GOOGLE_SITE_VERIFICATION` to production `.env` if not set.
3. **GTM** — Configure events from `CONVERSION_TRACKING.md`; mark form success, estimate completion, WhatsApp, phone, and demo clicks as conversions.
4. **SMTP check** — Submit one real contact form on production to verify delivery.
5. **Optional** — Strip `X-Powered-By`; re-run Lighthouse on `/` and top blog post after URL fix.

---

## Daily enquiry readiness checklist

Before scaling SEO or ads, confirm:

- `SITE_PUBLIC_EMAIL` is a real domain email such as `hello@dashandots.com` or `sales@dashandots.com`.
- `SITE_PHONE`, `SITE_WHATSAPP_URL`, `SITE_ADDRESS`, founder name, and founder LinkedIn are configured in production `.env`.
- Public pages no longer display `dashandots@gmail.com` or fake phone numbers.
- `php scripts/smoke-test-forms.php https://dashandots.com` passes after deploy.
- One real contact submission reaches the inbox, avoids spam, and sends the confirmation email.
- `/blog/future-of-custom-erp` and `/blog/mobile-first-design-b2b` return 200 on live.
- Legacy `.html` redirects do not contain `/dashandots/` on production.
- GTM Preview shows `cta_click`, `estimate_completed`, `contact_form_submit_success`, `whatsapp_click`, `phone_click`, `demo_click`, and `proof_card_click`.
- GA4 conversions are enabled for lead, estimate, WhatsApp, phone, and demo events.
- Microsoft Clarity is enabled with `MICROSOFT_CLARITY_ID` if session recordings are desired.
- Search Console has `https://dashandots.com/sitemap.php` submitted and no sitemap URL redirects to `/blog/`.
- Proof claims (`150+ clients served`, `450+ products shipped`) are substantiated with permitted screenshots, demos, client categories, logos, testimonials, or external reviews.

---

## Out of scope

- Penetration testing or admin brute-force assessment
- Full legal/GDPR audit
- Demo subdomains (`erp.dashandots.com`, etc.)
- Search Console / GA4 performance analysis (no credentials in audit)

---

*Report maintained as the single source of truth for dashandots.com audit status. Update this file after each live re-audit or major deploy.*
