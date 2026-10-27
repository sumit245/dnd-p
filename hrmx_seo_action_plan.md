# HRMX Page — SEO Action Plan

**Target page:** `https://dashandots.com/demo/hrmx`
**Source copy:** `scripts/seed-portfolio-products.php` (slug `hrmx`, `detailed_description`)
**Built from:** the Gemini SERP audit (`search_console_audit_hrmx.md`) + interview answers, 27 Oct 2026
**Rule applied:** every gap below is filled with Dashandots' own facts from the interview. No competitor copying. No invented numbers, clients, or certifications. Facts we do not have are marked **[NEED]** at the end.

---

## 0. Strategic reality check (read first)

"hrmx" is a contested brand term. Three other properties own the name — `hrmx.in`, `hrmx.ai`, `hrmx.tech`. Anyone typing "hrmx" to log in or to reach a vendor they already heard of will not choose us, and no amount of on-page work changes that.

So the page should not be optimised to win navigational "hrmx". It should be optimised for the slice of that traffic that arrives **undecided** — plus the evaluative long tail that the same page can rank for:

- hrmx pricing / hrmx cost
- HRMS for 20 to 50 employees India
- custom HR and payroll software India
- geofence attendance software for security agency / field staff
- HRMS with per-branch leave policy
- migrate HR data from Tally / MARG / Odoo to HRMS

Every section below is written to serve that buyer: someone comparing a custom build against a SaaS subscription, who needs cost logic, proof, and a timeline before they will fill a form.

**One structural recommendation:** this is currently a demo/portfolio page carrying the weight of a product page. Keep the demo as the hook, but let the page answer the full buying question — otherwise the trust and pricing sections have nowhere to live.

---

## 1. New sections to add

### H2 — What HRMX costs, and what actually drives the number

*Fills the audit's worst gap (Pricing: "Poor / Missing") without publishing figures, which you asked to keep off the page.*

Opening frame: HRMX is not a SaaS subscription. It is a **one-time build fee plus a yearly AMC**, and you own the IP at the end of it. There is no per-employee licence, so the price does not move every time you hire.

Then the honest part — what makes one HRMX project cost more than another, in the order that actually matters:

#### H3 — The seven things that move an HRMX quote

List them in the ranked order from the interview, most to least:

1. **Data migration from your existing system** — the single biggest driver, every time. More on this below.
2. **Where you want it hosted** — your own on-premise server versus cloud. Each has a different setup and handover effort.
3. **Biometric and device integration** — how many devices, which makes, whether they already talk to anything.
4. **Custom modules** — anything outside the standard module list.
5. **Payroll component complexity** — the number and nature of earnings, deductions, and rules you run.
6. **Number of branches and locations** — each one that needs its own calendar, shift pattern, or policy set.
7. **Headcount** — last on the list, and deliberately so. This is the opposite of how SaaS prices.

Closing line worth stating plainly: *headcount is the cheapest variable in a custom build and the most expensive variable in a subscription. That difference is the entire financial argument for owning your HRMS.*

#### H3 — Why migration costs more than the software

Write this from the interview, verbatim in substance: companies arrive from Tally, from MARG, from Odoo, and often from a legacy system nobody can name — sometimes one the original vendor no longer supports. Each one stores employees, salary structures, and leave balances differently, and almost none of them export cleanly.

Add the counter-intuitive, genuinely useful point: **if you are on pure Excel today, you are in a better position than someone on a legacy HRMS.** A spreadsheet is easier to map and migrate than a closed system with no usable export. Companies assume the opposite and budget the wrong way round.

State the division of labour honestly: Dashandots guides the migration — mapping, templates, validation — and your team performs it. That is deliberate; your people end up knowing the data in their own system.

#### H3 — What the AMC covers, and what it does not

- **Covered:** bug fixes and security updates.
- **Not covered:** cosmetic changes and new features. Those are quoted separately.
- **Support:** 24/7, on any channel you prefer.

Say the exclusion out loud. Vendors who hide it get a reputation; vendors who print it get trusted.

---

### H2 — Attendance problems most HR software cannot solve

*Fills the audit's "Examples & Use Cases: Moderate" gap with a real deployment instead of an industry list.*

#### H3 — Roving security guards: punch with a photo, inside 90 metres

The strongest story from the interview and the one no competitor page has. Write it as the problem first:

A security agency's guards do not sit at a desk. They move between posts through a shift, and the question "was the guard actually at that site?" cannot be answered by a biometric machine bolted to one wall.

What was built for it: **photo-based mobile punch, geofenced to a 90-metre radius of the assigned location**, with rotating shift patterns that follow a guard from one site to the next. The attendance record carries the place and the picture, not just the timestamp.

Generalise outward to the buyers who have the same shape of problem: field sales and service teams, multi-site facility and housekeeping staff, delivery and logistics crews, engineers on client premises.

#### H3 — Different leave policy per branch — and per department inside one branch

Most HRMS products let you configure a policy per company, some per location. The real requirement, from live deployments, goes one level finer: **two departments in the same branch can run different policies** — different leave rules, different approval chains, different working patterns — while payroll stays a single run.

Worth naming the span of workforce types this covers, as stated in the interview: from **daily-wage and unstructured labour through to salaried corporate staff**, inside one system. That is an unusual claim and it is yours to make.

#### H3 — What one HRMX deployment looks like at scale

Use the real numbers from the interview: HRMX runs today at **six companies**. The largest is on **1,200+ employees**, and the longest-running deployment has been live for **3+ years**.

This currently appears nowhere on the page. It is the single most under-used asset you have.

---

### H2 — How an HRMX rollout actually runs: NDA to first live payroll

*Fills the audit's "Process Steps: Moderate" gap. Numbered, with real durations.*

Present as a numbered list, roughly a week per stage, **8 to 10 weeks total**:

1. **NDA** — signed before anything starts, before discovery.
2. **Discovery and policy mapping** — your leave, shift, attendance, and payroll rules written down properly. Often the first time they have been.
3. **Data migration** — guided by us, performed by your team: employee master, salary structures, past leave balances.
4. **Configuration** — leave types and accruals, shifts, salary structures, approval chains, per-branch and per-department variations.
5. **UAT with HR** — your HR team tests against their own real cases, not a sample dataset.
6. **Parallel payroll run** — old and new systems run side by side for **2 to 3 pay cycles**. Nobody cuts over on faith.
7. **Go-live.**
8. **Training** — **4 on-premise sessions plus 6 online sessions, all recorded** so later joiners can catch up without booking your time.
9. **Continuous support** — 24/7, any channel, under the AMC.

#### H3 — What we need from you, and where projects actually slip

What you provide: policies, employee master, salary structures, past leave balances.

Where rollouts slow down, stated from experience: not the software, and not the data — **coordination between HR and management on payout decisions.** The build waits while someone decides what a component should actually be. Naming this in advance is the most useful thing on the whole page for a serious buyer, and it costs nothing to say.

---

### H2 — Where your data sits and who can touch it

*Fills the audit's "Trust Elements: Weak" gap with only what is true. No badges.*

State the facts, flatly:

- **Hosting:** by default, secured **AWS servers in the Mumbai region**. Where it lives is your call — on-premise, your own cloud account, or ours. Because HRMX is a custom build rather than a SaaS tenancy, hosting is a decision you make, not one you inherit.
- **Backups:** taken daily.
- **Access:** nobody at Dashandots accesses client data except the support team, and only to support you.
- **NDA:** signed before engagement begins.
- **IP:** the client owns it. The system is yours, including when you part ways with us.
- **Track record:** Dashandots has been operating for **6 years**. HRMX is live at 6 companies, the largest at 1,200+ employees, the longest for 3+ years.

Do **not** add ISO 27001, SOC 2, GDPR, or CERT-In claims — you hold none, and a false badge is a legal problem, not a ranking problem. The honest version of this section still beats a blank one, which is what the page has now.

---

### H2 — When you should not buy HRMX

*Nothing like this exists on any competitor page on this SERP. It is the highest-trust section on the page and the cheapest to write.*

Say it directly: **below about 20 employees, do not commission a custom HRMS. Subscribe to a SaaS product instead.** A build does not pay back at that size, and we will tell you so on the call rather than after the invoice.

Then the inverse — the signals that mean a build is the right call:

- A SaaS tool's policy model cannot express how you actually operate (per-department rules, mixed workforce types, geofenced roving staff).
- Per-employee pricing has become your fastest-growing software cost.
- You need the data on infrastructure you control.
- You want to own the system rather than rent it.

#### H3 — What companies at 20–50 employees get wrong when buying HR software

Straight from the interview, written as diagnosis rather than sales:

1. **Tangled policies.** They try to automate leave and attendance rules that contradict each other and were never written down. Software cannot resolve a policy conflict; it only makes it visible faster.
2. **No clear org chart.** Without reporting lines settled, approval workflows cannot be configured — and approvals are most of what an HRMS does day to day.
3. **Training that misleads them.** Most buyers are shown features in a demo-friendly order, not in the order that will matter to them in month three. They end up unable to judge which capabilities they actually need, and pick on impressions.

Practical close: sort the policies and the org chart first. That work belongs to you, it is free, and it shortens any implementation — ours or anyone's.

---

## 2. Existing sections — improve or cut

| Current section | Verdict | What to do |
|---|---|---|
| "HR software that your HR person will actually enjoy opening" | **Keep — strongest copy on the page.** | The employee-20-to-50 spreadsheet hook is better than anything on the competing sites. Leave it. Only change: it is the first thing a visitor reads, so follow it immediately with the open demo credentials rather than making them scroll. |
| "The dashboard at a glance" | **Shorten by about half.** | It narrates a screenshot. The visitor can see the dashboard in the live demo — that is the point of an open demo. Keep the "morning briefing an HR head normally assembles by hand" line, cut the inventory of counters. |
| "Modules in HRMX" (11 bullets) | **Keep, restructure.** | The audit rates this "Good" and it is. But it is a wall of eleven bullets. Group under three H3s — **Core HR and organisation**, **Time, leave and payroll**, **Talent: recruitment, training, performance** — and let self-service stand on its own. Same content, scannable. |
| "Who HRMX is for" | **Improve.** | Industry list is generic and interchangeable with every competitor. Lead instead with the workforce-type span (daily-wage and unstructured labour through to corporate salaried staff), the per-department policy capability, and the multi-branch reality. Keep the 20–1,000 range, now backed by the real 1,200+ deployment. |
| "Built for Indian compliance, customised for your policies" | **Keep, split.** | PF/ESI/PT/TDS plus "no per-employee subscription, no forced upgrade" is good positioning — the audit rates it "Good". Split off the commercial half into the new pricing section where buyers look for it, and leave compliance here. |
| "See your HR process in it" (closing CTA) | **Rewrite.** | "Scope Your Project" is the only route off this page, which the audit flags. Give two exits: **try the demo now** (credentials on the page, open access) and **book a call**. Make the call CTA concrete about what happens on it — we map your policies and tell you whether a build is even right for your size. |
| Demo credentials | **Promote.** | Access is open and credentials are on the page, but buried. For a page targeting a navigational brand term, a visible "log in and click around, nothing to request" block near the top is the highest-value change on this list. |
| Nothing | **Cut nothing outright.** | The page has no filler to delete. Its problem is omission, not bloat. |

---

## 3. FAQ section to add

Mark up with FAQPage schema — competitors on this SERP have it and the page currently does not.

**H2 — HRMX: common questions**

1. **Is HRMX a subscription?**
   No. One-time build fee plus a yearly AMC. No per-employee licence, so adding staff does not raise what you pay for the software.

2. **What does the AMC cover?**
   Bug fixes and security updates, with 24/7 support on any channel. Cosmetic changes and new features are quoted separately.

3. **Where is our data hosted?**
   By default, secured AWS servers in the Mumbai region, with daily backups. You can also host on your own servers or in your own cloud account — because HRMX is a custom build, that is your decision.

4. **Who at Dashandots can see our data?**
   Only the support team, and only to support you. An NDA is signed before the engagement starts.

5. **Do we own the system?**
   Yes. The client owns the IP.

6. **How long does implementation take?**
   8 to 10 weeks from NDA to go-live, roughly a week per stage, including 2 to 3 parallel payroll cycles before cutover.

7. **Can we migrate from Tally, MARG, or Odoo?**
   Yes, and from unnamed legacy systems too. Migration is the largest single cost driver in most HRMX projects because every system stores employees, salary structures, and leave balances differently. We guide the migration and your team performs it.

8. **We run everything on Excel today. Is that harder to migrate?**
   Easier, not harder. A spreadsheet maps more cleanly than a closed legacy system with no usable export. Most companies assume the reverse.

9. **Can different branches have different leave policies?**
   Yes — and different departments within the same branch can too, while payroll still runs as one process.

10. **Can we track staff who move between sites during a shift?**
    Yes. Photo-based mobile punch, geofenced to a 90-metre radius of the assigned location, with rotating shifts. Built for a security agency whose guards move between posts; it applies to any field, multi-site, or roving team.

11. **Is there a minimum company size?**
    Below roughly 20 employees we will tell you to subscribe to a SaaS HRMS instead. A custom build does not pay back at that size.

12. **Can we see it before talking to anyone?**
    Yes. The demo is open access and the credentials are on this page. No form, no request.

13. **What do you need from us to start?**
    Your policies, employee master, salary structures, and past leave balances. In practice the biggest delay is not data — it is HR and management agreeing on payout decisions.

14. **How are our people trained?**
    4 on-premise sessions and 6 online sessions, all recorded so later joiners can catch up without scheduling anything.

---

## 4. Title tags (all under 60 characters)

1. `HRMX — HR, Attendance & Payroll Software for Indian SMEs` *(56)*
   Closest to current intent; adds the qualifier the current title lacks.

2. `HRMX HRMS: Payroll, Attendance & Leave for 20–1000 Staff` *(56)*
   Leads with the headcount band — the strongest qualifier in your existing copy.

3. `HRMX: Custom HR & Payroll System You Own — Live Demo` *(52)*
   Leads with ownership and the open demo, the two things no competitor on this SERP offers.

**Recommendation:** #2. It states the segment in the title, which filters out brand traffic that was never going to convert and matches the evaluative queries this page can realistically win.

## 5. Meta descriptions (both under 155 characters)

1. `Custom HRMS for Indian companies with 20+ staff: payroll with PF, ESI, PT and TDS, geofenced attendance and leave. Open demo, no per-employee fee.` *(145)*

2. `HRMX runs HR, attendance and payroll for 20 to 1,200+ employees. One-time build, you own the IP, AWS Mumbai hosting. Live in 8–10 weeks. Try the demo.` *(151)*

**Recommendation:** #2. Every claim in it is a fact from the interview, and "you own the IP" plus "no subscription" is the only differentiation that survives contact with three competitors who share your brand name.

---

## 6. Priority order for implementation

| Priority | Change | Status | Why first |
|---|---|---|---|
| P0 | Demo credentials visible near the top | **Code done, waiting on a demo account** — see §8 | Open access is the one thing no competitor on this SERP offers. |
| P0 | Pricing-drivers section | **Written** — `seed-portfolio-products.php` | The audit's worst gap; nothing on the page addressed the first question a buyer has. |
| P0 | Trust / data-and-ownership section | **Written** — `seed-portfolio-products.php` | 1,200+ employees, 3+ years, 6 years in business, client owns IP — all true, all absent before. |
| P1 | FAQ block with FAQPage schema | **Done** — 16 questions in `includes/demo-faqs.php`, rendered + schema in `demo/_template.php` | Competitors have it; fills the audit's "Missing" row and earns SERP real estate. |
| P1 | Geofence and per-department workflow sections | **Done** — “Attendance problems most HR software cannot solve” | Only genuinely unique capability on the page. |
| P1 | Numbered rollout timeline | **Done** — “How a rollout actually runs: NDA to first live payroll” | Turns an abstract engagement into an 8–10 week plan. |
| P2 | "When you should not buy HRMX" | **Done** — with the three buyer-mistakes sub-section | Highest trust per word; no competitor will copy it. |
| P2 | Title and meta update | **Done** — via `includes/demo-seo.php`; title 56 chars, description 137 | Do after the body supports the new framing, not before. |
| P2 | Module list regrouped under three H3s | **Done** — four groups; self-service split out as prose | Readability, not ranking. |

---

## 7. [NEED] — facts to go and get

These would strengthen the page and cannot be written without you:

1. **A support response-time commitment.** You said 24/7, any channel — the answer was cut off before a response time. "24/7" without a number is a weaker claim than "first response within X hours". State whatever is genuinely true.
2. **One named client, or one anonymised case study.** No testimonials exist today and the audit flags it. The 1,200+ employee client running 3+ years is a case study waiting to be written — even as "a security services company with 1,200+ staff across N sites", with no name, it is far stronger than nothing. Needs their permission.
3. **A decision on certifications.** You hold none. If enterprise deals keep stalling on security review, ISO 27001 becomes a sales cost, not a compliance cost. Worth a separate decision, unrelated to this page.
4. **Site count for the largest deployment.** "1,200+ employees" is good; "1,200+ employees across N locations" is better, and it validates the multi-branch claim with evidence.
5. **Number of devices/biometric makes supported.** Device integration ranks third in your cost drivers but the page says only "biometric or mobile punch integration". Naming the makes you have integrated converts better and ranks for brand-plus-integration queries.

---

## 8. Open demo access — the one P0 still pending

The code is in place and linted; only the account is missing.

**Already done:**

- `demo/_template.php` — renders a password row with a copy button, and switches the note to *"Open access — nothing to request… This demo runs on sample data only"* when both a username and a password exist on the portfolio row. Falls back to the existing request-by-email wording otherwise. Mobile-app entries are excluded.
- `scripts/seed-portfolio-products.php` — the insert was hard-coding `username, password` to `NULL` for every row and never refreshing them on re-run, so credentials could not land even if supplied. Now bound from optional `username` / `password` keys and included in `ON DUPLICATE KEY UPDATE`.

**Still needed — a dedicated demo account, not a personal login:**

1. An obviously-demo username (`demo`, `hrmx-demo`, `demo@hrmx.dashandots.com`).
2. A fresh random password used nowhere else. It will live in git history and on a public indexed page permanently, so treat it as burned from the moment it is committed.
3. The most restricted role HRMX offers — ideally read-everything, change-nothing. A public account that can run payroll or delete employees will be wrecked within a week.
4. A tenant holding **synthetic employees only**. A public admin login exposes every record in the instance: names, PAN, Aadhaar, PF and UAN numbers, bank details, salary figures. If any real client data has ever touched that instance, clean it before opening access.

Once those exist, it is a two-line change to the `hrmx` entry.

---

## 9. P1 implementation notes

**FAQ** &mdash; the questions live in `includes/demo-faqs.php`, keyed by portfolio slug. `demo/_template.php` renders the visible accordion and the `FAQPage` JSON-LD from that one array, so markup and structured data cannot drift. Answers are plain text by design, because they are emitted into JSON-LD. The accordion reuses the existing `.faq-list` / `.faq-item` markup and the `.faq-q` handler already in `app.js`, so no new JavaScript was added; `.demo-faq-block` was added to `assets/css/style.css` for the wrapper and its heading.

Sixteen questions shipped rather than the fourteen drafted in §3, with two changes forced by the facts:

- **No support response time is claimed.** The AMC answer says 24/7 on any channel and stops there, because the interview answer was cut off before a response time. See §7 item 1.
- **The demo question matches reality.** It says the demo is live and access is shared on request, not “open access, credentials on this page”, because that is still true until a demo account exists (§8).

**Verification** &mdash; `php -l` passes on every changed file, and the schema was validated in isolation: 16 questions, clean JSON round-trip, no HTML leaking into answers, no empty fields. The page itself was **not** rendered, because Apache was not running locally. Worth loading `/demo/hrmx` once and running the URL through Google's Rich Results Test before counting the FAQ as live.

**Reminder** &mdash; the copy sections live in the seed script, so they appear on the page only after `php scripts/seed-portfolio-products.php` runs against the database. The FAQ block does not depend on that, since it is read from a PHP file at render time.

---

## 10. P2 implementation notes

**"When you should not buy HRMX"** sits immediately before the closing CTA, so the honest disqualifier is the last thing read before the ask. It carries the under-20-employees advice, the four signals that a build *is* right, and the three buyer mistakes as a numbered list.

**Module list** regrouped into four blocks rather than the three planned &mdash; *Core HR and organisation*, *Time, leave and payroll*, *Talent*, and *Employee self-service*. Self-service became prose instead of a bullet because it is the module that decides whether an HRMS gets adopted or abandoned, and it was doing no work buried eleventh in a list.

**Title and meta** needed a new mechanism. `demo/view.php` was building the title as `portfolios.title . ' — ' . SITE_NAME`, which put HRMX at 73 characters, and using `short_description` as the meta description, which ran past 200. Adding `includes/demo-seo.php` (same per-slug pattern as `demo-faqs.php`) lets a slug override the title tag and meta/OG description verbatim, with no `SITE_NAME` appended. The **H1 still comes from `portfolios.title`** on purpose: the title tag targets the query, the H1 speaks to the reader. Slugs without an entry behave exactly as before.

Shipped values, both verified by character count:

- Title (56): `HRMX HRMS: Payroll, Attendance & Leave for 20–1000 Staff`
- Description (137): `HRMX runs HR, attendance and payroll for 20 to 1,200+ employees. One-time build, no per-employee fee, you own the IP. Live in 8–10 weeks.`

**Closing CTA** was rewritten beyond the P2 list, for accuracy rather than style: it said "Try the demo", which implies open access the page does not yet offer. It now says the demo is live and access is shared on request, and it ends by promising to say so if a subscription product would serve them better &mdash; consistent with the new disqualifier section.

**Not done from §2**, since neither was priority-ranked: halving "The dashboard at a glance", and reworking "Who HRMX is for" to lead with workforce types instead of the industry list. Both are still worth doing.

### Final heading order on the page

H1 (from the DB title) → spreadsheet hook → dashboard → modules (4 × H3) → who it is for → Indian compliance → attendance problems (3 × H3) → rollout timeline (+1 H3) → cost and drivers (+2 H3) → data and ownership → when not to buy (+1 H3) → CTA → FAQ accordion (from the template).

That order answers the buyer's questions roughly in the sequence they ask them: *what is it, does it fit me, can it handle my mess, how long, what does it cost, can I trust you, should I even buy it.*
