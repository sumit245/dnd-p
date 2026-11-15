# Backlink audit — dashandots.com

Source: Semrush Backlink Audit, campaign 31986873, crawl of 15 November 2026.
Baseline traffic figures come from the GSC export recorded in `GEO-ANALYSIS.md`
(92 days: 2,069 impressions, 70 clicks, 3.38% CTR).

---

## 1. The headline finding

**The backlink profile is a paid-PBN footprint, not an earned one.**

| Metric | Value |
|---|---|
| Referring domains | 1,576 |
| Analyzed backlinks | 1,666 |
| Toxic | **1,567 (96.7%)** |
| Potentially toxic | 12 (0.8%) |
| Non-toxic | **40 (2.5%)** |
| Authority Score | **2** |
| Domains with AS 0–20 | 99.4% |
| Follow links | 99.5% |
| Pointing at the homepage | 99.9% |
| New domains, last period | 1,075 (620 in the latest spike, 619 of them toxic) |

The anchor text is what settles it. These are the three largest anchors on the
profile, verbatim:

| Anchor text | Domains |
|---|---|
| "Effective PBN Backlinks for dashandots.com to Improve Citation Flow. Build Lasting Authority, Across Every Niche and Market." | **794** |
| "Get Higher Rankings with Expert SEO Backlinks dashandots.com" | **616** |
| "High Quality Dofollow Backlinks DA 50 PA 40 Premium PBN Network Service dashandots.com Rank First Page Google Fast SEO Link Building Buy Backlinks Online Cheap" | **90** |

That is 1,500 of 1,576 referring domains. The anchors are not describing
Dashandots — they are the **vendor's own sales copy**, reproduced on every page
of a private blog network. Semrush independently flags 1.5K mirror pages and 763
subdomains sharing a root domain, which is the same network seen from another
angle.

Only about 25 referring domains carry anchors a human would write
("Dashandots Technology", "custom software", "ERP systems",
"Best software development company in india", "business automation Software
Development in Delhi"). Those are the real profile. Everything else is noise.

### Two possible origins, and they need different responses

1. **Someone bought a link package** (directly, or bundled into an "SEO
   retainer"). If so, the first action is to stop the renewal — disavowing while
   a vendor keeps delivering is endless.
2. **An unsolicited blast**, either negative SEO or a vendor spraying links at
   domains to generate "proof" screenshots. 620 new toxic domains appearing in a
   single week fits this too.

I cannot tell which from the data. You can: check whether anything was paid for
SEO or link building in the last 12 months.

---

## 2. What this does and does not explain

**It does explain** why clean technical SEO has not produced rankings. Authority
Score 2 with 1,576 referring domains is not a neutral position — it is the
profile of a site Google has learned to discount. Service pages sitting at
positions 50–90 is consistent with a site carrying no credible authority signal
at all.

**It does not mean you have a penalty.** Since the 2022 link-spam update,
Google's stated behaviour is to *neutralise* spam links rather than penalise the
target, precisely because anyone can point links at anyone. Check Search Console
→ Security & Manual Actions. If it is clean, there is no active penalty.

**Disavowing is therefore hygiene, not a traffic lever.** Google's own guidance
is that most sites should not use the disavow tool. The honest case for using it
here is narrow but real:

- the volume and anchors are unambiguous, so the risk of disavowing something
  valuable is near zero (scope it to the toxic set; keep the ~40 clean domains);
- if a manual action ever does land, having disavowed already is the difference
  between a two-week reconsideration and a two-month one.

Expect **no traffic increase from the disavow itself.** Anyone who tells you
otherwise is selling something.

---

## 3. The 500 visitors/day target, with the arithmetic

Current organic: **70 clicks in 92 days = 0.76 clicks/day.**
Target: **500/day = ~15,000/month.** That is roughly a **650× increase.**

Work it the other way, from the keyword data in the Strategy Builder:

> Your single best available keyword is "hospital management system" —
> **5,400 searches/month, KD 17.** Suppose you win it outright and hold
> **position 3**. Position 3 takes roughly 10% of clicks.
> **5,400 × 10% = 540 clicks/month = 18 visitors/day.**

**Your best realistic keyword win is worth 18 visitors a day.** 500/day needs
roughly **thirty** wins of that size, or a hundred smaller ones. That is a
corpus of 100–150 genuinely useful pages, of which perhaps half rank, built over
12–24 months. There is no version of this that happens in a quarter, and no
quantity of backlinks substitutes for it.

What the next 12 months can realistically look like:

| Horizon | Organic/day | What it takes |
|---|---|---|
| Now | ~1 | — |
| 3 months | 5–15 | HMS page ranks; 6–8 guides published; GBP + Clutch + LinkedIn live |
| 6 months | 25–50 | 20–25 pages; the KD ≤20 cluster largely held |
| 12 months | 80–150 | 50+ pages; a handful of mid-volume terms in the top 5 |
| 24 months | 300–500 | 100+ pages, real citations, brand demand |

If 500/day is needed sooner than that, it has to come from paid search,
LinkedIn, or outbound — not from SEO. Those are different budgets with
different economics, and worth saying out loud rather than discovering in month
nine.

---

## 4. What to do, in order

### P0 — Stop the bleeding (this week)

1. **Check Search Console → Manual Actions.** Two minutes. Everything below
   assumes it is clean.
2. **Establish whether the links were bought.** Cancel anything recurring.
3. **Disavow the toxic set at domain level.** In Semrush: Audit → select toxic →
   Disavow → export → upload to Google's disavow tool. Keep the ~40 non-toxic
   domains out of the file. This is reversible inside Semrush up to the point of
   upload; the upload itself is yours to make.
4. **Schedule a monthly rerun** of the backlink audit so a second blast is seen
   in weeks rather than months.

### P1 — Build the authority that is actually missing (weeks 1–4)

The site has ~25 real referring domains. That is the number to grow, and none of
it is technical work:

- **Google Business Profile**, Clutch, LinkedIn company page. Still unclaimed; a
  web search for "dashandots technology gurugram" returns nothing about the
  company, which is also why AI visibility is zero.
- **Client credit links.** You built live, running products — HRMX, Truckie,
  Ghumantoo, LloydWFM, TrustMeRecycle. A "Built by Dashandots" credit in the
  footer of each is a relevant, editorially genuine link from a real business.
  Five of those outweigh all 1,567 PBN links combined. Ask.
- **India-specific directories** that actually get used: Clutch, GoodFirms,
  DesignRush, IndiaMART for the ERP category.

### P2 — The content corpus (ongoing, this is the real work)

Per the content audit, in difficulty order. The two already specified and
unwritten:

- ERP cost guide ("erp software cost in india" and neighbours)
- Custom vs packaged ERP comparison

Then the KD ≤20 cluster around hospital, manufacturing and CRM systems. Hold the
ceiling at **KD ~25** until authority exists; "erp software" (KD 36) and
"hospital software" (KD 41) are unreachable from AS 2 and are exactly why the
service pages sit at position 50–90 today.

---

## 5. What not to do

- **Do not buy more links**, including from anyone who cites this audit as proof
  you need them.
- **Do not chase the Strategy Builder's "To Create" list as given.** Most of its
  high-volume topics ("whatsapp facebook" 145.7K, "whatsapp file" 42.1K,
  "mumbai bus app" 10.8K) are derived from the client demo pages and target the
  *clients'* audiences, not software buyers.
- **Do not expect the disavow to move traffic.** It protects; it does not grow.
