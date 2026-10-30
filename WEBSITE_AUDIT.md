# Dashandots Website Audit — single source of truth

**Audit date:** 27 Oct 2026 · **Last updated:** 30 Oct 2026 (post-remediation)
**Production URL:** https://dashandots.com
**Codebase:** `/Applications/XAMPP/xamppfiles/htdocs/dashandots` (branch `main`, HEAD `de7031c`)
**Method:** live HTTP + HTML verification on production and on `http://localhost/dashandots/`, plus full codebase review of every public template, `includes/`, `.htaccess`, `robots.txt`, `sitemap.php` and the portfolio seed.

**This file replaces and supersedes:**

| Retired file | Date | Why retired |
|---|---|---|
| `seo_audit_report.md` | 25 Apr 2026 | Written for the old single-page `index.html` site. Architecture no longer exists. |
| `seo_comprehensive_audit.md` | 26 Apr 2026 | Pre-multi-page state; its live findings are either fixed or carried forward below. |
| `gemini_report.md` | May 2026 | Conversion audit. Still-valid points carried into §5 Trust & conversion. |
| `WEBSITE_AUDIT_2026-05.md` | 17 Sep 2026 | Previous source of truth. |
| `search_console_audit_hrmx.md` | 27 Oct 2026 | SERP gap audit for `/demo/hrmx`. Findings carried into §4 Demo & product pages. |

**Still live, not audits — do not delete:**

- `hrmx_seo_action_plan.md` — active implementation brief for `/demo/hrmx` (page copy, FAQ text, title/meta options, `[NEED]` fact list).
- `CONVERSION_TRACKING.md` — GTM/GA4 setup reference.

---

## 1. Executive summary

**The audit's code findings are fixed. None of them are on production.**

Thirteen findings were remediated in four commits (`a333e82`, `e3a8c5a`, `f9de283`, `7ed0580`), verified on localhost: `BreadcrumbList` on every service, demo, portfolio and blog page; `SoftwareApplication` on all product demo pages; every title inside 60 characters and every description inside 155, demo pages included; the sitemap's six-month-stale `lastmod` dates now derived; the unsubstantiated stat row gone; two accessibility defects closed. Two defects not in the original audit were also fixed: `/scripts/` was callable over HTTP, and the admin form silently rewrote the category of any graphics row.

**The single blocking item is a deploy.** Verified against production on 30 Oct 2026:

| Production check | Result |
|---|---|
| `BreadcrumbList` on `/`, `/demo/hrmx`, `/services/erp-development/` | **0** — not deployed |
| `SoftwareApplication` on `/demo/hrmx` | **0** — not deployed |
| "AMC" on `/demo/hrmx` (the HRMX rewrite) | **0** — not deployed |
| `450+` and `about-stat-row` on `/` | **still present** |
| "Get a free project estimate" on `/` | **still present** |
| `sitemap.php` `lastmod` values | 11× `2026-04-26`, plus `2024-04-10` / `2024-04-18` |

So the live site is still the site the audit described, minus nothing. Everything below marked ✅ means "fixed in `main`, pending deploy".

What remains after the deploy is not code: third-party proof, a Lighthouse run, founder details, a demo account, and a decision about the blog.

| Category | Score (local) | Score (live) | Status |
|---|---|---|---|
| Technical SEO | 94 | 90 | Sitemap dates derived; `/scripts/` closed |
| On-page SEO (per page) | 92 | 74 | Every page inside title/description limits |
| Structured data | 90 | 72 | Breadcrumbs + `SoftwareApplication` added; service-page FAQ still open |
| Content depth | 68 | 68 | Unchanged — blog is still 2 thin posts; 9 demo write-ups unstructured |
| Security | 94 | 88 | `/scripts/` exposure closed in repo, still open on live |
| Performance | 86 | 86 | Unchanged — `srcset` not wired, one 302 KB WebP |
| Accessibility | 92 | 88 | Blog heading level and `/404` h1 fixed |
| Trust & conversion | 68 | 58 | Stats removed, credentials strip added; third-party proof still zero |
| **Overall (weighted)** | **87** | **80** | **Deploy, then chase proof and Lighthouse** |

Weights: Technical SEO 20%, On-page 15%, Structured data 10%, Content 10%, Security 20%, Performance 10%, Accessibility 5%, Trust 10%.

---

## 2. Open findings

### P1 — blocking

| ID | Finding | What to do |
|---|---|---|
| **DEP-02** | **Nothing since `972edbb` is deployed.** Four remediation commits plus the HRMX content rewrite sit in `main` only. | Deploy `main`, then on production: `php scripts/migrate-portfolio-meta.sql` (adds the two SEO columns) and `php scripts/seed-portfolio-products.php` (publishes the HRMX pricing, ownership, geofence and rollout sections). Then re-run the §3 verification list. |
| **TRU-02** | **No third-party proof anywhere** — no named client, no testimonial, no review profile (Clutch/G2), no client logo row. Unchanged since April; the highest-leverage item on this list and not a code task. | Get written permission from the 1,200-employee HRMX client for an anonymised case study ("a security services company with 1,200+ staff across N sites"). |

### P2

| ID | Finding | What to do |
|---|---|---|
| **SCH-02** | **No `FAQPage` on any of the six service pages** (0 of 6). `/demo/hrmx` has one as of `972edbb`. | Needs 4–6 real questions per service written first; the schema plumbing already exists (`includes/demo-faqs.php` is the pattern, `$page['jsonld']` is the hook). |
| **PRF-04** | **Lighthouse not run since 18 May 2026** — before the hero rewrite, nav scroll-spy, trust-bar marquee and everything above. The old 87/92/100 figures are not evidence. | Run after the deploy on `/`, `/portfolio`, `/services/erp-development/`, `/demo/hrmx`, top blog post. Record here. |
| **TRU-03** | **No human element** — `SITE_FOUNDER_NAME` is unset, so the founder card never renders, while the trust bar claims "Founder-led scoping". | One `.env` line. Needs the name, title and LinkedIn URL; the render gate and `.founder-card` styling already exist. |
| **DEM-02b** | 18 of 19 product demo pages have no hand-written `meta_title`/`meta_description`. They are inside SERP limits via the generated fallback, so this is upside, not a defect. | Write them in admin, two fields per row, no deploy needed. `hrmx_seo_action_plan.md` §4–5 shows the house style. |

### P3

| ID | Finding | What to do |
|---|---|---|
| **PRF-01** | **No responsive `srcset`** — every viewport downloads the same file. `scripts/build-image-variants.sh` is committed but inert: no variants on disk, and `includes/portfolio-media.php` does not consume them. | Run the script, then add width descriptors plus a per-call `sizes` option to the `<source srcset>` branch of `portfolio_picture_html()`; teach `portfolio_image_meta()` to accept a `.webp` input path; route the hand-rolled demo hero `<img>` (`demo/_template.php`) through the helper. `sizes` is not optional — without it `srcset` assumes `100vw` and browsers pick the largest candidate on a ~380px tile, which is worse than today. |
| **PRF-02** | `assets/img/portfolio/todays-menu.webp` is **302 KB**; next largest is 171 KB. | Re-encode. |
| **PRF-03** | Heavy PNG originals (up to 2.6 MB) ship beside their WebP versions. Not served. | Optional: exclude from deploy. |
| **DEM-06** | **9 demo write-ups have no `h2`** — a wall of prose: `feasti`, `rs-robotics`, `sp-constructs`, `bharatiya-merit-party`, `smart4bharat`, `skill-bridge-india`, `writeeasy`, `snub-foods`, `inversio365`. | Content, editable in admin or via the seed. |
| **DEM-07** | **Open demo credentials blocked on a missing account.** Template code is done. | Create a restricted, synthetic-data-only account (`hrmx_seo_action_plan.md` §8 lists the requirements). |
| **CNT-01** | Blog is two posts, 367 and 330 words, no author, competing with the service pages. | Decision: grow past 1,000 words with author attribution and internal links, or `noindex, follow` them and start the content programme properly. Two thin posts is worse than none. |
| **TRU-05** | Competitors out-position on AI narrative and "book a call" parity. No calendar route on the site. | Product decision. |
| **CFG-01** | `TWITTER_SITE`, `MICROSOFT_CLARITY_ID`, `GOOGLE_SITE_VERIFICATION` all unset; service URLs still need a trailing slash (one extra 301 hop). | All optional. |

### Deliberately not done

- **Service-page `FAQPage`** (SCH-02) — needs copy, see above.
- **DEM-05 gallery alternative** — the 10 graphics pages are now `noindex` and out of the sitemap, which solves the index bloat. Folding them onto one gallery page is the cleaner end state but is a content decision. Note that `/portfolio`'s `ItemList` still enumerates them, so the list has members pointing at `noindex` URLs: coherent, not an error.
- **CNT-01 quick route** — `$page['robots'] = 'noindex, follow'` on the two thin posts is a one-line change and is being left alone pending the content decision.

---

## 3. Post-deploy verification list

Run these against production immediately after the deploy. Every one passes on localhost today.

1. `/services/*/`, `/demo/{slug}`, `/blog/{slug}` and `/portfolio` each emit **exactly one** `BreadcrumbList`.
2. Each non-graphics demo page emits one `SoftwareApplication`; `/demo/hrmx` also keeps its `FAQPage`.
3. Every `ld+json` block parses (pipe each through a JSON parser).
4. `/demo/hrmx` contains "AMC", "geofenced", "Mumbai" and "1,200".
5. `/` contains no `450+`, no `about-stat-row`, no "Get a free project estimate"; it does contain four `about-card` blocks.
6. Every title ≤ 60 chars and every description 120–155, across static pages and all 22 demo pages.
7. `sitemap.php` — no `2026-04-26`, no 2024 dates, no graphics slugs, no future dates, valid XML.
8. A graphics demo URL carries `noindex`; a product demo URL does not.
9. `/404` — only heading is the visible "Page not found", not the decorative glyph.
10. `/blog/` — card titles are `h2`, card spacing unchanged.
11. **`/scripts/seed-portfolio-products.php` returns 403.** ⚠️ Do **not** probe this before the deploy: the `.htaccess` deny and the CLI guard are both undeployed, so a request to that URL on production today would execute the seed and rewrite portfolio rows. Check it only after `main` is live.
12. Admin round-trip: save a graphics row and confirm `category` survives; save a demo row with and without the new meta fields and confirm the page reflects each, falling back correctly.
13. `php scripts/smoke-test-forms.php https://dashandots.com`.
14. Rich Results Test on one service page and one demo page.

---

## 4. Per-page state

Length targets: title ≤ 60 chars, meta description 120–155 chars. All figures measured on localhost at HEAD `de7031c`.

### 4.1 Homepage — `/` (`index.php`)

| Check | State |
|---|---|
| Title | 57 chars ✅ |
| Meta description | 126 chars, homepage-specific (was inheriting a 176-char default) ✅ |
| `og:title` | ~53 chars (was 97) ✅ |
| Canonical, keywords, H1, heading structure | ✅ unchanged |
| Schema | `Organization` + `WebSite` + `FAQPage`. No `BreadcrumbList`, which is correct for a homepage ✅ |
| LCP image | `hero-corporate-bg.webp` (28 KB) preloaded ✅ |
| Proof claims | Stat row deleted; replaced by four credential facts in `.about-cards` ✅ |
| Contact H2 | "Tell us what's slowing you down." ✅ |

### 4.2 Portfolio — `/portfolio`

Title 43 ✅ · description 129 ✅ · page-specific `keywords` added ✅ · `CollectionPage` + `ItemList` + `BreadcrumbList` ✅ · WebP with dimensions and `fetchpriority` on the first tile ✅.

### 4.3 Service pages (6)

| Page | Title | Desc | Schema |
|---|---|---|---|
| `erp-development` | 47 ✅ | 135 ✅ | `Service` + `BreadcrumbList` ✅ |
| `data-analytics` | 52 ✅ | 136 ✅ | ✅ |
| `ecommerce` | 50 ✅ | 149 ✅ | ✅ |
| `web-mobile-apps` | 47 ✅ | 138 ✅ | ✅ |
| `industry-systems` | 54 ✅ (was 83) | 151 ✅ | ✅ |
| `iot-embedded` | 45 ✅ | 148 ✅ | ✅ |

All six use the pipe separator. `Service` JSON-LD moved from the bottom of the body onto the shared `$page['jsonld']` hook, so the site has one schema path. `FAQPage` still missing (SCH-02).

### 4.4 Demo & product pages (22 indexable)

The deepest content on the site, and previously the thinnest SEO surface. Now:

- **Titles**: every page ≤ 60 chars. Resolution order is `portfolios.meta_title` → `includes/demo-seo.php` → generated, where the generated form appends the brand only when the result still fits.
- **Descriptions**: every page ≤ 155 chars, via `meta_description` → `demo-seo.php` → `short_description` trimmed on a word boundary. Thirteen rows were 180–249 chars.
- **Schema**: `BreadcrumbList` on all, `SoftwareApplication` on all non-graphics, `FAQPage` on `/demo/hrmx`.
- **Graphics (10 rows)**: `noindex, nofollow` and excluded from the sitemap.
- **`demo/erp.php`, `demo/tms.php`, `demo/hms.php`**: were duplicating `view.php`'s SEO setup and missing all of the above; now thin wrappers around it.
- Still open: DEM-06 (9 write-ups without headings), DEM-07 (demo account), DEM-02b (hand-written meta).

**HRMX positioning stands:** `hrmx` is a contested brand term owned by `hrmx.in`, `hrmx.ai` and `hrmx.tech`. Do not optimise for navigational `hrmx`; the page targets the evaluative long tail. The `[NEED]` list in `hrmx_seo_action_plan.md` (support response time, one anonymised case study, site count for the 1,200-employee deployment, biometric makes supported) is still unanswered and blocks the strongest copy.

### 4.5 Blog

`/blog/` title 39, desc 129 ✅, `CollectionPage` ✅, card titles now `h2` ✅. Both static posts: titles 58 and 52 ✅, `BlogPosting` + `BreadcrumbList` ✅, but still 367 and 330 words with no author (CNT-01). The CMS template carries the full SEO set ✅.

### 4.6 Legal & error pages

`/privacy-policy` 38/107 ✅ · `/terms` 40/144 ✅ · `/404` `noindex` with a real visible `h1` ✅.

### 4.7 Infrastructure

| File | State |
|---|---|
| `sitemap.php` | `lastmod` derived: `filemtime()` for the eight file-backed entries, `MAX(updated_at)` for `/`, `/blog/` and `/portfolio`, every value clamped to today. Graphics rows excluded. ✅ |
| `.htaccess` | `^scripts/` denied ✅, plus the existing www→apex, HTTPS, legacy `.html` 301s, `.php`→extensionless, `sitemap.xml`→`sitemap.php` |
| `scripts/*.php` | CLI-only guards ✅ |
| `robots.txt` | Correct; still carries the harmless duplicate `/dashandots/…` XAMPP block 🟢 |
| `llms.txt` | 200, markdown links ✅ |

---

## 5. Structured data summary

| Type | Where it is (local) | Gap |
|---|---|---|
| `Organization`, `WebSite` | `/` | — |
| `BreadcrumbList` | 6 service pages, all 22 demo pages, `/portfolio`, CMS + both static posts | — |
| `SoftwareApplication` | All non-graphics demo pages | No `offers` by design — there is no public price |
| `Service` | All 6 service pages | — |
| `FAQPage` | `/`, `/demo/hrmx` | **Service pages (SCH-02)** |
| `CollectionPage` | `/portfolio`, `/blog/` | — |
| `ItemList` | `/portfolio` | Enumerates `noindex` graphics rows (see §2) |
| `BlogPosting` | Both static posts + CMS posts | — |

---

## 6. Resolved — do not re-raise

### Fixed in this remediation pass (localhost-verified, pending deploy)

| ID | Was | Now |
|---|---|---|
| SCH-01 | No `BreadcrumbList` anywhere | On every service, demo, portfolio and blog page, via `includes/schema-breadcrumb.php` and the `$page['jsonld']` hook in `head.php` |
| DEM-04 | No schema of any kind on demo pages | `SoftwareApplication` + `BreadcrumbList` |
| DEM-02 | 13 demo descriptions 180–249 chars | All ≤ 155, word-boundary trimmed |
| DEM-03 | Demo titles up to 101 chars, double em-dash | All ≤ 60, pipe separator |
| DEM-05 | 10 thin graphics pages indexable and sitemapped | `noindex, nofollow`, out of the sitemap |
| ONP-01 | Homepage inherited a 176-char description | Page-specific, 126 chars |
| ONP-02 | `og:title` 97 chars | ~53 |
| ONP-03 | Contact H2 promised a free estimate under a "Talk to Our Team" button | "Tell us what's slowing you down." |
| ONP-04/05 | Portfolio title 64 chars, no keywords | 43 chars, page-specific keywords |
| ONP-06 | `industry-systems` title 83 chars, inconsistent separators | 54 chars, pipe everywhere; four other service titles trimmed |
| TEC-01 | Sitemap `lastmod` hard-coded and six months stale | Derived from `filemtime()` / `MAX(updated_at)`, clamped to today |
| TRU-01 | `450+ / 150+ / 5+` unsubstantiated | Deleted |
| TRU-04 | No credentials strip | Four defensible facts in the About section (NDA before engagement, you own the IP, AMC and 24/7 support, 48-hour response), using already-styled unused classes so no CSS changed |
| A11Y-01 | Blog cards `h3` under an `h1` | `h2`, with a compound selector so `style.css`'s legacy `.blog-card h2` rule cannot shift the spacing |
| A11Y-02 | `/404`'s only `h1` was a decorative glyph at `opacity:.15` | Real visible `h1`; glyph is `aria-hidden` |
| **SEC-10** | **New finding: `/scripts/` was reachable over HTTP.** `.htaccess` blocked `admin/run-*migration.php` and `test_*.php` but nothing under `scripts/`, and the PHP files there had no SAPI guard, so `seed-portfolio-products.php` could be invoked over the web and would rewrite portfolio content. | `^scripts/` denied in `.htaccess` plus a CLI-only guard in each script. **Still live on production until the deploy** — see §3 item 11. |
| **SEC-11** | **New finding: admin category whitelist was missing `graphics`**, so the edit form rendered all 10 graphics rows as "Web & SaaS" and one save silently rewrote `category` to `web` — which would have undone the noindex rule. | `graphics` added to the whitelist, the `<select>` and the `database.sql` comment. |

### Verified earlier and still true

| Was | Verified |
|---|---|
| Copywriting build not deployed (DEP-01) | Live since 27 Oct 2026 — 0 old CTAs, 0 "24 hours", no Solutions section |
| 4 service pages without `<!DOCTYPE>`/JSON-LD (SEO-05) | Live |
| `erp-development` canonical/title (SEO-06) | Trailing slash + pipe |
| Static blog clean URLs 302 → `/blog/` | 200 on both |
| `.html` 301s pointing at `/dashandots/…` on production | Resolve to apex |
| `X-Powered-By: PHP/8.2.30` | Header absent |
| `.env` in git history | Never committed |
| Open admin migration scripts | 403 |
| CORS `*` | Restricted to the site origin |
| Demo passwords in public HTML | Removed |
| Duplicate `sitemap.xml` | 301 → `sitemap.php` |
| Broken JSON-LD logo paths | `/assets/logo.webp` and `/assets/logo.png` both 200 |
| No consent management | Consent Mode v2 + banner + privacy policy live |
| GTM container empty / GA4 id misplaced | GTM v2 published; `page_view`, `cta_click`, key events verified |
| Rate limiter surfacing 429 as "Something went wrong" | Limiters removed; honeypot kept |
| Heavy PNGs, unminified assets | WebP + `<picture>` + minified CSS/JS sitewide |
| Portfolio limited to 13 rows on home | `/portfolio` with 29+ entries, filters, `ItemList` |
| `@gmail.com` public contact address | `hello@dashandots.com` live |
| Single-page architecture | Multi-page: 6 service landings, `/portfolio`, 22 indexable demo pages, blog |
| `FAQPage` missing on `/demo/hrmx` | Added in `972edbb` from `includes/demo-faqs.php`, same array as the visible accordion |

---

## 7. Out of scope

- Penetration testing, admin brute-force assessment
- Full legal/GDPR review
- Demo subdomains (`erp.dashandots.com` et al.)
- Search Console / GA4 performance data (no credentials available to this audit)
- Lighthouse field data (lab runs only, and not re-run this pass)

---

*Single source of truth for dashandots.com audit status. Update this file in place after each deploy or re-audit — do not create a new dated report. Next update due after the DEP-02 deploy, working through the §3 verification list and recording Lighthouse numbers.*
