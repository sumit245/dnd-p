# Content audit — why 11 keywords and "zero" traffic

**Date:** 15 November 2026
**Question asked:** a competitor shows 208 organic keywords, 657 organic traffic and 13 AI
mentions. Dashandots shows 11 keywords, 0 traffic, 0 AI visibility. Why, and what fixes it?

**Method:** live crawl of all 28 sitemap URLs on 15 Nov 2026 (word counts, headings, internal
links, robots), WHOIS, competitor sitemap retrieval, two brand/category web searches, and the
Google Search Console export already analysed in `GEO-ANALYSIS.md` (2026-08-10 to 2026-11-09).
No ranking tool was queried; Semrush figures are taken from the supplied screenshot.

---

## 1. Three things wrong with the comparison

Before any content work, the benchmark in the screenshot needs correcting. All three numbers
mean something different from what they appear to mean.

### 1.1 freiheitskytech.com is not a competitor

It is a **Shopify storefront selling ladders in the UAE**. Its robots.txt declares a Shopify
storefront with a UCP/MCP shopping endpoint, and its homepage title is "Buy All Types of
Ladders Online | سلم – Freiheit Skytech".

Its sitemap contains:

| Sitemap | URLs |
|---|---:|
| Products | 126 |
| Collections | 36 |
| Pages | 18 |
| **Total, English** | **180** |
| Arabic duplicates (`/ar/`) | ~180 again |

So roughly 360 indexable URLs, nearly all transactional product and category pages, in two
languages. A query like "aluminium step ladder dubai" has immediate commercial intent, a tiny
competitor set and a page that answers it exactly. That is how 180 product pages become 208
keywords.

Dashandots sells **bespoke B2B software on a multi-month sales cycle**. There is no catalogue to
turn into pages, the buyer researches for weeks before enquiring, and the head terms are
contested by agencies with 10–16 year old domains. The two businesses do not share a query space,
a page-count model or a conversion path. **Comparing the two numbers tells you nothing
actionable.** If you want a benchmark, use an Indian custom-software agency of similar age.

### 1.2 "0 organic traffic" is a Semrush estimate, and it is wrong

Semrush infers traffic from keywords in *its own* database where your pages rank, multiplied by
its volume estimates. Long-tail queries with volumes below its threshold contribute nothing, so a
young site serving niche queries reports zero.

Your own Search Console export says otherwise:

| Period | Impressions/day | Clicks |
|---|---:|---:|
| August 10–31 | 5.05 | 11 |
| September | 10.93 | 16 |
| October | 31.61 | 37 |
| November 3–9 | **76.86** | 6 |

2,069 impressions and 70 clicks over 92 days, with the last 28 days up **136%** on the previous
28. That is not zero, and the trend is the right shape. Treat GSC as the truth and Semrush as a
rough competitive lens.

### 1.3 "AI visibility 0" is mostly an off-site problem, not a content problem

A web search for **"dashandots technology gurugram"** returns no company page, no LinkedIn
listing, no Clutch profile, no directory entry — nothing about the business. The results are
other companies with similar names.

Language models cite entities they can corroborate from several independent sources. A site can
be well written and still be invisible to them if nothing outside the site confirms the company
exists. The ladder shop has 13 mentions partly because retail products get aggregated, reviewed
and listed by third parties automatically. Agencies have to earn that through directories,
profiles, and being quoted elsewhere.

**Verify as a priority:** the `sameAs` entries in your Organization schema point at
`linkedin.com/company/dashandots-technology` and `twitter.com/dashandots`. LinkedIn returned 403
to an automated check (inconclusive — it blocks bots) and X returns 200 for handles that do not
exist. Open both in a browser. A `sameAs` pointing at a profile that does not exist is a broken
entity signal and worth more than it costs to fix.

---

## 2. What the content actually is

All 28 indexable pages, 23,926 words total, average 854 per page.

| Group | Pages | Words | Share of corpus |
|---|---:|---:|---:|
| Demo pages | 13 | 9,749 | 40.7% |
| Service pages | 7 | 5,644 | 23.6% |
| Blog posts | 3 | 2,397 | 10.0% |
| Legal | 2 | 1,150 | 4.8% |
| Homepage | 1 | 3,873 | 16.2% |
| Listings (`/blog/`, `/portfolio`) | 2 | 1,113 | 4.7% |

Six pages reach 1,000 words. **Seventeen of 28 sit under 700.**

### 2.1 The structural problem: 41% of the corpus targets names nobody searches

Seven of the 13 demo pages are named after a **client's product brand**: HRMX, Truckie, LloydWFM,
Lloyd BA, Ghumantoo, TrustMeRecycle, NewGen ERP. That is **4,857 words — a fifth of everything
you have written — aimed at strings with no independent search demand.**

These pages are genuinely good sales assets. A prospect sent to `/demo/truckie` sees working
software, and that matters. But as *search* assets they can only rank for the brand name, and
nobody outside the client's own staff types it.

The GSC export shows exactly what this produces. `/demo/hrmx` is your single largest page by
impressions — 610 in 92 days — against the query `hrmx`, which delivered 514 impressions and
**5 clicks at 0.97% CTR**. Your own HRMX action plan already flags the problem: hrmx.in, hrmx.ai
and hrmx.tech are other companies. **A quarter of all site impressions are people looking for
somebody else.** That is why impressions rose 136% while CTR fell.

### 2.2 The pages that do work, work because they match a real query

| Page | Impressions | Clicks | CTR |
|---|---:|---:|---:|
| `/demo/hms` | 358 | 24 | 6.70% |
| `/` | 379 | 34 | 8.97% |
| `/demo/hrmx` | 610 | 5 | 0.82% |

`hospital management system demo` — a real, described, category-level need — converts at 6.7%.
The product name converts at 0.8%. The homepage and HMS together produce **58 of your 70 clicks
(83%)**.

The lesson is already in your own data: **category language earns clicks, product names earn
impressions you cannot use.**

### 2.3 The blog is too small to be a traffic channel

Three posts, 2,397 words combined. Two are around 530–570 words, which is too thin to answer a
research query properly. The best post (agentic AI, 1,298 words) already earns 94 impressions —
proof the format works, not proof the library is big enough.

An 11½-month-old domain (created 2025-11-30) with three articles has no informational surface
area. This is the single biggest content gap, and it is also the gap that drives AI citation,
because models quote explanatory passages, not service pages.

---

## 3. Why only 11 keywords

Putting it together, the cause is arithmetic rather than anything broken:

1. **Too few pages that target a described need.** Of 28 URLs, roughly 8 aim at language a
   stranger would type. The rest are product names, legal pages and listings.
2. **The 8 that do aim correctly aim at the hardest terms available.** "Custom ERP development
   company India" is contested by Clutch listings, 16-year-old agencies and content farms. A
   first-year domain does not win those, and the GSC export shows those service queries sitting
   at positions 50–90.
3. **Nothing targets the questions asked before the buying query.** No cost guides, no comparison
   pages, no integration explainers. Those are the low-competition entry points, and they are
   missing entirely.
4. **No off-site corroboration.** No directory presence, no third-party mentions. This caps both
   rankings and AI citation independently of page quality.

Nothing here is a technical fault. The technical layer was audited and fixed this week:
structured data, titles, readability, anchor text and text-to-HTML ratio are all clean now. The
constraint is **surface area and authority**, not crawlability.

---

## 4. What to do, in order

### P0 — stop the bleeding, this week

1. **Verify the two `sameAs` URLs in a browser.** If either profile does not exist, create it or
   remove the claim. A LinkedIn company page is also the cheapest entity signal available.
2. **Decide what `/demo/hrmx` is for.** It attracts 514 impressions of other companies' brand
   traffic. Either retitle it around what it does ("HR, payroll and attendance system for 20–1000
   staff" — already its title) and accept the junk impressions, or de-emphasise the product name
   entirely. Do not optimise further for the string `hrmx`.
3. **Claim the obvious directory profiles:** Google Business Profile, Clutch, LinkedIn. This is
   the fastest route off AI-visibility zero, and it is not a content task.

### P1 — build the informational layer, next 4–8 weeks

Write genuinely useful guides on the questions buyers ask *before* they search for a vendor.
Every topic below is grounded in evidence you already have — a GSC query, an existing page that
underperforms, or a question in your own FAQ blocks:

| Topic | Why this one | Evidence |
|---|---|---|
| What a custom ERP costs in India, and what drives the number | Highest-intent research question in the category; you already answer it partially on the ERP page | ERP service page has 77 impressions, 0 clicks — the page exists but answers the wrong stage |
| Custom ERP vs packaged ERP: how to decide | Classic comparison format, cited heavily by LLMs | Already a post title in your local DB; finish and expand it |
| Integrating a custom system with TallyPrime | Specific, low-competition, you do this work | Named in the manufacturing ERP FAQ |
| GST e-invoicing for manufacturers: what the system must do | Regulatory topics age well and attract links | Named in your service copy |
| Hospital management system: how to evaluate a demo | Your best-converting query already | `hospital management system demo`, 6.7% CTR |
| ERP for door and window manufacturers | A real query already reaching you | `door manufacturing erp`, 4 impressions, position 6 |

Target **1,200–2,000 words each, two a month**. Fewer, better, specific. Each one should answer
the question completely enough that a model could quote a paragraph of it without needing another
source.

### P2 — make the demo pages earn category traffic

Keep the demos; they are good proof. But give each one a category-language section that a
stranger might search: "what a transport management system does", "what a workforce app replaces".
That converts 4,857 words of brand-name content into pages with a second, searchable entrance —
without touching the sales value they already have.

### P3 — the things that will not move the needle yet

Stated so you do not spend money on them: more schema, another llms.txt revision, chasing the
text-to-HTML ratio further, or buying links. Google's own guidance is explicit that AI features
run on ordinary indexing and snippets, not special files. The technical work is done; the content
library is what is missing.

---

## 5. Honest expectation setting

The site is 11½ months old with 24,000 words. Impressions have grown 6× since August and the last
28 days are up 136%. That is a site in the early part of the curve, not a broken one.

Twelve good guides will roughly double the corpus and, more importantly, add the entry points
that a young domain can actually win. Expect the first movement in 8–12 weeks after publishing,
not days. AI citation will follow third-party corroboration more than it follows on-site changes.

What the data does **not** support: that you have a traffic problem caused by the website's
technical quality, or that catching a UAE ladder retailer's keyword count is a meaningful goal.

---

## 6. Addendum: Semrush Keyword Strategy Builder (read same day)

Audit 118489, India database. 25 pages to improve, 34 topics to create, 59 opportunities.
This replaces guesswork in section 4 with the tool's own difficulty scores.

### 6.1 Do not action the "To Create" list as given

Of the 34 suggested topics, a large share are **the clients' businesses, not yours**. The tool
derived them from the demo pages:

| Suggested topic | Volume | Where it came from |
|---|---:|---|
| whatsapp facebook | 145.7K | `/demo/waba` |
| whatsapp file | 42.1K | `/demo/waba` |
| whatsapp bhi | 27.1K | `/demo/waba` |
| mumbai bus app | 10.8K | `/demo/ghumantoo-app` |
| real time bus tracker | 16.2K | `/demo/ghumantoo-app` |
| e waste recycling business | 1.7K | `/demo/trustmerecycle` |
| ecommerce platform india | 41.5K | `/services/ecommerce/` |
| best crm for small business | 162.2K | `/demo/crm` |

Writing for "whatsapp file" or "mumbai bus app" would pull in consumer traffic with no chance
of becoming an enquiry, and would dilute the site's topic. **This is the section 2.1 problem
feeding back through the tool**: because 41% of the corpus is client product pages, the
keyword tool thinks you are in the clients' businesses.

Equally, "best crm for small business" at 162.2K is a review-site query. You would be competing
with listicles, not agencies.

### 6.2 The clusters that are genuinely winnable

Difficulty scores from the same report. For an 11-month-old domain, KD under about 25 is
realistic; 30–40 is a stretch; above that is for later.

**Hospital software — the strongest opportunity on the site.**

| Keyword | KD | Volume |
|---|---:|---:|
| hospital management system | 17 | 5,400 |
| hospital management software | 19 | 1,600 |
| hospital information management system | 19 | 880 |
| hospital management system software | 19 | 720 |
| hospital billing software | 15 | 480 |
| hospital information system software | **10** | 390 |
| hospital management software india | **10** | 170 |
| best hospital management software | 13 | 170 |
| smart hospital management system | **9** | 140 |
| hms hospital management system | **8** | 110 |

KD 8–19 on 5,400/month in a market this size is unusual, and it is the one area where the site
already performs: `/demo/hms` sits at position 5.85 with 6.70% CTR. The demo answers "show me
one"; nothing answered "who builds one, what does it include, what does it cost".

**ERP and CRM development — moderate, already your positioning.**

| Keyword | KD | Volume |
|---|---:|---:|
| custom erp development | 22 | 720 |
| erp software development company in india | 21 | 210 |
| custom crm development company | **15** | 170 |
| crm software development services | **17** | 140 |
| custom erp software development | 25 | 140 |
| erp development company | 28 | 260 |

**Manufacturing ERP — a real niche, already has a page.**

| Keyword | KD | Volume |
|---|---:|---:|
| manufacturing erp software india | 20 | 1,000 |
| erp for manufacturing industry in india | **15** | 210 |
| erp for manufacturing india | 20 | 210 |
| manufacturing erp software | 27 | 1,300 |

**Avoid for now:** "erp software" (33.1K, KD 36), "manufacturing software" (KD 36), "erp
development" (KD 40), "hospital software" (KD 41). These are the head terms the site currently
aims at, and they are the reason the service pages sit at positions 50–90.

### 6.3 A real defect the tool exposed

The report lists `dashandots.com/demo/view.php?slug=erp` as a page in its own right: **ranking
for 0 keywords at position 100+**, with 42.3K of potential volume attached to it. That is the
query-string form of `/demo/erp` — the same content on two URLs, splitting signals.

Cause: four internal links pointed at the query-string form, from the homepage and the
industry-systems page. Fixed in this batch. The URL now 301s to the clean one.

### 6.4 What was implemented from this report

1. `.htaccess`: `/demo/view.php?slug=X` now 301s to `/demo/X`. Uses `THE_REQUEST` so the
   internal rewrite that serves every demo page is not caught by it.
2. Four internal links on `index.php` and `services/industry-systems/index.php` repointed to
   clean demo URLs.
3. **New page: `/services/hospital-management-system/`** (1,519 words). Targets the KD 8–19
   hospital cluster, which previously had no page: HMS was one 12-line section inside
   industry-systems, shared with hotel and transport software. Covers what an HMS is, when
   custom beats packaged, modules, how to compare vendors, rollout shape, and six FAQs
   including cost and data safety. Linked from industry-systems, listed in the sitemap, with
   Service, BreadcrumbList, FAQPage and WebPage schema.

### 6.5 What is still worth doing, in order

1. **Publish the ERP cost guide and the custom-vs-packaged comparison.** Both are in section 4,
   both now have difficulty evidence behind them.
2. **Give `/services/erp-development/` the "custom ERP development" (KD 22) and CRM development
   (KD 15–17) language it is missing.** The page exists and has 77 impressions with no clicks.
3. **Add "manufacturing ERP software India" phrasing to the manufacturing page.** KD 20 at
   1,000/month, and the page is already written.
4. **Leave the client-brand demo pages alone as sales assets**, but stop treating their keyword
   suggestions as a content plan.
