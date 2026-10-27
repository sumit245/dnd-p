# Dashandots Website Audit — single source of truth

**Audit date:** 27 Oct 2026
**Production URL:** https://dashandots.com
**Codebase:** `/Applications/XAMPP/xamppfiles/htdocs/dashandots` (branch `main`, HEAD `c63b5e0`)
**Method:** live HTTP + HTML verification on production, plus full codebase review of every public template, `includes/`, `.htaccess`, `robots.txt`, `sitemap.php` and the portfolio seed.

**This file replaces and supersedes:**

| Retired file | Date | Why retired |
|---|---|---|
| `seo_audit_report.md` | 25 Apr 2026 | Written for the old single-page `index.html` site. Architecture no longer exists. |
| `seo_comprehensive_audit.md` | 26 Apr 2026 | Pre-multi-page state; its live findings are either fixed or carried forward below. |
| `gemini_report.md` | May 2026 | Conversion audit. Still-valid points carried into §5 Trust & conversion. |
| `WEBSITE_AUDIT_2026-05.md` | 17 Sep 2026 | Previous source of truth. Its open findings are re-verified below (most now closed). |
| `search_console_audit_hrmx.md` | 27 Oct 2026 | SERP gap audit for `/demo/hrmx`. Findings carried into §4 Demo & product pages. |

**Still live, not audits — do not delete:**

- `hrmx_seo_action_plan.md` — active implementation brief for `/demo/hrmx` (page copy, FAQ text, title/meta options, `[NEED]` fact list). Referenced from DEM-01 below.
- `CONVERSION_TRACKING.md` — GTM/GA4 setup reference.

---

## 1. Executive summary

The September copywriting build **is deployed**. Live `/` has zero instances of "Get Instant Estimate", "24 hours" or "1 business day", no `id="solutions"` section, and seven "48 hours" promises. All four previously broken service pages now serve `<!DOCTYPE html>`, `Service` JSON-LD and `keywords`. That closes DEP-01, SEO-05 and SEO-06 from the September audit.

The site's technical SEO floor is solid: HTTPS/HSTS, correct canonicals, dynamic sitemap, CSP, consent mode, GTM→GA4 verified, WebP everywhere, minified assets with immutable caching.

**What is actually holding the site back now is not infrastructure. It is three things:**

1. **~29 demo/product pages are the site's biggest content asset and its weakest SEO surface.** They carry the real buying content (HRMX alone is 1,133 words live) but have generic titles, over-length meta descriptions (180–250 chars), no breadcrumb schema, no `Product`/`SoftwareApplication`/`FAQPage` schema, no keywords, and 10 of them are thin graphics pages that are indexable and sitemapped.
2. **A second deploy gap has opened.** The HRMX pricing-drivers, data-and-ownership and geofence content exists in `scripts/seed-portfolio-products.php` locally but is **not on production** — live `/demo/hrmx` has no mention of AMC, geofencing, Mumbai hosting or the 1,200-employee deployment. Two files sit uncommitted.
3. **Zero third-party proof, still.** No named client, no testimonial, no review profile, no certification. Every audit since April has said this. It is the single highest-leverage item left and it is not a code task.

| Category | Score | Movement since 17 Sep | Status |
|---|---|---|---|
| Technical SEO | 90 | ↑ from 86 | Service pages fixed on live; sitemap `lastmod` stale |
| On-page SEO (per page) | 74 | new breakdown | Title/desc length overruns; demo pages under-optimised |
| Structured data | 72 | new breakdown | No breadcrumbs anywhere; demo pages have no schema |
| Content depth | 68 | — | Blog is 2 thin posts (330–370 words); 10 thin demo pages |
| Security | 90 | ↑ from 88 | All P1/P2 verified; nothing new found |
| Performance | 86 | — | WebP + minify good; no `srcset`; one 302 KB WebP |
| Accessibility | 88 | — | Not re-tested this pass; no regressions found in code |
| Trust & conversion | 58 | — | Unsubstantiated stats, no third-party proof |
| **Overall (weighted)** | **80** | — | **Deploy the seed, then fix demo-page SEO** |

Weights: Technical SEO 20%, On-page 15%, Structured data 10%, Content 10%, Security 20%, Performance 10%, Accessibility 5%, Trust 10%.

---

## 2. Live verification (27 Oct 2026)

All checks returned **200** with no unexpected redirects:

`/` · `/portfolio` · `/blog/` · `/demo/hrmx` · `/services/erp-development/` · `/services/ecommerce/` · `/services/iot-embedded/` · `/sitemap.php` · `/robots.txt` · `/llms.txt` · `/privacy-policy` · `/terms` · `/assets/logo.webp` · `/assets/logo.png`

Copywriting-build assertions on live `/`:

| Assertion | Result |
|---|---|
| "Get Instant Estimate" occurrences | **0** ✅ |
| "24 hours" occurrences | **0** ✅ |
| "1 business day" occurrences | **0** ✅ |
| "48 hours" occurrences | 7 ✅ |
| `id="solutions"` section | **absent** ✅ |
| "Scope Your Project" occurrences | 2 ✅ |

Service-page assertions on live `/services/ecommerce/`:

| Assertion | Result |
|---|---|
| `<!DOCTYPE html>` first line | present ✅ |
| `application/ld+json` blocks | 1 ✅ |
| `meta name="keywords"` | present ✅ |

Security headers, TLS behaviour, blocked admin/migration/test endpoints and CORS restriction were verified in the 17 Sep pass and no code touching them has changed since (`git log` shows only the copywriting commit). **Not re-tested this pass** — re-verify after the next deploy.

---

## 3. Per-page audit

Length targets used: title ≤ 60 chars, meta description 120–155 chars.

### 3.1 Homepage — `/` (`index.php`)

| Check | Finding |
|---|---|
| Title | `Custom ERP & CRM Software Developer in India \| Dashandots` — **57 chars** ✅ |
| Meta description | Inherited from `includes/config.php` default — **176 chars, truncates in SERP** 🟠 (ONP-01) |
| `og:title` | **97 chars** — far past the ~70 that renders in social previews 🟡 (ONP-02) |
| Canonical | `https://dashandots.com/` ✅ |
| Keywords | 3 terms, not stuffed ✅ |
| H1 | 1, from DB `hero_title` ✅ |
| Heading structure | h1 ×1, h2 ×13, h3 ×50, h4 ×5 — no skipped levels ✅ |
| Schema | `@graph` with `Organization` + `WebSite` + `FAQPage` ✅. **No `BreadcrumbList`** (acceptable on home) |
| `Organization.logo` | `SITE_LOGO_URL` → `/assets/logo.webp`; both `.webp` and `.png` return 200 ✅ |
| LCP image | `hero-corporate-bg.webp` (28 KB) preloaded ✅ |
| Proof claims | `450+ / 150+ / 5+` still in the About stat row, unsubstantiated 🔴 (TRU-01) |
| Contact section H2 | Still "Get a free project estimate." while the button says "Talk to Our Team" 🟡 (ONP-03) |

### 3.2 Portfolio — `/portfolio` (`portfolio.php`)

| Check | Finding |
|---|---|
| Title | **64 chars** — slight overrun 🟡 (ONP-04) |
| Meta description | 132 chars ✅ |
| Canonical | `/portfolio` (no trailing slash, consistent with sitemap) ✅ |
| Keywords | **absent** (falls back to the generic 3-term default) 🟡 (ONP-05) |
| H1 | "Systems in daily use." ✅ |
| Schema | `CollectionPage` + `ItemList` ✅ |
| Images | `portfolio_picture_html()` → WebP + dimensions + `fetchpriority` on first tile ✅ |
| Internal links | Links out to every indexable demo page — this is the site's main hub ✅ |
| Filters | `aria-pressed`, `type="button"` ✅ |

### 3.3 Service pages (6) — `/services/*/`

All six now ship wrappers, `keywords`, `Service` JSON-LD, "Services ›" breadcrumb text, sentence-case H1, tracking attributes. Remaining per-page defects:

| Page | Title len | Desc len | Issue |
|---|---|---|---|
| `erp-development` | 64 | **157** | Title and description both marginally long 🟡 |
| `data-analytics` | 69 | **169** | Longest description on the site 🟠 |
| `ecommerce` | 62 | 152 | Title slightly long 🟡 |
| `web-mobile-apps` | 66 | **160** | Both long 🟡 |
| `industry-systems` | **83** | 151 | **Worst title on the site** — truncates to roughly "Industry Management Systems — HMS, Hotel PMS, TMS &…" 🟠 (ONP-06) |
| `iot-embedded` | 66 | 148 | Title slightly long 🟡 |

Shared gaps across all six:

- **No `BreadcrumbList` schema** — the breadcrumb is visual text only, so it earns no SERP breadcrumb trail (SCH-01).
- **No `FAQPage` schema** on any service page, though every page has FAQ-shaped content in prose (SCH-02).
- Titles use an em-dash in `industry-systems` where the other five use a pipe — inconsistent brand suffix pattern (ONP-06).

### 3.4 Blog

| Page | Finding |
|---|---|
| `/blog/` | Title 41, desc 129 ✅. `CollectionPage` schema ✅. **Heading jump: h1 → h3** on post cards, no h2 🟡 (A11Y-01) |
| `/blog/future-of-custom-erp` | Title **67 chars** 🟡. 138-char desc ✅. `BlogPosting` ✅. **367 words** — thin 🔴 (CNT-01). 2 internal links |
| `/blog/mobile-first-design-b2b` | Title **70 chars** 🟡. 128-char desc ✅. `BlogPosting` ✅. **330 words** — thin 🔴 (CNT-01). 3 internal links |
| `/blog/post.php` (CMS) | Full SEO set: article OG tags, `keywords` from the row, `BlogPosting`, dynamic image dimensions, LCP preload ✅ |

Two 350-word posts is not a content programme. Neither post carries an author, and neither targets a query the service pages are not already competing for (CNT-01, CNT-02).

### 3.5 Legal & error pages

| Page | Finding |
|---|---|
| `/privacy-policy` | Title 38, desc 107 ✅. h1 + 11×h2 ✅. Cookies §7 with `#cookies` anchor ✅ |
| `/terms` | Title 40, desc 144 ✅. Structure matches privacy ✅ |
| `/404` | `robots: noindex` ✅. H1 is a decorative "404" at `opacity:.15` — **the page's only h1 is near-invisible** 🟡 (A11Y-02) |

### 3.6 Infrastructure pages

| File | Finding |
|---|---|
| `sitemap.php` | Correct structure, `X-Robots-Tag: noindex`, DB-driven blog + demo URLs, phantom-safe ✅. **`lastmod` for home, all 6 service pages and both legal pages is hard-coded `2026-04-26`** — six months stale after a copy rewrite 🟠 (TEC-01). Static blog `lastmod` says `2024-04-10` / `2024-04-18`, inconsistent with every other date on the site 🟡 |
| `robots.txt` | Correct production disallows, AI-crawler policy, sitemap pointer ✅. Still carries the duplicate `/dashandots/...` XAMPP block — harmless on production, noise for anyone reading it 🟢 |
| `.htaccess` | www→apex, HTTP→HTTPS, legacy `.html` 301s, `.php`→extensionless, `sitemap.xml`→`sitemap.php` ✅ |
| `llms.txt` | 200, markdown links ✅ |

---

## 4. Demo & product pages — the biggest gap (29 URLs)

`demo/view.php` + `demo/_template.php` render every row in `portfolios` that has a demo URL or a write-up. They are indexable and sitemapped. They are also the only pages on the site with deep, specific, buyer-grade content — and they get the least SEO scaffolding of any page type.

### Findings

| ID | Sev | Finding | Evidence |
|---|---|---|---|
| **DEM-01** | 🔴 P1 | **HRMX content rewrite is not on production.** The pricing-drivers, AMC, data-and-ownership, geofence and 1,200-employee facts exist in the local seed but not live. | Local `scripts/seed-portfolio-products.php` contains `AMC` ×2, `geofenc` ×2, `Mumbai` ×2, `1,200` ×1. Live `/demo/hrmx` contains **none** of them; its h2 list is still the old six sections. Two files uncommitted: `demo/_template.php`, `scripts/seed-portfolio-products.php`. |
| **DEM-02** | 🟠 P2 | **Meta descriptions are `short_description` verbatim and 13 of them exceed 180 chars** — up to 249. All truncate in SERP. | `trustmerecycle` 244, `snub-foods` 249, `lloyd-wfm` 234, `feasti` 241, `writeeasy` 241, `smart4bharat` 224, `bus-booking` 213, `waba` 210 … |
| **DEM-03** | 🟠 P2 | **Titles are `{Title} — Dashandots Technology`, carrying no query terms.** HRMX's own title is 74 chars with two em-dashes: `HRMX — HR, Attendance & Payroll Management System — Dashandots Technology`. | `demo/view.php:22` |
| **DEM-04** | 🟠 P2 | **No schema of any kind on demo pages** — no `SoftwareApplication`, no `Product`, no `BreadcrumbList`, no `FAQPage`. The site's most commercial pages are structurally invisible. | `grep ld+json demo/` → 0 |
| **DEM-05** | 🟡 P3 | **10 graphics entries are indexable and sitemapped with no headings and ~120–140 chars of copy.** Index bloat around the pages that matter. | `tapzo-cashback`, `fast-food-banner`, `detox-story`, `petoo-bhau-burger`, `rashmika-coffee`, `snubfoods-chips`, `merienda-snacks`, `flax-protein-bar`, `todays-menu`, `italian-pizza` — all `h2=0` |
| **DEM-06** | 🟡 P3 | **9 non-graphics entries also have `h2=0`** in `detailed_description` — a wall of prose with no scannable structure. | `feasti`, `rs-robotics`, `sp-constructs`, `bharatiya-merit-party`, `smart4bharat`, `skill-bridge-india`, `writeeasy`, `snub-foods`, `inversio365` |
| **DEM-07** | 🟡 P3 | **Open demo credentials still blocked on a missing account.** Template code is done; no demo account exists. | `hrmx_seo_action_plan.md` §8 |

### HRMX specifically

The SERP audit's verdict stands: `hrmx` is a contested brand term owned by `hrmx.in`, `hrmx.ai` and `hrmx.tech`. Do not optimise for navigational `hrmx`. The open items from `hrmx_seo_action_plan.md` are, in priority order: deploy the written sections (DEM-01), add the FAQ block with `FAQPage` schema, add the geofence and per-department sections, add the numbered 8–10 week rollout timeline, then update title and meta. The `[NEED]` list in that file (support response time, one anonymised case study, site count for the 1,200-employee deployment, biometric makes supported) is still unanswered and blocks the strongest copy.

---

## 5. Trust & conversion

Carried forward from `gemini_report.md` and the competitive audit, re-checked against the current site.

| ID | Sev | Finding | State today |
|---|---|---|---|
| **TRU-01** | 🔴 P1 | `450+ projects / 150+ clients / 5+ years` unsubstantiated | Removed from hero and trust bar; **still in the About stat row**. Either defend the numbers or trim them. |
| **TRU-02** | 🔴 P1 | **No third-party proof anywhere** — no named client, no testimonial, no review profile (Clutch/G2), no client logo row | Unchanged since April. Highest-leverage item on this list. The 1,200-employee, 3-year HRMX deployment is a case study waiting for permission. |
| **TRU-03** | 🟠 P2 | No human element — no founder card, no team, no faces | `SITE_FOUNDER_NAME` still commented out in config while the trust bar says "Founder-led scoping" |
| **TRU-04** | 🟠 P2 | No credentials strip (NDA available · you own the IP · AMC & support) | These facts are true and documented in the HRMX brief but appear on no page |
| **TRU-05** | 🟡 P3 | Competitors (ValueCoders, Flexsin, Ksolves) out-position on AI narrative and "book a call" parity | Site has "Scope Your Project" but no calendar/book-a-call route |
| ✅ Fixed | — | `@gmail.com` contact address | Live shows `hello@dashandots.com` + `+91 9649240944` |
| ✅ Fixed | — | AI scoping tool buried at page bottom | Elevated; hero and nav CTAs route to it |
| ✅ Fixed | — | ₹-lakh estimator scaring prospects | Replaced by the AI project brief; no pricing in output |

---

## 6. Performance

| ID | Sev | Finding |
|---|---|---|
| PRF-01 | 🟡 P3 | **No responsive `srcset`** on any image — every viewport downloads the same file. Carried over unresolved from the April audit (I-04). |
| PRF-02 | 🟡 P3 | `assets/img/portfolio/todays-menu.webp` is **302 KB**; next largest is 171 KB. Re-encode. |
| PRF-03 | 🟢 P4 | Heavy PNG originals (up to 2.6 MB) sit in `assets/img/` beside their WebP versions. Not served, but they ship with the deploy. |
| PRF-04 | 🟠 P2 | **Lighthouse has not been run since 18 May 2026** — before the hero rewrite, nav scroll-spy and trust-bar marquee. The 87/92/100 figures in the old report are no longer evidence. |

Working well: WebP coverage is complete for every heavy image, `style.min.css` (59 KB) / `app.min.js` (13.5 KB) are current with their sources, `Cache-Control: public, max-age=31536000, immutable` on static assets via Hostinger CDN.

---

## 7. Structured data summary

| Type | Where it is | Where it should also be |
|---|---|---|
| `Organization`, `WebSite` | `/` | — |
| `FAQPage` | `/` only | Service pages, `/demo/hrmx` (SCH-02) |
| `Service` | All 6 service pages ✅ | — |
| `CollectionPage` | `/portfolio`, `/blog/` ✅ | — |
| `ItemList` | `/portfolio` ✅ | — |
| `BlogPosting` | Both static posts + CMS posts ✅ | — |
| **`BreadcrumbList`** | **Nowhere** | Every service page, every demo page, every blog post (SCH-01) |
| **`SoftwareApplication` / `Product`** | **Nowhere** | All 19 non-graphics demo pages (DEM-04) |

---

## 8. Prioritised action plan

### P1 — do first

1. **DEM-01 / deploy gap.** Commit `demo/_template.php` + `scripts/seed-portfolio-products.php`, deploy, then run the seed on production so the HRMX pricing, ownership and geofence sections go live. Verify: live `/demo/hrmx` contains "AMC", "geofenced", "Mumbai", "1,200".
2. **TRU-02 / third-party proof.** Get written permission from the 1,200-employee HRMX client for an anonymised case study ("a security services company with 1,200+ staff across N sites"). Nothing else on this list moves conversion as much.
3. **TRU-01 / stats.** Decide on `450+ / 150+ / 5+` in the About row — defend each number or cut it.

### P2 — next

4. **DEM-02 / DEM-03.** Add dedicated `meta_title` and `meta_description` columns to `portfolios` (or a per-row override), then write ≤60-char titles and 120–155-char descriptions for the 19 non-graphics demo pages. Use the two recommended options in `hrmx_seo_action_plan.md` §4–5 for HRMX.
5. **SCH-01 / breadcrumbs.** One shared `includes/schema-breadcrumb.php`, included on service pages, demo pages and blog posts. Cheap, sitewide, and the visual breadcrumbs already exist.
6. **DEM-04 / demo schema.** `SoftwareApplication` for the product demos, `BreadcrumbList` on all.
7. **ONP-06 / titles.** Cut `industry-systems` to ≤60 chars and standardise every title on the pipe separator. Trim the four 62–69-char service titles and the three 157–169-char descriptions.
8. **ONP-01 / homepage description.** Write a homepage-specific 150-char description in `index.php` instead of inheriting the 176-char config default.
9. **TEC-01 / sitemap `lastmod`.** Replace the hard-coded `2026-04-26` dates with `filemtime()` on the backing template, and fix the 2024 static-blog dates.
10. **PRF-04 / Lighthouse.** Re-run on `/`, `/portfolio`, `/services/erp-development/`, `/demo/hrmx`, top blog post. Record the numbers in this file.
11. **SCH-02 / FAQ schema.** Start with the 14 questions already drafted in `hrmx_seo_action_plan.md` §3 for `/demo/hrmx`.

### P3 — then

12. **CNT-01 / blog.** Either grow the two 350-word posts past 1,000 words with author attribution and real internal linking, or `noindex` them and start the content programme properly. Two thin posts is worse than none.
13. **DEM-05 / graphics pages.** `noindex` the 10 graphics entries and drop them from the sitemap, or group them onto one gallery page.
14. **DEM-06.** Add h2/h3 structure to the 9 unstructured demo write-ups.
15. **TRU-03 / TRU-04.** Enable `SITE_FOUNDER_NAME`; add the credentials strip (NDA · you own the IP · AMC & 24/7 support) — all facts you already have.
16. **A11Y-01 / A11Y-02.** Blog cards h3→h2; give `/404` a real visible h1.
17. **ONP-03.** Rename the contact H2 away from "Get a free project estimate."
18. **PRF-01 / PRF-02.** `srcset` on portfolio and blog images; re-encode `todays-menu.webp`.
19. **DEM-07.** Create the restricted demo account (synthetic data only, read-only role) and switch HRMX to open access.
20. **Optional.** `TWITTER_SITE`, `MICROSOFT_CLARITY_ID`, `GOOGLE_SITE_VERIFICATION` meta, trailing-slash internal rewrite.

---

## 9. Resolved and verified — do not re-raise

| Was | Verified |
|---|---|
| Copywriting build not deployed (DEP-01) | **Live 27 Oct 2026** — 0 old CTAs, 0 "24 hours", no Solutions section |
| 4 service pages without `<!DOCTYPE>`/JSON-LD (SEO-05) | **Live** — `ecommerce` serves doctype + 1 `ld+json` + keywords |
| `erp-development` canonical/title (SEO-06) | Trailing slash + pipe separator in repo and live |
| Static blog clean URLs 302 → `/blog/` | 200 on both |
| `.html` 301s pointing at `/dashandots/…` on production | Resolve to apex |
| `X-Powered-By: PHP/8.2.30` | Header absent |
| `.env` in git history | `git log --all -- .env` empty — never committed |
| Open admin migration scripts | 403 |
| CORS `*` | Restricted to the site origin; evil origin gets no ACAO |
| Demo passwords in public HTML | Removed |
| Duplicate `sitemap.xml` | 301 → `sitemap.php` |
| Broken JSON-LD logo paths | `/assets/logo.webp` and `/assets/logo.png` both 200 |
| No consent management | Consent Mode v2 + banner + privacy policy live |
| GTM container empty / GA4 id misplaced | GTM v2 published; `page_view`, `cta_click`, key events verified |
| Rate limiter surfacing 429 as "Something went wrong" | Limiters removed; honeypot kept; server messages surfaced |
| Heavy PNGs, unminified assets | WebP + `<picture>` + minified CSS/JS sitewide |
| Portfolio limited to 13 rows on home | `/portfolio` with 29+ entries, filters, `ItemList` |
| `@gmail.com` public contact address | `hello@dashandots.com` live |
| Single-page architecture | Multi-page: 6 service landings, `/portfolio`, 29 demo pages, blog |

---

## 10. Out of scope

- Penetration testing, admin brute-force assessment
- Full legal/GDPR review
- Demo subdomains (`erp.dashandots.com` et al.)
- Search Console / GA4 performance data (no credentials available to this audit)
- Lighthouse field data (lab runs only, and not re-run this pass)

---

*Single source of truth for dashandots.com audit status. Update this file in place after each deploy or re-audit — do not create a new dated report. Next update due after the DEM-01 deploy and a Lighthouse re-run.*
