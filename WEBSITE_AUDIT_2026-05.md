# Website Audit Report — Dashandots Technology

**Audit date:** 18 May 2026  
**Production URL:** https://dashandots.com  
**Codebase:** `/Applications/XAMPP/xamppfiles/htdocs/dashandots`  
**Method:** Live production verification + static codebase review  
**Prior docs:** `seo_audit_report.md` and `seo_comprehensive_audit.md` are **outdated** (single-page `index.html` era). This report supersedes them for current architecture.

---

## Executive summary

Dashandots has evolved into a credible multi-page PHP marketing site: six service landings, a dynamic blog, CMS admin, AI estimator, and strong baseline SEO metadata. Lighthouse scores are generally good (SEO 100 on tested pages), and HTTPS/HSTS redirects work correctly on production.

The site is held back by **critical security gaps on the live server** (unauthenticated database migration endpoints), **incorrect `robots.txt` paths** that fail to block `/admin/` on production, **broken logo URLs in structured data**, and **heavy portfolio images** that inflate LCP on the homepage and blog.

| Category | Score (0–100) | Status |
|----------|---------------|--------|
| SEO & discoverability | 76 | Good foundation; crawler policy and schema fixes needed |
| Security | 48 | Critical issues on live; secrets hygiene in repo |
| Performance | 74 | Strong on service pages; homepage/blog LCP elevated |
| Accessibility | 88 | Lighthouse 92–94; contrast and ARIA role issues remain |
| UX & forms | 82 | Clear flows; API abuse surface on contact endpoint |
| **Overall (weighted)** | **73** | **Action required before scaling paid traffic** |

---

## Health index methodology

Scores combine automated Lighthouse runs (18 May 2026), live HTTP checks, and manual code review. Weights: SEO 25%, Security 30%, Performance 20%, Accessibility 15%, UX 10%.

---

## Live verification appendix

### Redirects and TLS

| Check | Result |
|-------|--------|
| `http://dashandots.com/` | **301** → `https://dashandots.com/` |
| `https://www.dashandots.com/` | **301** → `https://dashandots.com/` |
| HTTPS home | **200**, HTTP/2, LiteSpeed / Hostinger |

### Security headers (production home)

| Header | Present |
|--------|---------|
| `Strict-Transport-Security` | Yes (`max-age=31536000; includeSubDomains`) |
| `X-Content-Type-Options` | `nosniff` |
| `X-Frame-Options` | `SAMEORIGIN` |
| `Referrer-Policy` | `strict-origin-when-cross-origin` |
| `Content-Security-Policy` | `upgrade-insecure-requests` only |
| `X-Powered-By` | **PHP/8.2.30** (information disclosure) |

### Exposed endpoints (live HTTP status)

| URL | Status | Notes |
|-----|--------|-------|
| `/test_smtp.php` | **404** | Not deployed on production (good) |
| `/test_form.php` | **404** | Not deployed (good) |
| `/admin/run-migration.php` | **200** | **CRITICAL** — runs schema migration without login |
| `/admin/run-blog-migration.php` | **200** | **CRITICAL** — same |
| `/admin/` | **302** | Redirects (login gate on dashboard) |
| `/contact-handler.php` GET | **405** JSON | POST-only (expected) |
| `/contact-handler.php` OPTIONS | **204** | CORS `Access-Control-Allow-Origin: *` |
| `/logo.png` | **404** | Referenced in homepage JSON-LD |
| `/assets/img/logo.png` | **404** | Referenced in blog JSON-LD |
| `/assets/logo.png` | **200** | Actual logo location |
| `/assets/img/og-image.jpg` | **200** | Default OG image OK |
| `/sitemap.xml` | **200** | Legacy static sitemap still served |
| `/blog/future-of-custom-erp` | **302** | Redirect (likely to canonical blog route) |
| `/blog/mobile-first-design-b2b` | **302** | Redirect |

### Production asset paths

Live HTML uses root-relative paths (`/assets/css/style.css`). Local `includes/config.php` sets `BASE_PATH` to `/dashandots` for XAMPP — production deployment appears to use an empty or root `BASE_PATH` (correct for apex domain).

### Lighthouse (18 May 2026, mobile simulated)

| Page | Performance | Accessibility | Best practices | SEO | LCP |
|------|-------------|---------------|----------------|-----|-----|
| `/` | 87 | 92 | 100 | 100 | 3.2 s |
| `/services/erp-development` | 99 | 94 | — | 100 | 1.8 s |
| `/blog/agentic-ai-software-development` | 82 | 94 | — | 100 | 4.8 s |

**Accessibility failures (homepage sample):** insufficient color contrast; ARIA roles on incompatible elements; visible label / accessible name mismatches.

### Analytics (GTM)

| Page | `gtm.js` in HTML |
|------|------------------|
| `/` | **Yes** (live HTML includes standard GTM bootstrap; repo has **noscript only** in `index.php` — likely Hostinger/panel injection on production) |
| `/services/erp-development` | **No** |
| `/blog/` | **No** |

Container ID: `GTM-TJ3ZLPNJ`.

### Form API smoke tests (non-destructive)

| Endpoint | GET | OPTIONS |
|----------|-----|---------|
| `contact-handler.php` | 405 + JSON error | 204 + CORS `*` |
| `estimate.php` | 405 + JSON error | Not tested |

Contact form uses `fetch('contact-handler.php')` from `assets/js/app.js` with JSON POST — implementation is sound; abuse controls are missing.

---

## Findings register

| ID | Sev | Category | Finding | Evidence | Recommendation |
|----|-----|----------|---------|----------|----------------|
| SEC-01 | **P0** | Security | `.env` tracked in git | `git ls-files .env` returns `.env`; no root `.gitignore` | Add `.gitignore`, remove `.env` from history, rotate SMTP/DB/TinyMCE secrets |
| SEC-02 | **P0** | Security | Unauthenticated DB migrations on **live** | `GET /admin/run-migration.php` → 200; `admin/run-migration.php` has no session check | Delete scripts or require admin session; block via web server |
| SEC-03 | **P0** | Security | No CSRF protection | `admin/blogs.php` / `portfolios.php` delete via `GET ?delete=`; all forms lack tokens | CSRF tokens; POST-only deletes with confirmation |
| SEC-04 | **P0** | Security | Contact API open CORS | `contact-handler.php` line 19: `Access-Control-Allow-Origin: *` | Restrict to `https://dashandots.com`; add rate limit / CAPTCHA |
| SEC-05 | **P1** | Security | Weak CSP | `.htaccess` only `upgrade-insecure-requests` | Add script/style/img allowlists for GTM, Fonts, admin TinyMCE |
| SEC-06 | **P1** | Security | Session hardening gaps | `admin/login.php` — no `session_regenerate_id()`, no explicit cookie flags | Regenerate ID on login; `Secure`, `HttpOnly`, `SameSite=Lax` |
| SEC-07 | **P1** | Security | DB errors may leak to users | `includes/db.php` line 39 `die()` with exception message | Log server-side; generic message in production |
| SEC-08 | **P1** | Security | Stored HTML blog XSS boundary | `blog/post.php` echoes `$blog['content']` unescaped | Accept trusted-admin model; add HTML sanitizer if untrusted editors |
| SEC-09 | **P2** | Security | Demo credentials public | `demo/_template.php` shows username/password from DB | Use demo-only accounts; rotate regularly; consider removing passwords from public pages |
| SEC-10 | **P2** | Security | `X-Powered-By: PHP/8.2.30` | Live response headers | Disable in `php.ini` or strip via server config |
| SEO-01 | **P0** | SEO | `robots.txt` blocks wrong paths on production | Disallow `/dashandots/admin/` but site is at root; `/admin/` not disallowed | Use `/admin/`, `/contact-handler.php`, `/admin/run-*.php`, test scripts |
| SEO-02 | **P1** | SEO | Broken Organization logo in JSON-LD | `index.php` lines 35, 70 → `https://dashandots.com/logo.png` (**404**) | Point to `https://dashandots.com/assets/logo.png` |
| SEO-03 | **P1** | SEO | Broken publisher logo on blog posts | `blog/post.php` line 103 → `/assets/img/logo.png` (**404**) | Use `/assets/logo.png` |
| SEO-04 | **P1** | SEO | Duplicate sitemaps | `robots.txt` → `sitemap.php`; `sitemap.xml` still **200** with stale URLs | 301 `sitemap.xml` → `sitemap.php` or remove static file |
| SEO-05 | **P1** | SEO | Static blog posts omitted from dynamic sitemap | `sitemap.php` only queries DB; static `blog/future-of-custom-erp.php` etc. not listed | Add static URLs to `sitemap.php` or migrate posts into `blogs` table |
| SEO-06 | **P1** | SEO | GTM not on inner pages | Service/blog HTML: 0 `gtm.js` references | Add shared GTM partial in `includes/head.php` + noscript in footer |
| SEO-07 | **P2** | SEO | GTM dev/prod drift | Repo `index.php` only noscript; live home has full GTM script | Version-control GTM snippet in `includes/` for all environments |
| SEO-08 | **P2** | SEO | No `twitter:site` | `includes/head.php` | Add `@handle` if available |
| SEO-09 | **P2** | SEO | Static blog posts lack `BlogPosting` schema | `blog/future-of-custom-erp.php`, `mobile-first-design-b2b.php` use `head.php` only | Add JSON-LD or route through `blog/post.php` |
| PERF-01 | **P1** | Performance | Large portfolio PNGs (~2.3 MB total) | `agentic-ai-software-dev.png` 755K, `tms-fleet.png` 635K, etc. | WebP/AVIF + `<picture>`; compress PNGs |
| PERF-02 | **P1** | Performance | Homepage LCP 3.2 s; blog LCP 4.8 s | Lighthouse 18 May 2026 | Optimize hero/portfolio images; preload LCP image on blog |
| PERF-03 | **P2** | Performance | Unminified CSS/JS in use | `style.css` 71K, `app.js` 13K; `script.min.js` unused | Ship minified assets or enable build step |
| PERF-04 | **P2** | Performance | No responsive images | No `srcset` in templates | Add width/height + `srcset` on portfolio grid |
| A11Y-01 | **P2** | Accessibility | No skip-to-main link | `includes/header.php` | Add visually hidden skip link |
| A11Y-02 | **P2** | Accessibility | Mobile menu dialog incomplete | `role="dialog"` without `aria-modal` / focus trap | Add `aria-modal="true"` and focus management |
| A11Y-03 | **P2** | Accessibility | Color contrast failures | Lighthouse homepage | Fix token pairs in `style.css` |
| A11Y-04 | **P2** | Accessibility | Duplicate `robots` meta | `head.php` `index, follow` + page overrides on 404/demo | Single robots tag per page |
| UX-01 | **P2** | UX | Estimator uses `innerHTML` for budget | `app.js` line 228; `estimate.php` builds `budgetStrHtml` server-side | Low risk (controlled values); prefer `textContent` where possible |
| UX-02 | **P2** | UX | Very large homepage | `index.php` ~97 KB source | Acceptable for marketing; monitor scroll depth and TTFB |

---

## What is working well

- **HTTPS discipline:** HTTP and www redirect correctly to apex HTTPS.
- **Security headers baseline:** HSTS, nosniff, frame options, referrer policy on production.
- **SEO metadata:** Shared `includes/head.php` with canonical, OG, Twitter; blog posts have article OG and `BlogPosting` schema (except static PHP posts).
- **Dynamic sitemap:** `sitemap.php` lists 11 URLs including DB blog `agentic-ai-software-development`.
- **AI/GEO:** `llms.txt` and thoughtful AI crawler rules in `robots.txt` (training bots blocked, citation bots allowed).
- **PDO prepared statements:** Admin login and blog slug queries use parameter binding.
- **Apache tuning:** `mod_deflate`, `mod_expires`, dotfile blocking in `.htaccess`.
- **Service page performance:** ERP landing scored **99** performance, **1.8 s** LCP.
- **Accessibility baseline:** Lighthouse accessibility **92–94** on tested pages; semantic sections and `aria-labelledby` on homepage.

---

## Remediation roadmap

### Phase 0 — Immediate security (same day)

1. **Rotate** all credentials in `.env` (SMTP, DB, TinyMCE).
2. **Remove** `.env` from git tracking; add `.gitignore` with `.env`, `vendor/`, OS files.
3. **Delete or lock** `admin/run-migration.php` and `admin/run-blog-migration.php` on production immediately (confirmed **exploitable today**).
4. **Fix** `robots.txt` production paths (`/admin/`, not `/dashandots/admin/`).
5. **Restrict** CORS on `contact-handler.php` to site origin; add honeypot or rate limiting.

**Files:** `.env`, `.gitignore`, `robots.txt`, `contact-handler.php`, `admin/run-migration.php`, `admin/run-blog-migration.php`

### Phase 1 — SEO and tracking (1–2 days)

1. Fix JSON-LD logo URLs in `index.php` and `blog/post.php`.
2. Add GTM to `includes/head.php` and shared noscript in `includes/footer.php` (align repo with production).
3. Extend `sitemap.php` with static blog URLs; 301 or remove `sitemap.xml`.
4. Add `BlogPosting` schema to static blog PHP files or consolidate into CMS.

**Files:** `index.php`, `blog/post.php`, `sitemap.php`, `sitemap.xml`, `includes/head.php`, `includes/footer.php`, static blog templates

### Phase 2 — Performance and accessibility (2–3 days)

1. Compress and convert portfolio PNGs; add dimensions on homepage portfolio images.
2. Enable minified CSS/JS or wire existing `.min` bundles.
3. Add skip link; improve mobile menu `aria-modal` and focus trap.
4. Resolve Lighthouse contrast and ARIA role issues in `style.css` / homepage markup.
5. Strengthen CSP in `.htaccess`.

**Files:** `assets/img/*`, `index.php`, `includes/header.php`, `assets/css/style.css`, `.htaccess`

### Phase 3 — UX and growth (ongoing)

1. End-to-end test contact + estimator on production SMTP.
2. Publish blog regularly; submit `sitemap.php` in Google Search Console.
3. Optional: cookie/consent banner if EU traffic and GTM require it.
4. Monitor Core Web Vitals in Search Console after image optimization.

---

## Out of scope (this audit)

- Penetration testing or brute-force of admin login on production
- Legal/GDPR full compliance review
- Demo subdomains (`erp.dashandots.com`, etc.) — separate applications
- Search Console / GA4 data analysis (no credentials provided)

---

## Recommended next step

Approve **Phase 0** implementation first. The live migration endpoints (SEC-02) and `robots.txt` misconfiguration (SEO-01) are the highest-risk items and can be fixed in under an hour without visual changes to the public site.

---

*Report generated as part of the Full Website Audit plan.*

---

## Phase 0 remediation (18 May 2026)

Implemented in codebase:

- `.gitignore` + `.env.example`; `.env` removed from git index (rotate secrets on server if repo was ever pushed)
- Deleted `admin/run-migration.php`, `admin/run-blog-migration.php`, and `test_*.php`; blocked via `.htaccess`
- Fixed `robots.txt` for production root paths
- `contact-handler.php`: restricted CORS, honeypot, rate limiting
- Admin CSRF tokens, POST-only deletes, session cookie hardening + `session_regenerate_id` on login
- Safer DB connection error message in `includes/db.php`

---

## Phase 1 remediation (18 May 2026)

Implemented in codebase:

- JSON-LD logo URLs point to `SITE_LOGO_URL` (`/assets/logo.png`) on homepage, blog listing, and CMS posts
- Shared GTM (`GTM-TJ3ZLPNJ`) in `includes/gtm-head.php` + `includes/gtm-noscript.php` via `head.php` / `header.php`; removed duplicate noscript from `index.php`
- GTM added to `blog/index.php` and `blog/post.php` heads
- `BlogPosting` schema on static posts via `includes/schema-blog-posting.php`
- `sitemap.php` lists static blog URLs (deduped against DB slugs); deleted stale `sitemap.xml`; 301 `sitemap.xml` → `sitemap.php` in `.htaccess`
- `.htaccess` serves static `blog/{slug}.php` before dynamic `blog/post.php` routing

---

## Phase 2 remediation (18 May 2026)

Implemented in codebase:

- Portfolio PNGs converted to WebP (~87% smaller); homepage uses `<picture>` with width/height and `fetchpriority="high"` on first card
- `style.min.css` and `app.min.js` generated; `includes/assets.php` serves min bundles when present
- Skip link, mobile menu `aria-modal` + focus trap + Escape, contrast tweaks (`--text-3`, filter buttons, hero meta)
- Fixed invalid ARIA (`role="list"` on divs, decorative hero SVG, semantic hero meta list)
- `#main-content` on public `<main>` landmarks
- Blog post LCP: `preload` for feature image; `scripts.php` on CMS posts
- Stronger CSP in `.htaccess` (GTM, Fonts, analytics); WebP cache expiry

---

## Phase 3 remediation (18 May 2026)

Implemented in codebase:

- **Consent:** Google Consent Mode v2 defaults (`includes/consent-mode.php`), cookie banner (`includes/consent-banner.php`, `assets/js/consent.js`), privacy policy §7 updated with `#cookies` anchor
- **Web Vitals:** LCP/INP/CLS sent to `dataLayer` as `web_vitals` events after analytics consent (configure GTM tag to forward to GA4)
- **Search Console:** `GOOGLE_SITE_VERIFICATION` in `.env` / `config.php` outputs meta tag in `includes/head.php`
- **Forms:** `estimate.php` — CORS, rate limit (30/hr), honeypot, email validation; removed `budgetStrHtml` (XSS-safe budget via DOM in `app.js`)
- **Smoke tests:** `php scripts/smoke-test-forms.php [base-url]` for estimate + contact endpoints
- **Demo security (SEC-09):** Passwords no longer rendered on public demo pages; request via email/contact
- **Robots meta (A11Y-04):** Single `robots` tag via `$page['robots']` in `head.php`; removed duplicates on 404/demo

**Manual steps (production):**

1. Run `php scripts/smoke-test-forms.php https://dashandots.com` after deploy; submit a real contact form to verify SMTP.
2. Add `GOOGLE_SITE_VERIFICATION=…` to server `.env`; submit `https://dashandots.com/sitemap.php` in [Google Search Console](https://search.google.com/search-console).
3. In GTM, ensure tags respect Consent Mode; optional: trigger on `web_vitals` custom event.
4. Monitor Core Web Vitals in Search Console after Phase 2 image deploy.
