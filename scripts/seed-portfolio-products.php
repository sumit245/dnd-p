#!/usr/bin/env php
<?php
/**
 * Seed / refresh the live-product portfolio entries.
 *
 * Idempotent: rows are matched on `slug` and updated in place, so this can be
 * re-run locally and on production after content edits.
 *
 * Usage:
 *   php scripts/seed-portfolio-products.php
 *
 * Images are expected at /assets/img/portfolio/{slug}.png (1600×1000, no device
 * frame). Entries without a screenshot render a coloured initials tile
 * (tile_color) instead. Run scripts/migrate-portfolio-industry.sql first.
 */
declare(strict_types=1);

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/db.php';

$img = static function (string $slug): ?string {
    foreach (['png', 'jpg'] as $ext) {
        if (is_file(__DIR__ . '/../assets/img/portfolio/' . $slug . '.' . $ext)) {
            return '/assets/img/portfolio/' . $slug . '.' . $ext;
        }
    }
    return null;
};

/*
 * sort_order = placement order on /portfolio. The page is a dense 10-unit grid
 * (desktop 4×3, portrait 2×4, square 2×2, landscape 2×1, CTA 2×2); tiles drop
 * into the first free slot in this order, so the sequence below reproduces the
 * intended layout with zero holes (30 rows, CTA plate last). Shapes come from
 * category + image ratio, so uploading a screenshot never changes a slot.
 *
 *   D D P D P D P P D P D D P D P Q D D D D Q P D L L D D D Q D P Q
 *   crm truckie ghumantoo bus lloyd-wfm hrmx trustmerecycle lloyd-ba newgen feasti
 *   waba erp detox tms merienda petoo hms rs sp bmp rashmika flax s4b tapzo
 *   fast-food skill writeeasy snub-foods snubchips inversio todays italian
 *
 * (erp/tms/hms rows are seeded by database.sql; their order is set below.)
 */

$entries = [

    // ───────────────────────────── 1. CRM ─────────────────────────────
    [
        'slug'       => 'crm',
        'category'   => 'erp',
        'badge'      => 'CRM',
        'sort_order' => 10,
        'industry'   => 'service',
        'client_name' => null,
        'client_url' => null,
        'tile_color' => '#C8293E',
        'title'      => 'DnD CRM — Sales, Projects & Team Operations in One Place',
        'short_description' => 'A custom CRM built for Indian SMEs that ties leads, clients, projects, invoicing, tasks, attendance and support tickets into a single daily dashboard.',
        'demo_url'   => 'https://crm.dashandots.com',
        'detailed_description' => <<<'HTML'
<h2>A CRM that runs the whole day, not just the sales pipeline</h2>
<p>Most CRM software stops at "who did we call and what did they say". That is useful, but it is not where small businesses actually lose money. They lose it in the gap between a closed deal and the work that follows: the project that nobody scoped properly, the invoice that sat in draft for three weeks, the support ticket that fell between two people, the field staff whose attendance nobody could verify.</p>
<p><strong>DnD CRM</strong> was built to close that gap. It is a <strong>custom CRM for small and mid-sized businesses in India</strong> that puts leads, prospects, clients, projects, tasks, invoices, expenses, team attendance and helpdesk tickets on one screen, so the person running the business sees the full picture before the first cup of tea is finished.</p>

<h2>What you see the moment you log in</h2>
<p>The dashboard in this demo is a real working environment. The first row tells you whether you are clocked in, how many tasks are open against your name, what events are on today and what money is due. Below that:</p>
<ul>
<li><strong>Projects overview</strong> — open, completed and on-hold counts with an overall progression bar, so a stuck project is visible before the client calls.</li>
<li><strong>Invoice overview</strong> — overdue, not paid, partially paid, fully paid and draft invoices with amounts against each. Cash-flow problems announce themselves here first.</li>
<li><strong>Income vs expenses</strong> — this year against last year, with a monthly trend, straight from the finance module.</li>
<li><strong>All tasks overview</strong> — to-do, in progress and done across the whole team, with overdue and priority markers.</li>
<li><strong>Team members</strong> — headcount, who is on leave today, who has clocked in and who has clocked out. The <em>geofencing attendance</em> module means a field executive can only clock in from where they are supposed to be.</li>
<li><strong>Ticket status</strong> — new, open and closed tickets grouped by type (general enquiry, bug report, feature request, billing, technical support), plus a 30-day trend.</li>
<li><strong>Announcements and reminders</strong> — the small things that keep a team in sync without another WhatsApp group.</li>
</ul>

<h2>Modules included in DnD CRM</h2>
<ul>
<li><strong>Leads, prospects and sales</strong> — capture from web forms or manual entry, assign, follow up, convert. Every touchpoint stays on the record.</li>
<li><strong>Clients and projects</strong> — one client, many projects, each with its own tasks, notes, files and billing history.</li>
<li><strong>Invoicing, purchase and expenses</strong> — GST-ready invoices, purchase orders, vendor bills and expense claims that roll into the income-vs-expense view automatically.</li>
<li><strong>Inventory</strong> — for businesses that sell products alongside services, stock levels live next to sales orders.</li>
<li><strong>HR records and payroll</strong> — employee master, documents, leave, payroll runs and salary slips, integrated with attendance.</li>
<li><strong>Tasks, events, polls, mailbox and messages</strong> — the internal collaboration layer that keeps work inside the system instead of scattered across chat apps and email.</li>
<li><strong>Fleet</strong> — for companies with vehicles, basic fleet records and running costs sit next to the projects they serve.</li>
<li><strong>Tickets and help &amp; support</strong> — a proper helpdesk for customers, with SLA-friendly status tracking.</li>
<li><strong>API management</strong> — connect the CRM to your website, WhatsApp, payment gateway or accounting software.</li>
<li><strong>Reports</strong> — sales, collections, productivity and attendance reports that management actually reads.</li>
</ul>

<h2>Who this CRM is for</h2>
<p>We have seen DnD CRM fit best with <strong>service businesses, agencies, consultancies, distributors and project-driven companies with 5 to 200 people</strong>: the kind of business where the founder still knows every client by name but can no longer keep every commitment in their head. If you are currently running the company on a mix of Excel sheets, WhatsApp groups and a free CRM trial that never quite fit, this is the shape of system that usually replaces all three.</p>

<h2>Why a custom CRM instead of a subscription tool</h2>
<p>Off-the-shelf CRMs are excellent at what their vendor decided a CRM should do. The trouble starts when your process is slightly different, when you need a field that does not exist, an approval step the tool does not support, or a report in the format your accountant wants. With DnD CRM you own the system. We adapt it to how your team already works, host it where you prefer, and there is no per-user licence creeping up every time you hire.</p>

<h2>See it working on your data</h2>
<p>Log in to the live demo above, click around, break things if you like. Then tell us what your sales-to-delivery flow looks like today. We will show you how it maps onto this system, what we would change, and what a realistic rollout looks like for your team.</p>
HTML,
    ],

    // ───────────────────────────── 2. TRUCKIE ─────────────────────────────
    [
        'slug'       => 'truckie',
        'category'   => 'tms',
        'badge'      => 'FLEET ERP',
        'sort_order' => 20,
        'industry'   => 'logistics',
        'client_name' => 'TikTrucks',
        'client_url' => 'https://tiktrucs.com',
        'tile_color' => '#3A5A7A',
        'title'      => 'Truckie — Fleet & Transport Management ERP for Logistics Companies',
        'short_description' => 'A control-tower ERP for transporters and fleet owners: vehicles, drivers, vendors, trips, live GPS tracking, route planning, maintenance, tyres, fuel and driver payroll across branches.',
        'demo_url'   => 'https://truckie.dashandots.com',
        'detailed_description' => <<<'HTML'
<h2>One screen for fleet, trips, cost, risk and service health</h2>
<p>If you run trucks, you already know the problem. The GPS vendor has one portal. The accountant has Tally. Maintenance lives in a diary at the workshop. Driver advances are on a WhatsApp thread. Trip sheets are on paper until someone types them in a week later. Every one of these is "working", and none of them talk to each other, which is why nobody can answer a simple question like <em>"how much did that Delhi–Mumbai run actually cost us?"</em></p>
<p><strong>Truckie</strong> is a <strong>transport management ERP built for Indian fleet operators, logistics companies and contract carriers</strong>. It replaces the scattered tools with a single control-tower dashboard that shows the whole operation at once: how many vehicles are moving, parked, offline or in maintenance; which trips are delayed; which service reminders are due; which vendor settlements are overdue; and what the fleet earned and spent today.</p>

<h2>What the control tower shows you</h2>
<ul>
<li><strong>Fleet statistics and utilisation</strong> — moving, parked, offline, no-data, in-trip, available and inactive vehicle counts, refreshed from live tracking.</li>
<li><strong>Needs attention</strong> — a prioritised list: delayed trips requiring dispatcher action, vehicles in GPS-offline state, service reminders due in 24 hours, overdue vendor settlements, customs or compliance holds. The dispatcher starts the day here.</li>
<li><strong>Fuel consumption (last 7 days)</strong> — per-day fuel spend, with anomalies visible immediately.</li>
<li><strong>Income vs expense trend</strong> and a <strong>today snapshot</strong> of available vehicles, revenue, expense and net position.</li>
<li><strong>Operational tables</strong> — live trips, pending POD, upcoming maintenance, expiring documents.</li>
</ul>

<h2>Modules in Truckie</h2>
<ul>
<li><strong>Vehicle management</strong> — registration, permits, insurance, fitness, PUC and tax expiry with reminders; ownership (own vs vendor-attached); running cost per km.</li>
<li><strong>Driver management</strong> — licences, medical, assignments, advances, trip earnings, behaviour scores, and a <strong>driver chat</strong> channel so instructions are on record.</li>
<li><strong>Vendor management</strong> — attached-vehicle owners, workshops, tyre and fuel vendors, with settlements tracked against trips.</li>
<li><strong>Trip management</strong> — booking to delivery: consignor/consignee, LR/consignment note, e-way bill details, loading and unloading, PODs, detention and additional charges.</li>
<li><strong>Customer management and coupons</strong> — customer master, contract rates, credit terms and promotional coupons for spot bookings.</li>
<li><strong>Live tracking, route planner and geofence</strong> — GPS positions on a map, planned vs actual routes, and geofence alerts for depots, customer sites and restricted zones.</li>
<li><strong>Warehouse and maintenance</strong> — parts stock, maintenance job cards, and a full <strong>tyre lifecycle</strong> module (fitment, rotation, retreading, scrapping) because tyres are usually the second-largest cost after fuel.</li>
<li><strong>Attendance and payroll</strong> — driver and staff attendance, trip-based pay, overtime and deductions, ready for salary processing.</li>
<li><strong>Multi-branch and multi-country</strong> — branch-wise P&amp;L with consolidated reporting for operators who run across regions or borders.</li>
</ul>

<h2>Who Truckie is for</h2>
<p>Fleet owners with 10 to 500 vehicles, third-party logistics companies, FMCG and industrial distribution fleets, mining and construction transporters, and aggregators who manage attached vehicles. If you are a growing transporter who has outgrown a GPS portal plus spreadsheets, this is the next step.</p>

<h2>Built around Indian transport reality</h2>
<p>Truckie understands LRs, e-way bills, advance-and-balance driver payments, attached vehicles, toll and fuel card reconciliation, and the fact that a trip's real cost only becomes clear after the driver settles. We designed the system with people who dispatch trucks every day, not from a textbook.</p>

<h2>Take it for a spin</h2>
<p>Open the live demo, look at the control tower, then imagine your own fleet on it. When you are ready, send us your vehicle count, the routes you run and the tools you use today. We will map Truckie onto your operation and show you exactly what changes on day one.</p>
HTML,
    ],

    // ───────────────────────────── 3. BUS BOOKING ─────────────────────────────
    [
        'slug'       => 'bus-booking',
        'category'   => 'tms',
        'badge'      => 'BUS BOOKING',
        'sort_order' => 40,
        'industry'   => 'travel',
        'client_name' => 'Vindhyashri Solutions',
        'client_url' => 'https://vindhyashrisolutions.com',
        'tile_color' => '#0F7C86',
        'title'      => 'Ghumantoo — Bus Ticket Booking & Operator Management Platform',
        'short_description' => 'A complete online bus reservation system for travel operators: routes, buses, schedules, dynamic pricing, seat bookings, crew assignment, attendance, occupancy alerts and revenue, with an operator onboarding flow.',
        'demo_url'   => 'https://bus-booking.dashandots.com',
        'detailed_description' => <<<'HTML'
<h2>Run your bus business online, without paying a marketplace for every seat</h2>
<p>Every bus operator in India faces the same trade-off. List on the big aggregators and hand over a commission on every ticket plus your customer relationship. Or stay offline and lose the passengers who now book everything on their phone. <strong>Ghumantoo</strong> is the third option: a <strong>white-label bus booking platform</strong> where operators manage routes, buses, schedules and pricing themselves, passengers book online, and the operator keeps the customer.</p>
<p>The demo above is the operator admin panel, logged in as a sample company. It is the same system behind the Ghumantoo passenger app.</p>

<h2>What an operator can do from the panel</h2>
<ul>
<li><strong>Routes</strong> — define origin, destination, boarding and dropping points, distance and duration.</li>
<li><strong>Buses</strong> — register vehicles with seat layouts (seater, sleeper, mixed), amenities, documents and photos.</li>
<li><strong>Schedules</strong> — assign buses to routes by day and time, with recurring departures and blackout dates.</li>
<li><strong>Pricing rules</strong> — base fares plus rules for weekends, festivals, last-minute demand, seat position and early-bird discounts. Change once, apply everywhere.</li>
<li><strong>Bookings</strong> — see recent bookings with booking ID, route, passenger, amount and travel date; handle cancellations, refunds and reschedules from one place.</li>
<li><strong>Occupancy alerts</strong> — get told when a departure is under-booked (time to promote it) or nearly full (time to add a bus).</li>
<li><strong>Checklists</strong> — pre-departure safety and cleanliness checks that crew complete on their phone.</li>
<li><strong>Staff management, crew assignment and attendance</strong> — drivers, conductors and helpers rostered per trip, with attendance captured at departure.</li>
<li><strong>Feedback</strong> — passenger ratings and comments tied to the exact bus, crew and trip.</li>
<li><strong>Revenue</strong> — daily, route-wise and bus-wise revenue with settlement reports.</li>
<li><strong>Profile and onboarding</strong> — basic details, company details, documents and bank details, with a status tracker, so new operators can be verified and go live quickly.</li>
</ul>

<h2>For the passenger</h2>
<p>Passengers search a route and date, pick seats on a visual layout, choose boarding and dropping points, pay online and receive an e-ticket with a QR code. The companion <strong>Ghumantoo Android app</strong> (also in our portfolio) gives them booking history, live trip status and support in their pocket.</p>

<h2>Who this is for</h2>
<ul>
<li>Individual bus operators who want their own booking website and app.</li>
<li>Regional travel companies with 5–100 buses that want to stop paying aggregator commissions.</li>
<li>Entrepreneurs building a bus-booking marketplace for a state or region, onboarding multiple operators under one brand.</li>
<li>Corporate and college shuttle operators who need fixed-route booking with monthly passes.</li>
</ul>

<h2>Why operators choose a custom platform</h2>
<p>Because the rules of a bus business are local. Pricing changes for Chhath and Diwali. Boarding points move. A conductor needs to sell the last three seats in cash at the stand and have them show as sold online immediately. A generic SaaS rarely bends that far. Ghumantoo was built with operators, and we customise it further for each deployment: your branding, your payment gateway, your GST invoicing, your reports.</p>

<h2>Next step</h2>
<p>Explore the demo panel, then tell us how many buses and routes you run. We will show you a live booking flow on your own sample route and walk you through the launch plan for both the web and the passenger app.</p>
HTML,
    ],

    // ───────────────────────────── 4. HRMX ─────────────────────────────
    [
        'slug'       => 'hrmx',
        'category'   => 'erp',
        'badge'      => 'HRMS',
        'sort_order' => 60,
        'industry'   => 'service',
        'client_name' => null,
        'client_url' => null,
        'tile_color' => '#C8293E',
        'title'      => 'HRMX — HR, Attendance & Payroll Management System',
        'short_description' => 'An HRMS built for growing Indian companies: employee records, organisation structure, timesheets, leave, payroll, training, performance, recruitment and an HR helpdesk on one dashboard.',
        'demo_url'   => 'https://hrmx.dashandots.com',
        'detailed_description' => <<<'HTML'
<h2>HR software that your HR person will actually enjoy opening</h2>
<p>Somewhere between employee number 20 and employee number 50, the spreadsheet stops working. Leave balances drift. Someone's PF number is in an old email. Payroll takes three days and one apology every month. Appraisals happen late because nobody can find last year's goals. <strong>HRMX</strong> is the system we built for exactly that stage: a <strong>human resource management system for small and mid-sized businesses in India</strong> that is complete enough to run HR end to end, and simple enough that a two-person HR team can own it.</p>

<h2>The dashboard at a glance</h2>
<p>Log in to the demo and you will see the day laid out: total employees with active and inactive counts, quick links to roles and permissions, leave applications waiting for action, and HR settings. Below that, today's absent and present counts, project and task status, department and designation charts, an expenses summary (salaries paid, account balance, travel and other expenses), and the helpdesk ticket counters. It is the morning briefing an HR head normally has to assemble by hand.</p>

<h2>Modules in HRMX</h2>
<ul>
<li><strong>Staff and core HR</strong> — employee master with personal, employment, statutory (PAN, Aadhaar, PF, ESI, UAN) and bank details; documents with expiry reminders; onboarding and exit checklists.</li>
<li><strong>Organisation</strong> — companies, branches, departments, designations and reporting lines, with org-chart views.</li>
<li><strong>Timesheet and attendance</strong> — daily and weekly timesheets, project-wise hours, biometric or mobile punch integration, shifts and overtime.</li>
<li><strong>Leave management</strong> — leave types, accrual rules, holiday calendars, approval workflow and balances visible to the employee.</li>
<li><strong>Payroll</strong> — salary structures, earnings and deductions, PF/ESI/PT/TDS computations, arrears, loans and advances, payslips and bank transfer files. Runs in minutes, not days.</li>
<li><strong>Training</strong> — programmes, sessions, attendance and feedback, tied to the employee record.</li>
<li><strong>Performance</strong> — goals, KRAs, self and manager reviews, rating cycles and history.</li>
<li><strong>Recruitment</strong> — job openings, candidate pipeline, interviews and offer letters, converting a hired candidate into an employee in one click.</li>
<li><strong>HR calendar, tickets and files manager</strong> — holidays and events, an internal HR helpdesk for employee queries, and a document library for policies and forms.</li>
<li><strong>Project management</strong> — lightweight project and task tracking so utilisation reports come from real work data.</li>
<li><strong>Employee self-service</strong> — employees see payslips, apply for leave, update details and raise tickets without emailing HR.</li>
</ul>

<h2>Who HRMX is for</h2>
<p>Companies with 20 to 1,000 employees across IT services, manufacturing, retail chains, healthcare, education, logistics and professional services. It works for single-office teams and for multi-branch companies with different shifts, leave policies and payroll rules per location.</p>

<h2>Built for Indian compliance, customised for your policies</h2>
<p>Statutory calculations for PF, ESI, professional tax and TDS are built in and kept current. Everything else, from leave policy to appraisal format to payslip layout, is configured to match how your company already works. Because you own the deployment, there is no per-employee subscription and no forced upgrade that breaks a report you depend on.</p>

<h2>See your HR process in it</h2>
<p>Try the demo, then share your current attendance method, payroll components and headcount. We will configure a sample with your structure and show you a payroll run start to finish.</p>
HTML,
    ],

    // ───────────────────────────── 5. NEWGEN ERP ─────────────────────────────
    [
        'slug'       => 'newgen-erp',
        'category'   => 'erp',
        'badge'      => 'MFG ERP',
        'sort_order' => 90,
        'industry'   => 'manufacturing',
        'client_name' => 'NewGen Windows',
        'client_url' => null,
        'tile_color' => '#2B5D8C',
        'title'      => 'NewGen ERP — Manufacturing ERP for uPVC & Aluminium Window and Door Fabricators',
        'short_description' => 'A made-to-order manufacturing ERP: product configurator, BOQ, design drawings with customer approval links, measurements, orders, production planning, inventory, procurement, quality and executive MIS.',
        'demo_url'   => 'https://newgen-erp.dashandots.com',
        'detailed_description' => <<<'HTML'
<h2>From site measurement to released design, without the WhatsApp back-and-forth</h2>
<p>Made-to-order manufacturing has a problem that standard ERPs never solve well: every order is a new product. A window fabricator does not "sell SKU 4521". They sell a 2400 × 2100 mm three-panel sliding door in a specific series, colour and glass, drawn for one customer's opening, approved by that customer, signed off by an engineer, and only then cut, assembled, glazed and installed. Miss one step and you have an expensive frame that fits nowhere.</p>
<p><strong>NewGen ERP</strong> was built with a uPVC and aluminium windows and doors manufacturer to run exactly that flow. It is a <strong>manufacturing ERP for engineer-to-order and configure-to-order businesses</strong>: fenestration, modular furniture, kitchens, façades, signage, HVAC ducting, and any fabricator whose product starts as a drawing.</p>

<h2>What the demo shows</h2>
<p>The screenshot is a live design record, <em>DSN-20260907-000001</em>, sitting in the "With customer" stage. You can see the full lifecycle on one line: <strong>Draft → With customer → Customer approved → Engineer signed off → Released</strong>. The elevation drawing is generated from the specification (series, type, size, panels, colour), with fixed and sliding panels marked and dimensions shown. Buttons on the right export a PDF, let the team annotate, raise a revision, or generate a <strong>customer approval link</strong>, so the customer approves from their phone and the approval is stamped into the history with who, when and which revision.</p>

<h2>Modules in NewGen ERP</h2>
<ul>
<li><strong>Configurator</strong> — build a product from series, type, dimensions, panel layout, profile colour, glass and hardware. Rules stop impossible combinations before they reach the factory.</li>
<li><strong>BOQ</strong> — bill of quantities generated from the configuration: profiles by length, glass by area, hardware by count, with wastage factors per series.</li>
<li><strong>Designs</strong> — drawings, revisions, annotations, history and component lists, with the approval workflow above.</li>
<li><strong>Measurements</strong> — site measurement records with opening dimensions, tolerances and photos, feeding the configurator directly.</li>
<li><strong>Catalogue</strong> — series, profiles, hardware, glass and accessories with supplier links and costs.</li>
<li><strong>Orders</strong> — customer orders bundling multiple designs, with stage-wise status from confirmation to installation.</li>
<li><strong>PPC (production planning and control)</strong> — cutting lists, job cards, machine loading and shop-floor status per order line.</li>
<li><strong>Inventory and stores</strong> — profile bars, glass, hardware and consumables across stores, with reservations against orders.</li>
<li><strong>Procurement</strong> — purchase requisitions driven by BOQ shortfalls, POs, GRN and supplier bills.</li>
<li><strong>Quality</strong> — inspection checkpoints at cutting, assembly, glazing and dispatch, with defect logging.</li>
<li><strong>Executive MIS</strong> — order book, WIP, on-time delivery, material cost variance and margin per order, for the people who need the numbers without opening a module.</li>
</ul>

<h2>Who this ERP is for</h2>
<p>uPVC and aluminium window and door fabricators, façade and curtain-wall contractors, modular furniture and kitchen manufacturers, glass processors, and any make-to-order factory in India with 10 to 500 people that currently manages designs in CAD exports, quotes in Excel and production on a whiteboard.</p>

<h2>Why not a generic manufacturing ERP</h2>
<p>Generic ERPs assume a fixed bill of materials. In fenestration the BOM is born with the order, changes with every revision, and must be approved by a customer who is not an engineer. NewGen ERP treats the design as the master record and derives everything else from it. That single decision removes most of the rework, and most of the arguments.</p>

<h2>Bring a real drawing</h2>
<p>Open the demo, then send us one of your typical orders: a measurement sheet and the drawing you would normally make. We will configure it in NewGen ERP with your series and show you the BOQ, the cutting list and the approval link, end to end.</p>
HTML,
    ],

    // ───────────────────────────── 6. WABA ─────────────────────────────
    [
        'slug'       => 'waba',
        'category'   => 'web',
        'badge'      => 'WHATSAPP API',
        'sort_order' => 110,
        'industry'   => 'service',
        'client_name' => null,
        'client_url' => null,
        'tile_color' => '#C8293E',
        'title'      => 'DnD Connect — WhatsApp Business API Platform for Teams',
        'short_description' => 'A WhatsApp Business API platform: shared team inbox, chatbot flows, broadcast campaigns, message templates, contacts, catalogue, webhooks, click-to-chat links and API access, running on official Meta Cloud API.',
        'demo_url'   => 'https://waba.dashandots.com',
        'detailed_description' => <<<'HTML'
<h2>WhatsApp is where your customers already are. Run it like a business channel.</h2>
<p>In India the customer conversation happens on WhatsApp, whether you planned for it or not. Orders, complaints, follow-ups, payment reminders, delivery updates: all of it lands on one phone, in one person's chat list, invisible to the rest of the team and impossible to report on. <strong>DnD Connect</strong> turns that phone into a proper channel. It is a <strong>WhatsApp Business API platform</strong> built on Meta's official Cloud API, with a shared inbox for your team, automation for the routine, campaigns for the outreach, and an API so your own systems can send and receive messages.</p>

<h2>What the dashboard shows</h2>
<p>The demo dashboard tracks connected devices (WhatsApp Business Accounts), broadcast campaigns with pending, sent and failed counts, subscription status, and messages sent against your limit. The accounts table below shows each connected number with its <strong>quality rating</strong>, <strong>messaging tier</strong>, message count, <strong>webhook URL</strong> and connection status, the operational facts you need when Meta throttles a number or a webhook stops firing.</p>

<h2>Modules in DnD Connect</h2>
<ul>
<li><strong>Chat (shared team inbox)</strong> — every conversation in one place, assignable to agents, with notes, labels, quick replies and media. Nobody replies twice; nobody is forgotten.</li>
<li><strong>Chatbot flows</strong> — visual, no-code flows for greetings, menus, FAQ, lead capture, order status and hand-off to a human when needed.</li>
<li><strong>Agents and teams</strong> — roles, routing rules, working hours and per-agent performance.</li>
<li><strong>Templates</strong> — create and submit message templates for Meta approval, with variables, buttons and media headers.</li>
<li><strong>Blast / bulk campaigns</strong> — segment contacts, schedule broadcasts, track delivery and replies. Built for opted-in marketing and transactional messaging, within WhatsApp's policies.</li>
<li><strong>Contacts and labels</strong> — import, tag and segment; sync with your CRM.</li>
<li><strong>Catalogue</strong> — product catalogue for WhatsApp commerce, with cart and order messages.</li>
<li><strong>Ads manager</strong> — click-to-WhatsApp ad tracking so you know which campaign a conversation came from.</li>
<li><strong>Reports</strong> — volume, response time, resolution, campaign performance and agent productivity.</li>
<li><strong>API, webhooks, integrations and API health</strong> — REST API with documentation, outbound webhooks for inbound messages and status updates, ready-made integrations, and a health page that tells you at a glance whether everything is connected.</li>
<li><strong>File manager and link generator</strong> — media library and click-to-chat links with pre-filled messages for websites, QR codes and print.</li>
</ul>

<h2>Who uses DnD Connect</h2>
<p>D2C brands and e-commerce stores sending order updates; clinics and hospitals confirming appointments; schools and coaching institutes handling admissions; real-estate and finance teams qualifying leads; logistics companies sharing delivery status; and any business with more than one person answering customer messages. It works as a standalone platform or embedded into your ERP, CRM or booking system through the API.</p>

<h2>Own the platform, not just a seat</h2>
<p>Most WhatsApp tools charge per agent, per message, per month, and keep your data on their servers. DnD Connect is deployed for you, on your infrastructure or ours, with your Meta Business Account. You pay Meta's conversation charges directly and nothing per seat. For agencies and resellers we also offer it <strong>white-labelled</strong> with multi-tenant management.</p>

<h2>Connect a number and try it</h2>
<p>Look through the demo, then tell us your use case: support, sales, notifications or all three. We will connect a test number, build one flow for you and show you a live conversation end to end.</p>
HTML,
    ],

    // ───────────────────────────── 7. GHUMANTOO APP ─────────────────────────────
    [
        'slug'       => 'ghumantoo-app',
        'category'   => 'mobile',
        'badge'      => 'ANDROID',
        'sort_order' => 30,
        'industry'   => 'travel',
        'client_name' => 'Vindhyashri Solutions',
        'client_url' => 'https://vindhyashrisolutions.com',
        'tile_color' => '#0F7C86',
        'title'      => 'Ghumantoo — Bus Ticket Booking App for Passengers (Android)',
        'short_description' => 'The passenger side of the Ghumantoo bus platform: search routes, pick seats on a visual layout, choose boarding points, pay online and travel with a QR e-ticket, with live trip status and booking history.',
        // Play listing for com.dashandots.ghumantoo currently returns 404 — set once the app is public.
        'demo_url'   => '',
        'detailed_description' => <<<'HTML'
<h2>Booking a bus should take less time than waiting for one</h2>
<p><strong>Ghumantoo</strong> is the passenger app for the Ghumantoo bus booking platform, built for regional travel in India where most journeys are still booked at the counter or over a phone call. It gives operators a branded app of their own and gives passengers the experience they expect from a national aggregator, on routes those aggregators often do not cover well.</p>

<h2>What passengers can do</h2>
<ul>
<li><strong>Search</strong> by origin, destination and date, with results showing departure time, bus type, amenities, fare and seats left.</li>
<li><strong>Pick seats</strong> on a visual seat map (seater, sleeper or mixed layouts), with ladies' seats and already-booked seats marked.</li>
<li><strong>Choose boarding and dropping points</strong> with times and map pins, so nobody waits at the wrong stand.</li>
<li><strong>Pay online</strong> by UPI, cards, net banking or wallets, and receive an <strong>e-ticket with QR code</strong> that the conductor scans at boarding.</li>
<li><strong>Track the trip</strong> — live bus location and expected arrival at your boarding point on the day of travel.</li>
<li><strong>Manage bookings</strong> — history, cancellations and refunds per the operator's policy, reschedules, and downloadable invoices.</li>
<li><strong>Rate the journey</strong> — feedback goes straight to the operator's panel, tied to the bus and crew.</li>
<li><strong>Get notified</strong> — booking confirmation, departure reminders and delay alerts via push notification and WhatsApp.</li>
</ul>

<h2>How it connects to the operator panel</h2>
<p>Every search, seat and payment in the app reads from and writes to the same system the operator uses in the <a href="/demo/bus-booking">Ghumantoo operator platform</a>. Seats sold at the counter disappear from the app instantly; a pricing rule changed in the panel reflects in the next search; a crew change shows in the passenger's trip details. There is one source of truth.</p>

<h2>Built for real Indian routes</h2>
<p>Low-bandwidth friendly, works on entry-level Android phones, supports regional languages, and keeps tickets available offline once downloaded. Payment retries and pending-payment handling are designed for patchy connectivity at bus stands, not for a demo on office Wi-Fi.</p>

<h2>Who this is for</h2>
<p>Bus operators and travel companies who want their own passenger app under their own brand; state or regional marketplaces onboarding many operators; and shuttle services for corporates, colleges or pilgrimage circuits that need fixed-route booking with passes.</p>

<h2>Want a branded version?</h2>
<p>We deploy the app with your name, logo, colours and payment gateway, publish it on the Play Store under your developer account, and connect it to your operator panel. Tell us your routes and fleet size and we will show you a live booking on your own sample route.</p>
HTML,
    ],

    // ───────────────────────────── 8. LLOYD WFM ─────────────────────────────
    [
        'slug'       => 'lloyd-wfm',
        'category'   => 'mobile',
        'badge'      => 'ANDROID',
        'sort_order' => 50,
        'industry'   => 'energy',
        'client_name' => 'Sugs Lloyd Limited',
        'client_url' => 'https://slldm.com',
        'tile_color' => '#1F8A4C',
        'title'      => 'LloydWFM — Workforce & Vendor Task Management App for Sugs Lloyd',
        'short_description' => 'A field workforce management app built for Sugs Lloyd, a solar and streetlight EPC company: assign site jobs to vendors, approve submitted work, track engineer and project progress, and keep coordination on record instead of on calls.',
        'demo_url'   => 'https://play.google.com/store/apps/details?id=com.dashandots.lloydwfm',
        'detailed_description' => <<<'HTML'
<h2>When the work happens on site, the system has to be in a pocket</h2>
<p><strong>LloydWFM</strong> is the staff-side app we built for <strong>Sugs Lloyd</strong>, an EPC company that executes rooftop solar and streetlight installation projects through a network of engineers, vendors and contractors spread across hundreds of sites. Before the app, coordinating that network meant phone calls, photos on WhatsApp and approvals that lived in someone's memory. The app puts the whole loop, assign, execute, submit, approve, on record.</p>

<h2>What staff can do in the app</h2>
<ul>
<li><strong>Assign tasks to vendors</strong> — pick the site, the scope, the deadline and the vendor; the vendor receives it instantly in their companion app.</li>
<li><strong>Review vendor submissions</strong> — completed work comes back with photos, quantities, notes and location stamps.</li>
<li><strong>Approve or send back</strong> — one tap to approve, or return with comments; every decision is time-stamped against the person who made it.</li>
<li><strong>Track status</strong> — open, in progress, submitted, approved and rejected counts per site and per vendor, so a delayed job is visible before it becomes a delayed project.</li>
<li><strong>See team performance</strong> — per-engineer totals, completed and pending, and a project overview with total sites against completed sites per work order (for example a 54-site rooftop order at 47 done, 7 pending).</li>
<li><strong>Coordinate</strong> — task-level comments and attachments, so the context stays with the job rather than in a chat thread.</li>
</ul>

<h2>The vendor side</h2>
<p>Vendors use the companion <a href="/demo/lloyd-ba">Lloyd BA (Business Associate) app</a> to receive assignments, update progress, upload proof of work and raise queries. Because both apps share one backend, an approval on the staff app becomes a completed job and a billable line for the vendor at the same moment.</p>

<h2>Why a custom app instead of a generic task tool</h2>
<p>Generic task apps do not understand vendors, sites, measurement-based completion or the approval hierarchy of an infrastructure company. LloydWFM was designed around Sugs Lloyd's actual process: who can assign, who must approve, what evidence is required before a job counts as done, and how that feeds billing and reporting. The result is an app that field staff adopted without training, because it asks them for exactly what they already did, just in a structured way.</p>

<h2>Under the hood</h2>
<p>Native Android app with offline-first task caching for low-connectivity sites, camera and GPS capture, push notifications, role-based access, and a web admin for management reporting. Built and maintained by Dashandots, published on Google Play under the client's account.</p>

<h2>Need something similar?</h2>
<p>If your business runs on contractors, franchisees, field technicians or distributors, the same pattern applies: an app for your team, an app for your partners, one backend, full traceability. Tell us how work is assigned and approved in your company today and we will sketch the app pair that fits.</p>
HTML,
    ],

    // ───────────────────────────── 9. LLOYD BA ─────────────────────────────
    [
        'slug'       => 'lloyd-ba',
        'category'   => 'mobile',
        'badge'      => 'ANDROID',
        'sort_order' => 80,
        'industry'   => 'energy',
        'client_name' => 'Sugs Lloyd Limited',
        'client_url' => 'https://slldm.com',
        'tile_color' => '#1F8A4C',
        'title'      => 'Lloyd BA — Business Associate & Vendor Field App for Sugs Lloyd',
        'short_description' => 'The vendor-side companion to LloydWFM: business associates receive assigned jobs, update progress from site, upload photo proof and submit work for approval, with status and history in one place.',
        // Play listing for com.dashandots.lloydba currently returns 404 — set once the app is public.
        'demo_url'   => '',
        'detailed_description' => <<<'HTML'
<h2>Give partners a clear job list instead of a ringing phone</h2>
<p><strong>Lloyd BA</strong> is the business-associate app in the Sugs Lloyd workforce system, used by the vendors and installers who execute rooftop solar and streetlight jobs on the ground. Where <a href="/demo/lloyd-wfm">LloydWFM</a> is used by company staff to assign and approve, Lloyd BA is what the vendor, contractor or field associate opens on site. Its job is simple: show exactly what has been assigned, make it easy to report progress with evidence, and make submission for approval a single tap.</p>

<h2>What associates can do</h2>
<ul>
<li><strong>See assigned jobs</strong> — site, scope, quantities, deadline and contact person, sorted by urgency.</li>
<li><strong>Accept and start</strong> — acknowledge a job so staff know it is in hand.</li>
<li><strong>Update progress from site</strong> — percentage or quantity complete, with photos captured in-app (with GPS and time stamp) and notes.</li>
<li><strong>Submit for approval</strong> — once done, submit; the staff app receives it for review immediately.</li>
<li><strong>Handle returns</strong> — if work is sent back, the comment is right there with the job, and resubmission is one step.</li>
<li><strong>Track history</strong> — approved and rejected work by month, useful for reconciling bills and settling disputes with data instead of memory.</li>
<li><strong>Get notified</strong> — new assignments, approvals and messages arrive as push notifications.</li>
</ul>

<h2>Why the two-app design</h2>
<p>Staff and vendors need different things. Staff need oversight across many vendors and sites; vendors need a focused list and a fast way to report. Splitting the experience into two apps on one backend keeps each side simple while the company gets a complete, auditable record: who assigned, who did, who approved, with evidence, all time-stamped.</p>

<h2>Built for field conditions</h2>
<p>Works on basic Android phones, caches jobs for offline sites and syncs when the signal returns, compresses photos to save data, and keeps the interface to a handful of large, obvious actions. Associates were productive on the first day without a training session.</p>

<h2>Similar needs?</h2>
<p>Franchise networks, dealer service teams, installation contractors, delivery partners, audit and inspection agencies: any business coordinating external partners can use this pattern. Tell us who your partners are and what "done" looks like in your business, and we will show you how a partner app would work for you.</p>
HTML,
    ],

    // ───────────────────────────── 10. TRUSTMERECYCLE ─────────────────────────────
    [
        'slug'       => 'trustmerecycle',
        'category'   => 'mobile',
        'badge'      => 'ANDROID',
        'sort_order' => 70,
        'industry'   => 'manufacturing',
        'client_name' => 'Trust Me Recycle',
        'client_url' => 'https://trustmerecycle.com',
        'tile_color' => '#2E8B57',
        'title'      => 'TrustMeRecycle — Scrap & E-Waste Pickup App for an ISO-Certified Recycler',
        'short_description' => 'A two-sided app for Trust Me Recycle, a 25-year-old ISO-certified scrap and e-waste company: businesses request pickups for metal, electronic, battery, IT, plastic and paper scrap; collection vendors run their assigned pickups from a dashboard.',
        'demo_url'   => 'https://play.google.com/store/apps/details?id=com.dashandots.trustmerecycle',
        'detailed_description' => <<<'HTML'
<h2>Turning a 25-year-old scrap business into a tap-to-book service</h2>
<p><strong>Trust Me Recycle</strong> is an ISO 9001:2015-certified scrap and e-waste management company that has served business houses and startups across India for around 25 years, handling metal, electronic, battery, computer and IT, electrical, cable, plastic, wooden and paper scrap. Their customers, from factories to offices, used to book pickups by phone and chase paperwork by email. The <strong>TrustMeRecycle app</strong> we built brings that entire process onto the customer's phone.</p>

<h2>Two roles, one app</h2>
<p>The first screen asks a single question: <em>"I want to give scrap"</em> or <em>"I collect scrap (Vendor)"</em>. Scrap generators, from a corporate office to a quick-commerce dark store, get the customer experience below. Collection vendors get a <strong>vendor operations dashboard</strong> with assigned, pending and added-today counts and a list of customer accounts to collect from, the demo shows accounts such as Blinkit, Zepto, Zomato, Amazon and Flipkart, so a collector on the road knows exactly where to go and what to log.</p>

<h2>What customers can do</h2>
<ul>
<li><strong>Request a pickup</strong> — choose scrap categories, estimate quantity, add photos, set the address and a preferred slot.</li>
<li><strong>Track the request</strong> — scheduled, assigned, picked up, weighed, settled, with notifications at each step.</li>
<li><strong>See the weighbridge result</strong> — actual weights per category after pickup, so the settlement is transparent.</li>
<li><strong>Get documentation</strong> — pickup receipts, and for e-waste, the certificates and forms that corporate customers need for EPR and environmental compliance, downloadable from the app.</li>
<li><strong>Manage multiple sites</strong> — one company account, many pickup locations, with history per location.</li>
<li><strong>Repeat easily</strong> — re-book a previous pickup in two taps; schedule recurring collections for regular generators.</li>
<li><strong>Reach support</strong> — in-app chat and call for questions about categories, pricing structure or scheduling.</li>
</ul>

<h2>Why this matters for a recycler</h2>
<p>E-waste and scrap is a trust business, and the certification in the company name is the point. Corporate customers need proof that material was collected, handled and processed responsibly. Putting the request, the weights and the certificates in one auditable app makes that proof automatic, and it makes the company noticeably easier to do business with than a competitor who still runs on phone calls.</p>

<h2>What vendors can do</h2>
<ul>
<li><strong>See assigned pickups</strong> for the day with customer, site and scrap categories.</li>
<li><strong>Log a collection</strong> against a customer account with category-wise quantities and photos.</li>
<li><strong>Add unscheduled pickups</strong> when a customer calls directly, keeping every collection in the system.</li>
<li><strong>Track pending vs completed</strong> so settlements with Trust Me Recycle reconcile without argument.</li>
</ul>

<h2>Under the hood</h2>
<p>Native Android app connected to an operations backend for dispatch, weighbridge entry, settlement and certificate generation; push notifications; photo capture; and an admin panel for the Trust Me Recycle team. Published on Google Play under the client's developer account and maintained by Dashandots.</p>

<h2>Running a service business with pickups or visits?</h2>
<p>Waste and recycling, laundry, home services, equipment maintenance, sample collection: the shape is the same. A customer app to request, a team app or panel to execute, and a backend that ties them together with documentation. Tell us what a request looks like in your business today and we will show you how it turns into an app.</p>
HTML,
    ],

    // ───────────────────────────── CLIENT SYSTEMS (no public demo) ─────────────────────────────
    [
        'slug'       => 'feasti',
        'category'   => 'mobile',
        'industry'   => 'food-retail',
        'badge'      => 'APPS · ERP',
        'sort_order' => 100,
        'title'      => 'Feasti',
        'client_name' => 'Feasti',
        'client_url' => 'https://feasti.com',
        'tile_color' => '#E8552E',
        'short_description' => 'A subscription platform for daily home-cooked meals. We built the customer, home-chef and driver apps on one ERP that handles subscriptions, daily menus, order routing and chef settlements — with the website running off the same catalogue.',
        'demo_url'   => null,
        'detailed_description' => null,
    ],
    [
        'slug'       => 'rs-robotics',
        'category'   => 'erp',
        'industry'   => 'manufacturing',
        'badge'      => 'ERP',
        'sort_order' => 180,
        'title'      => 'RS Robotics & Automation',
        'client_name' => 'RS Robotics & Automation',
        'client_url' => 'https://www.rsrobotic.com',
        'tile_color' => '#2B5D8C',
        'short_description' => 'A manufacturer of line automation systems, special purpose machines and robotic cells. Every SPM is a one-off build, so the ERP carries each order from enquiry to dispatch — BOM, purchase, stores issue, job cards and production progress.',
        'demo_url'   => null,
        'detailed_description' => null,
    ],
    [
        'slug'       => 'sp-constructs',
        'category'   => 'erp',
        'industry'   => 'construction',
        'badge'      => 'ERP',
        'sort_order' => 190,
        'title'      => 'SP Constructs',
        'client_name' => 'SP Constructs',
        'client_url' => 'https://spconstructs.com',
        'tile_color' => '#B4731F',
        'short_description' => 'Dozens of small jobs run at the same time, each with its own materials, labour and billing schedule. The ERP keeps costing per job rather than per month — what was issued, who was deployed, what is billed and what is still to recover.',
        'demo_url'   => null,
        'detailed_description' => null,
    ],
    [
        'slug'       => 'bharatiya-merit-party',
        'category'   => 'erp',
        'industry'   => 'organisations',
        'badge'      => 'ERP',
        'sort_order' => 200,
        'title'      => 'Bharatiya Merit Party',
        'client_name' => 'Bharatiya Merit Party',
        'client_url' => 'https://bharatiyameritparty.org',
        'tile_color' => '#E07B23',
        'short_description' => 'Membership that has to be verified, and units nesting from national down to district. The ERP holds that hierarchy properly — members registered and verified against a unit, roles assigned within it, and reporting that rolls up the same way.',
        'demo_url'   => null,
        'detailed_description' => null,
    ],
    [
        'slug'       => 'smart4bharat',
        'category'   => 'erp',
        'industry'   => 'organisations',
        'badge'      => 'ERP',
        'sort_order' => 230,
        'title'      => 'SMaRT4Bharat',
        'client_name' => 'SMaRT4Bharat',
        'client_url' => 'https://smart4bharat.com',
        'tile_color' => '#C9541B',
        'short_description' => 'A membership body that also runs grants, legal support and events — three workflows sharing one list of people. The ERP keeps that list authoritative and hangs applications, support requests and event participation off it.',
        'demo_url'   => null,
        'detailed_description' => null,
    ],
    [
        'slug'       => 'skill-bridge-india',
        'category'   => 'web',
        'industry'   => 'education',
        'badge'      => 'LMS',
        'sort_order' => 260,
        'title'      => 'Skill Bridge India',
        'client_name' => 'Skill Bridge India',
        'client_url' => 'https://skillbridgeindiatechnologies.com',
        'tile_color' => '#2E4EA8',
        'short_description' => 'Programmes run in parallel across Noida, Lucknow and Bhopal, each with its own batches and certification dates. The LMS holds enrolments, schedules, course material, assessments and progress, and issues certificates from the same record.',
        'demo_url'   => null,
        'detailed_description' => null,
    ],
    [
        'slug'       => 'writeeasy',
        'category'   => 'web',
        'industry'   => 'education',
        'badge'      => 'LMS',
        'sort_order' => 270,
        'title'      => 'WriteEasy',
        'client_name' => 'WriteEasy',
        'client_url' => 'https://writeeasyhub.com',
        'tile_color' => '#6A4AA8',
        'short_description' => 'Work arrives continuously, each piece with its own subject, deadline and assigned writer, and the deadline is the whole product. The system takes each request in against a subject, allocates it, tracks drafting and review, and logs delivery.',
        'demo_url'   => null,
        'detailed_description' => null,
    ],
    [
        'slug'       => 'snub-foods',
        'category'   => 'web',
        'industry'   => 'food-retail',
        'badge'      => 'POS',
        'sort_order' => 280,
        'title'      => 'Snüb Foods',
        'client_name' => 'Snüb Foods',
        'client_url' => 'https://snubfoods.com',
        'tile_color' => '#4A7C3F',
        'short_description' => 'Frozen and refrigerated lines sell through different channels but draw on the same stock. The POS bills fast at the counter while keeping catalogue, variants and stock movement in step, so the day-close report matches what actually left the freezer.',
        'demo_url'   => null,
        'detailed_description' => null,
    ],
    [
        'slug'       => 'inversio365',
        'category'   => 'web',
        'industry'   => 'service',
        'badge'      => 'HR',
        'sort_order' => 300,
        'title'      => 'Inversio365',
        'client_name' => 'Inversio365',
        'client_url' => 'https://inversio365.com',
        'tile_color' => '#1E5FA8',
        'short_description' => 'HR modules bolted onto a general ERP tend to fit no one, so here the HR system is the product. Employee records, attendance, leave, payroll and role-based access, with managers, staff and administrators each seeing only their own slice.',
        'demo_url'   => null,
        'detailed_description' => null,
    ],
    // ───────────────────────────── GRAPHICS (from /design work) ─────────────────────────────
    // Social, print and motion pieces. No demo/detail page — the tile is the work.
    [
        'slug' => 'tapzo-cashback', 'category' => 'graphics', 'badge' => 'SOCIAL', 'sort_order' => 240,
        'industry' => 'food-retail', 'client_name' => 'Tapzo', 'client_url' => null, 'tile_color' => '#E8552E',
        'title' => 'Tapzo — First Order Cashback Banner',
        'short_description' => 'A 25% cashback banner that has to carry five partner logos and still read in one glance. Burger, offer, code — nothing else gets in the way.',
        'demo_url' => '', 'detailed_description' => '',
    ],
    [
        'slug' => 'fast-food-banner', 'category' => 'graphics', 'badge' => 'PRINT', 'sort_order' => 250,
        'industry' => 'food-retail', 'client_name' => 'Self-initiated', 'client_url' => null, 'tile_color' => '#E07B23',
        'title' => 'Fast Food — Triangular Menu Banner',
        'short_description' => 'Seven dishes cut into one triangular run for a hoarding-width banner. Built so the same artwork works at counter size and at 20 feet.',
        'demo_url' => '', 'detailed_description' => '',
    ],
    [
        'slug' => 'detox-story', 'category' => 'graphics', 'badge' => 'SOCIAL', 'sort_order' => 130,
        'industry' => 'food-retail', 'client_name' => 'Self-initiated', 'client_url' => null, 'tile_color' => '#4A7C3F',
        'title' => 'Detox — Instagram Story Frame',
        'short_description' => 'Story frame for a juice bar: one rule, one promise, no clutter. Designed as a template the client fills every morning.',
        'demo_url' => '', 'detailed_description' => '',
    ],
    [
        'slug' => 'petoo-bhau-burger', 'category' => 'graphics', 'badge' => 'SOCIAL', 'sort_order' => 160,
        'industry' => 'food-retail', 'client_name' => 'Petoo Bhau', 'client_url' => null, 'tile_color' => '#C9541B',
        'title' => 'Petoo Bhau — Burger Drop Post',
        'short_description' => 'Menu hero at ₹49. The burger was cut out, relit and stacked so the price tag and the product fight for attention and both win.',
        'demo_url' => '', 'detailed_description' => '',
    ],
    [
        'slug' => 'rashmika-coffee', 'category' => 'graphics', 'badge' => 'SOCIAL', 'sort_order' => 210,
        'industry' => 'food-retail', 'client_name' => "Rashmika's Coffee Shop", 'client_url' => null, 'tile_color' => '#B4731F',
        'title' => "Rashmika's Coffee Shop — Launch Square",
        'short_description' => 'Pour, splash and price in one square. A single post that had to work as the shop sign, the menu board and the first Instagram tile.',
        'demo_url' => '', 'detailed_description' => '',
    ],
    [
        'slug' => 'snubfoods-chips', 'category' => 'graphics', 'badge' => 'SOCIAL', 'sort_order' => 290,
        'industry' => 'food-retail', 'client_name' => 'Snüb Foods', 'client_url' => 'https://snubfoods.com', 'tile_color' => '#4A7C3F',
        'title' => 'Snüb Foods — Good Food, Great Mood',
        'short_description' => 'Banana chips on a banana leaf, with the type cut out of the fry itself. Part of the same brand system as the Snüb Foods POS build.',
        'demo_url' => '', 'detailed_description' => '',
    ],
    [
        'slug' => 'merienda-snacks', 'category' => 'graphics', 'badge' => 'MOTION', 'sort_order' => 150,
        'industry' => 'food-retail', 'client_name' => 'Merienda Me Snacks', 'client_url' => null, 'tile_color' => '#E8552E',
        'title' => 'Merienda Me Snacks — Five-Second Reel',
        'short_description' => 'Five seconds of snack type for a Varanasi kitchen. Kinetic text, product pop, phone number, done — built for Reels and WhatsApp status.',
        'demo_url' => '', 'detailed_description' => '',
    ],
    [
        'slug' => 'flax-protein-bar', 'category' => 'graphics', 'badge' => 'MOTION', 'sort_order' => 220,
        'industry' => 'food-retail', 'client_name' => 'Self-initiated', 'client_url' => null, 'tile_color' => '#6A4AA8',
        'title' => 'Flax Seed Protein Bar — Product Reveal',
        'short_description' => 'Starburst build, product reveal, five seconds flat. A vertical motion piece showing how a packaged product launches on social.',
        'demo_url' => '', 'detailed_description' => '',
    ],
    [
        'slug' => 'todays-menu', 'category' => 'graphics', 'badge' => 'SOCIAL', 'sort_order' => 310,
        'industry' => 'food-retail', 'client_name' => 'Self-initiated', 'client_url' => null, 'tile_color' => '#2E8B57',
        'title' => "Today's Menu — Sunday Service Story",
        'short_description' => 'Sunday service, three plates, one polaroid stack. A daily-menu story template a restaurant can update without a designer.',
        'demo_url' => '', 'detailed_description' => '',
    ],
    [
        'slug' => 'italian-pizza', 'category' => 'graphics', 'badge' => 'SOCIAL', 'sort_order' => 320,
        'industry' => 'food-retail', 'client_name' => 'Self-initiated', 'client_url' => null, 'tile_color' => '#C9541B',
        'title' => 'Italian Pizza — Menu Hero',
        'short_description' => 'Cast iron, chilli, and one thin gold rule. A menu hero built for a dark-mode Instagram feed and the same card printed on the table tent.',
        'demo_url' => '', 'detailed_description' => '',
    ],
];



$sql = 'INSERT INTO portfolios (slug, category, industry, badge, sort_order, title, client_name, client_url, tile_color, short_description, detailed_description, demo_url, username, password, image_path, gallery_images)
        VALUES (:slug, :category, :industry, :badge, :sort_order, :title, :client_name, :client_url, :tile_color, :short_description, :detailed_description, :demo_url, NULL, NULL, :image_path, NULL)
        ON DUPLICATE KEY UPDATE
            category = VALUES(category),
            industry = VALUES(industry),
            badge = VALUES(badge),
            client_name = VALUES(client_name),
            client_url = VALUES(client_url),
            tile_color = VALUES(tile_color),
            sort_order = VALUES(sort_order),
            title = VALUES(title),
            short_description = VALUES(short_description),
            detailed_description = VALUES(detailed_description),
            demo_url = VALUES(demo_url),
            image_path = VALUES(image_path)';

$stmt = $pdo->prepare($sql);
foreach ($entries as $e) {
    $stmt->execute([
        ':slug'                 => $e['slug'],
        ':category'             => $e['category'],
        ':industry'             => $e['industry'],
        ':badge'                => $e['badge'],
        ':client_name'          => $e['client_name'] ?? null,
        ':client_url'           => $e['client_url'] ?? null,
        ':tile_color'           => $e['tile_color'] ?? null,
        ':sort_order'           => $e['sort_order'],
        ':title'                => $e['title'],
        ':short_description'    => $e['short_description'],
        ':detailed_description' => $e['detailed_description'],
        ':demo_url'             => ($e['demo_url'] ?? '') !== '' ? $e['demo_url'] : null,
        ':image_path'           => $img($e['slug']),
    ]);
    $exists = $img($e['slug']) !== null;
    printf("  %-22s %s%s\n", $e['slug'], 'ok', $exists ? '' : '  (no screenshot → initials tile)');
}
// Original demo rows (erp/tms/hms) are seeded by database.sql; keep them in the row plan.
$pdo->exec("UPDATE portfolios SET sort_order = CASE slug WHEN 'erp' THEN 120 WHEN 'tms' THEN 140 WHEN 'hms' THEN 170 ELSE sort_order END WHERE slug IN ('erp','tms','hms')");
echo count($entries) . " portfolio entries upserted.\n";
