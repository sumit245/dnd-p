# Website Audit Report — Dashandots Technology

**Last updated:** 17 Sep 2026 (live re-audit #2 — post copywriting audit)
**Previous:** 18 May 2026
**Production URL:** https://dashandots.com
**Codebase:** `/Applications/XAMPP/xamppfiles/htdocs/dashandots`
**Method:** Live HTTP/HTML verification on production + codebase review
**Supersedes:** `seo_audit_report.md`, `seo_comprehensive_audit.md` (single-page era — do not use for decisions)

---

## Executive summary

Dashandots is a multi-page PHP marketing site (service landings, `/portfolio`, dynamic blog, CMS admin, AI project-brief tool) with **Phases 0–3 remediations live on production**. All P1 items from the May audit are now **verified fixed on live**: static blog clean URLs return 200, legacy `.html` redirects resolve on the apex host, `X-Powered-By` is gone, `.env` was never committed.

Since May the site also gained: `/portfolio` page (30+ tiles, industry filters, `ItemList` schema), AI scoping brief replacing the ₹ estimator (no pricing shown), GTM tags + GA4 custom dimensions/key events, and a full **copywriting audit** (nav simplification, unified CTAs, 48-hour response promise, service-page SEO parity).

**What remains is a deploy, not a fix**: the copywriting-audit build (20 files) is in the local repo, uncommitted and not on production. Until deployed, live still shows old CTAs, "24 hours / 1 business day", four service pages without `<!DOCTYPE>`/JSON-LD, and the old hero headline.

| Category | Score (0–100) | Status |
|----------|---------------|--------|
| SEO & discoverability | 86 | Blog URLs fixed; service-page schema/keywords waiting on deploy |
| Security | 88 | All P1/P2 verified on live; `.env` clean in git |
| Performance | 88 | Unchanged since May; Lighthouse not re-run this pass |
| Accessibility | 88 | Unchanged; wizard ARIA roles added in repo |
| UX & compliance | 90 | Consent + privacy live; copy consistency pending deploy |
| **Overall (weighted)** | **88** | **Deploy the copywriting build, run DB script, re-run Lighthouse** |

Weights: SEO 25%, Security 30%, Performance 20%, Accessibility 15%, UX 10%.

---

## Live verification (17 Sep 2026)

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
| `X-Powered-By` | **absent** ✅ (was `PHP/8.2.30`) |
| `Server` | `hcdn` (Hostinger CDN) |

### Key endpoints

| URL | Status | Notes |
|-----|--------|-------|
| `/` | **200** | GTM, consent banner, WebP `<picture>`, `style.min.css` / `app.min.js` — **old copy** (pre-audit CTAs, "24 hours", Solutions section) |
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
| `/estimate.php` POST | **200** | Returns `summary`, `briefText`, `timelineStr`, `source` (`ai`/`template`) — no budget fields |
| `/logo.png` | **404** | Unused if schema uses `/assets/logo.png` |
| `/assets/logo.png` | **200** | Correct logo |
| `/assets/img/og-image.jpg` | **200** | Default OG image |
| `/blog/` | **200** | GTM present |
| `/blog/agentic-ai-software-development` | **200** | Clean canonical URL |
| `/blog/future-of-custom-erp` | **200** ✅ | Fixed (was 302 → `/blog/`) |
| `/blog/mobile-first-design-b2b` | **200** ✅ | Fixed |
| `/blog/future-of-custom-erp.php` | **200** | Article + GTM + `BlogPosting`; canonical points to clean slug |
| `/blog/future-of-custom-erp.html` | **301** → `https://dashandots.com/blog/future-of-custom-erp` ✅ | Fixed (was `/dashandots/…`) |
| `/services/erp-development` | **301** → `…/erp-development/` | Trailing-slash redirect |
| `/services/erp-development/` | **200** | GTM + consent banner; `<!DOCTYPE>` present |
| `/services/{ecommerce,web-mobile-apps,industry-systems,iot-embedded}/` | **200** | **No `<!DOCTYPE>`/`<html>`/`<body>`, no JSON-LD** on live — fixed in repo, pending deploy |
| `/services/data-analytics/` | **200** | Only service page with `Service` JSON-LD on live |
| `/portfolio` | **200** | 33 tiles, 2× JSON-LD (`ItemList` + `CollectionPage`) |
| `/demo/erp`, `/demo/crm` | **200** | Now `index, follow` (have content) and listed in sitemap — consistent; passwords not in HTML |
| `/privacy-policy` | **200** | GTM, cookies §7 with `#cookies` anchor |
| `/test_smtp.php` | **403** | Blocked by `.htaccess` |
| `/.env` | **403** | Blocked |
| `/llms.txt` | **200** | Markdown links (rewritten Sep 2026) |
| `/assets/css/style.min.css` | **200** | `Cache-Control: public, max-age=31536000, immutable` ✅ |

### Analytics and consent (homepage)

| Signal | Present on live `/` |
|--------|---------------------|
| GTM container | `GTM-TJ3ZLPNJ` |
| Consent Mode default | `gtag('consent', 'default', …)` |
| Cookie banner | `#consentBanner` |
| JSON-LD Organization logo | `https://dashandots.com/assets/logo.png` |
| GTM workspace | Version 2 published: Google Tag (G-WK4BH19XRG) + GA4 event tag + 7 DL variables |
| GA4 custom dimensions | `cta_location`, `cta_text`, `destination`, `service`, `project_type`, `demo_slug` |
| GA4 key events | `contact_form_submit_success`, `estimate_completed` |
| `google-site-verification` meta | **absent** (env var empty) — verify via DNS/GSC or set `GOOGLE_SITE_VERIFICATION` |
| `twitter:site` | absent (optional, `TWITTER_SITE` unset) |
| Microsoft Clarity | not enabled |

### Lighthouse reference (initial pass, 18 May 2026)

| Page | Performance | Accessibility | SEO | LCP |
|------|-------------|---------------|-----|-----|
| `/` | 87 | 92 | 100 | 3.2 s |
| `/services/erp-development/` | 99 | 94 | 100 | 1.8 s |
| `/blog/agentic-ai-software-development` | 82 | 94 | 100 | 4.8 s |

**Not re-run in the Sep 2026 pass** — run again after the copywriting build deploys (hero markup, nav scroll-spy JS and trust-bar marquee changed).

### Form API smoke tests

```bash
php scripts/smoke-test-forms.php --cli          # no Apache required
php scripts/smoke-test-forms.php https://dashandots.com
```

---

## Open findings

| ID | Sev | Category | Finding | Evidence | Recommendation |
|----|-----|----------|---------|----------|----------------|
| DEP-01 | **P1** | Deploy | Copywriting-audit build not on production | 20 modified files + 2 new (`includes/service-schema.php`, `scripts/update-copywriting-audit.php`) uncommitted locally; live `/` still has "Get Instant Estimate" ×2, "24 hours" ×2, "1 business day" ×3, `#solutions` section | Commit, push, deploy; then `php scripts/update-copywriting-audit.php` on prod (updates `hero_title`/`hero_description`) |
| SEO-05 | **P1** | SEO | 4 of 6 service pages ship without `<!DOCTYPE html>`, `<html>`, `<head>`, `<body>` and without `Service` JSON-LD | Live `ecommerce`, `web-mobile-apps`, `industry-systems`, `iot-embedded` start at `<meta charset>`; `ld+json` = 0 | **Fixed in repo** (wrappers + shared `service_schema()`); ships with DEP-01 |
| SEO-06 | **P2** | SEO | `erp-development` canonical lacked trailing slash; title used `—` not `|` | Live canonical `…/erp-development` vs 301 to `…/` | **Fixed in repo**; ships with DEP-01 |
| SEO-03 | P3 | SEO | Service URLs require trailing slash (extra 301 hop) | `/services/erp-development` → 301 | Optional: internal rewrite; all internal links already use `/` |
| SEO-04 | P3 | SEO | No `twitter:site` | Unset | Optional — set `TWITTER_SITE` only if handle is active |
| TRK-01 | **P2** | Tracking | `google-site-verification` not emitted | `GOOGLE_SITE_VERIFICATION` empty in `.env` | Confirm GSC ownership (DNS is fine) or set the meta value |
| TRK-02 | P3 | Tracking | Microsoft Clarity not enabled | `MICROSOFT_CLARITY_ID` unset | Optional; set if session recordings wanted |
| UX-02 | **P2** | Trust | `450+ / 150+ / 5+` stats still unsubstantiated | Removed from hero + trust bar in repo; remain in About `.about-stat-row` | Keep only numbers you can defend; add anonymised testimonials (offered, deferred as separate task) |
| UX-03 | P3 | Copy | Contact section h2 still says "Get a free project estimate." | `index.php` `#contact-heading`; button now "Talk to Our Team" | Rename to match (e.g. "Tell us what's slowing you down.") |
| CFG-01 | P3 | Config | `SITE_FOUNDER_NAME` commented out | Founder card not rendered | Enable if founder-led scoping is a selling point (trust bar now says "Founder-led scoping") |

---

## Resolved (verified on production)

| ID | Was | Resolution |
|----|-----|------------|
| SEO-01 (May) | Static blog clean URLs 302 → `/blog/` | **200** on live for both static posts (17 Sep 2026) |
| SEO-02 (May) | `.html` 301s to `/dashandots/…` | 301 → `https://dashandots.com/blog/{slug}` (17 Sep 2026) |
| SEC-01 (May) | `X-Powered-By: PHP/8.2.30` | Header absent on live (17 Sep 2026) |
| SEC-02 (May) | `.env` possibly in git history | `git log --all -- .env` empty — never committed (17 Sep 2026) |
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
| ANL-01 | GTM container empty / GA4 id in GTM slot | GTM v2 published with Google Tag + GA4 event tag; env-driven ids; CSP allows GA collect (Sep 2026) |
| ANL-02 | Rate limiter returned 429 as "Something went wrong" | Rate limiters removed from `contact-handler.php` / `estimate.php`; honeypot kept; JS surfaces server messages (Sep 2026) |
| ANL-03 | Consent banner buttons dead after reopen | Listeners bound before stored-choice return; footer "Cookie settings" link (Sep 2026) |
| EST-01 | ₹-lakh estimator scared prospects | Replaced by AI project brief (`includes/ai-brief.php`, DeepSeek/OpenAI, template fallback, pricing regex guard); no budget fields in response |
| PF-01 | Portfolio limited to 13 CMS rows on home | `/portfolio` page, 29 seeded entries incl. live products + Play Store apps + graphics; industry filters; `ItemList` schema |

---

## What is working well

- HTTPS discipline (HTTP + www → apex HTTPS, HSTS).
- Security headers and production-grade CSP (GTM, Fonts, analytics).
- `robots.txt` with sensible AI crawler policy and correct production disallows.
- Dynamic `sitemap.php` with services, legal, CMS, and static blog entries.
- Shared SEO head: canonical, OG, Twitter; CMS posts use clean `/blog/{slug}` URLs.
- GTM `GTM-TJ3ZLPNJ` with Google Consent Mode v2 and cookie banner.
- Contact and brief APIs: honeypot, restricted CORS (evil origin gets no ACAO — re-verified), safe JSON; no pricing anywhere in the brief.
- Portfolio WebP + responsive images on homepage; minified assets served.
- Admin migration endpoints blocked; test scripts not on production.
- `llms.txt` and structured data on homepage (FAQ, Organization with valid logo); `/portfolio` ships `ItemList` + `CollectionPage`.
- Analytics pipeline verified end-to-end: site → dataLayer → GTM → GA4 (`page_view`, `cta_click` with custom params, key events).
- Static assets served with `immutable` year-long cache on Hostinger CDN.

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

### Phase 4 — Copywriting audit (implemented 17 Sep 2026, **not yet deployed**)

- Nav: Industries/Solutions/FAQ removed; "Chat on WhatsApp" + "Scope Your Project"; sticky mobile bar WhatsApp · Call · Brief
- Homepage: new hero (`hero_title` split per sentence, tall accent "Your" on desktop, plain sentence on mobile); stats removed from hero + trust bar; trust bar CSS marquee on mobile; Mission/Vision, Solutions section, after-services CTA, engagement-models box removed; Industries get Challenge + Outcome, Startups → Construction & Real Estate; comparison table "Speed to Market" honest cell; wizard step-5 copy; all response promises → **48 hours**
- CTA vocabulary: one "Scope Your Project" per page (nav); context labels elsewhere ("Get Your Project Brief", "Start the 2-minute brief", "Scope Your ERP", "Brief Us on Yours"…); `data-cta-location` unchanged so GA4 `cta_text` differentiates wording
- Nav scroll-spy (`.nav-links a.active`) on homepage sections
- Service pages: HTML wrappers on 4 pages, `keywords`, `active_nav`, "Services ›" breadcrumbs, sentence-case headings, tracking attrs, mid-page CTA strips (web-apps, IoT), shared `includes/service-schema.php` → `Service` JSON-LD on all 6, ERP canonical/title fixes
- `contact-handler.php`, `privacy-policy.php` typo, `portfolio.php` CTA plate + empty state
- `scripts/update-copywriting-audit.php` (idempotent) + `database.sql` seed for new hero copy

### Phase 3 — UX and growth

- Consent Mode + banner (`consent-mode.php`, `consent-banner.php`, `consent.js`)
- Web Vitals → `dataLayer` after consent
- `GOOGLE_SITE_VERIFICATION` support in `.env` / `head.php`
- `estimate.php` hardened; `scripts/smoke-test-forms.php`
- Demo pages: no public passwords
- Conversion build: estimate-first CTAs, stronger proof cards, configurable phone/WhatsApp/address/founder trust signals, optional Microsoft Clarity, and GTM lead-funnel events

---

## Recommended next steps

1. **Commit + deploy the copywriting build** (DEP-01) — then on prod: `php scripts/update-copywriting-audit.php`; re-run `php scripts/smoke-test-forms.php https://dashandots.com`.
2. **Post-deploy live checks** — every `/services/*/` starts with `<!DOCTYPE html>` and has one `ld+json`; `/` has zero "Get Instant Estimate", "24 hours", "1 business day", `id="solutions"`; hero shows the new headline.
3. **Re-run Lighthouse** on `/`, `/portfolio`, `/services/erp-development/`, top blog post (hero/nav/marquee changed).
4. **Search Console** — confirm property is verified (DNS or set `GOOGLE_SITE_VERIFICATION`); sitemap already correct.
5. **Fund an AI key** (DeepSeek or OpenAI) — briefs currently fall back to template (`source: template`) on 402/429.
6. **Trust content** — decide on About stats (UX-02); draft anonymised testimonials (separate task, offered).
7. **Optional** — `SITE_FOUNDER_NAME`, Clarity, `twitter:site`, trailing-slash internal rewrite.

---

## Daily enquiry readiness checklist

Before scaling SEO or ads, confirm:

- ✅ `SITE_PUBLIC_EMAIL` is a real domain email — live shows `hello@dashandots.com`.
- ✅ `SITE_PHONE`, `SITE_WHATSAPP_URL`, `SITE_ADDRESS` configured (live shows `+91 9649240944`). ⬜ `SITE_FOUNDER_NAME` still commented out.
- ✅ Public pages no longer display `dashandots@gmail.com`; `+91 98765 43210` appears only as an input `placeholder`.
- ⬜ `php scripts/smoke-test-forms.php https://dashandots.com` passes after the DEP-01 deploy (local `--cli`: 14/14).
- ⬜ One real contact submission reaches the inbox, avoids spam, and sends the confirmation email.
- ✅ `/blog/future-of-custom-erp` and `/blog/mobile-first-design-b2b` return 200 on live.
- ✅ Legacy `.html` redirects do not contain `/dashandots/` on production.
- ✅ Static asset responses include `public, max-age=31536000, immutable` (Hostinger CDN, `Server: hcdn`); `ASSET_CDN_URL` not needed.
- ✅ GA4 receives `page_view`, `user_engagement`, `cta_click` with `cta_text/cta_location/destination` (verified via `collect` hits).
- ✅ GA4 key events: `contact_form_submit_success`, `estimate_completed`. ⬜ Consider also marking `whatsapp_click`, `phone_click`, `demo_click`.
- ⬜ Microsoft Clarity (`MICROSOFT_CLARITY_ID`) — optional, unset.
- ⬜ Search Console: confirm ownership; no sitemap URL redirects any more (✅ verified).
- ⬜ Proof claims: `450+ / 150+ / 5+` still in About section only; substantiate or trim. Hero + trust bar no longer show them.
- ⬜ AI provider funded so briefs return `source: "ai"` not `"template"`.

---

## Out of scope

- Penetration testing or admin brute-force assessment
- Full legal/GDPR audit
- Demo subdomains (`erp.dashandots.com`, etc.)
- Search Console / GA4 performance analysis (no credentials in audit)

---

*Report maintained as the single source of truth for dashandots.com audit status. Update this file after each live re-audit or major deploy. Next update due: after DEP-01 deploy + Lighthouse re-run.*
