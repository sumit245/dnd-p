<?php
require __DIR__ . '/../../includes/config.php';

$page['title']       = 'Industry Management Systems — HMS, Hotel PMS, TMS & Finance Software | Dashandots';
$page['description'] = 'Custom Hospital Management (HMS), Hotel PMS, Transport (TMS) and Finance software for Indian enterprises. Industry-grade systems built for your sector.';
$page['canonical']   = SITE_URL . '/services/industry-systems/';
$page['og_title']    = 'Industry Management Systems | Dashandots Technology';
$page['og_desc']     = $page['description'];

require __DIR__ . '/../../includes/head.php';
require __DIR__ . '/../../includes/header.php';
?>

<main id="main-content">
  <div class="svc-page">

    <!-- HERO -->
    <div class="svc-hero">
      <p class="page-label">Industry Management Systems</p>
      <h1>Vertical Software Built for Your Industry — Not Adapted from a Generic Template</h1>
      <p class="lead">We build purpose-specific management platforms for hospitals, hotels, logistics operators, and financial services — systems that understand your industry's regulations, workflows, and reporting needs from the ground up.</p>
      <div class="hero-actions">
        <a href="<?= BASE_PATH ?>/#contact" class="btn btn-primary" data-track="cta" data-cta-location="industry-hero">Get My Free Project Estimate</a>
        <a href="<?= BASE_PATH ?>/#portfolio" class="btn btn-outline" data-track="cta" data-cta-location="industry-hero">View Live Demos</a>
      </div>
    </div>

    <!-- INTRO -->
    <h2>Why Off-the-Shelf Industry Software Falls Short</h2>
    <p class="svc-body-text">Packaged HMS, PMS, or TMS solutions come with years of technical debt, licence fees that scale with your headcount, and customisation locked behind expensive consulting contracts. We build systems that are yours — designed around how your staff actually works, integrated with your existing tools, and owned by you with no ongoing licence.</p>

    <div class="svc-feature-grid">
      <div class="svc-feature-card">
        <h3>No Per-User Licence</h3>
        <p>A one-time development investment that you own permanently. Add 50 more staff without a cost increase. That's what ownership looks like.</p>
      </div>
      <div class="svc-feature-card">
        <h3>Compliance Built In</h3>
        <p>NABH/JCI for hospitals. GST &amp; TDS for finance. MoRTH for logistics. Regulatory requirements are part of the spec, not an afterthought.</p>
      </div>
      <div class="svc-feature-card">
        <h3>Integrates with What You Have</h3>
        <p>Lab equipment, biometrics, payment terminals, third-party APIs — we write the connectors so the system speaks every device and service in your ecosystem.</p>
      </div>
      <div class="svc-feature-card">
        <h3>Role-Based for Every Staff Level</h3>
        <p>From ground-level operators to department heads and C-suite, every role sees exactly what they need — nothing more, nothing less.</p>
      </div>
    </div>

    <!-- HMS -->
    <h2>Hospital Management System (HMS)</h2>
    <p class="svc-body-text">Our HMS covers the complete patient journey — from OPD registration to discharge summary — with modules designed to reduce manual paperwork, speed up billing, and give management real-time visibility across departments.</p>
    <ul class="svc-includes">
      <li>Patient registration &amp; OPD/IPD management</li>
      <li>Doctor scheduling &amp; appointment booking (online + in-person)</li>
      <li>EMR / EHR with customisable templates per speciality</li>
      <li>Pharmacy &amp; drug inventory management</li>
      <li>Lab &amp; radiology order management with report delivery</li>
      <li>Insurance &amp; TPA claim processing</li>
      <li>Billing, receipt &amp; GST-compliant invoice generation</li>
      <li>Nurse station workflows &amp; bed management</li>
      <li>OT scheduling &amp; anaesthesia records</li>
      <li>Blood bank module</li>
      <li>NABH documentation support</li>
      <li>MIS reports for hospital management</li>
    </ul>

    <div class="svc-cta-strip">
      <p class="page-label">Vertical proof</p>
      <h2>Review HMS, TMS, and ERP-style demos before you enquire.</h2>
      <p>Use the demos to compare modules, dashboard style, and workflow depth. Then send us your current process and we will suggest the first implementation phase.</p>
      <div class="hero-actions" style="justify-content:center; margin-top:24px">
        <a href="<?= BASE_PATH ?>/demo/view.php?slug=hms" class="btn btn-primary" target="_blank" rel="noopener" data-track="demo" data-demo-slug="hms">HMS Demo</a>
        <a href="<?= BASE_PATH ?>/demo/view.php?slug=tms" class="btn btn-outline" target="_blank" rel="noopener" data-track="demo" data-demo-slug="tms">TMS Demo</a>
        <a href="<?= BASE_PATH ?>/demo/view.php?slug=erp" class="btn btn-outline" target="_blank" rel="noopener" data-track="demo" data-demo-slug="erp">ERP Demo</a>
      </div>
    </div>

    <!-- HOTEL PMS -->
    <h2>Hotel Property Management System (PMS)</h2>
    <p class="svc-body-text">From boutique properties to mid-size chains, our hotel PMS centralises reservations, housekeeping, billing, and OTA channel management in one clean interface accessible on any device.</p>
    <ul class="svc-includes">
      <li>Reservation &amp; room inventory management</li>
      <li>Online booking engine (direct website bookings)</li>
      <li>OTA channel manager (MakeMyTrip, Booking.com, Airbnb sync)</li>
      <li>Check-in / check-out with ID verification</li>
      <li>Housekeeping task assignment &amp; status tracking</li>
      <li>Billing, folios &amp; GST-compliant invoices</li>
      <li>Restaurant &amp; room service POS integration</li>
      <li>Revenue management &amp; dynamic pricing tools</li>
      <li>Guest communication (WhatsApp, email, SMS)</li>
      <li>Maintenance request tracking</li>
      <li>Management dashboard with occupancy &amp; revenue KPIs</li>
    </ul>

    <!-- TMS -->
    <h2>Transport Management System (TMS)</h2>
    <p class="svc-body-text">Our TMS gives fleet operators and logistics companies end-to-end visibility — from order creation to final delivery — while automating the paperwork that slows operations down.</p>
    <ul class="svc-includes">
      <li>Trip planning &amp; route optimisation</li>
      <li>GPS-based live vehicle tracking</li>
      <li>Driver app (trip acceptance, POD capture, expense reporting)</li>
      <li>Load management &amp; freight billing</li>
      <li>Vehicle maintenance &amp; service scheduling</li>
      <li>Fuel &amp; expense tracking per vehicle</li>
      <li>Customer consignment tracking portal</li>
      <li>E-way bill &amp; lorry receipt generation</li>
      <li>Driver performance analytics</li>
      <li>Fleet compliance &amp; document expiry alerts</li>
    </ul>

    <!-- FINANCE -->
    <h2>Finance &amp; Accounting Software</h2>
    <p class="svc-body-text">Custom accounting and financial management systems built for businesses that have outgrown Tally or need deeper integration with their operational software.</p>
    <ul class="svc-includes">
      <li>General ledger, accounts payable &amp; receivable</li>
      <li>GST filing preparation (GSTR-1, GSTR-3B)</li>
      <li>TDS calculation &amp; challan generation</li>
      <li>Purchase order &amp; vendor payment workflows</li>
      <li>Petty cash &amp; expense management</li>
      <li>Budget vs. actuals reporting</li>
      <li>Multi-branch &amp; multi-entity consolidation</li>
      <li>Automated bank reconciliation</li>
      <li>Payroll integration</li>
    </ul>

    <!-- CTA -->
    <div class="svc-cta-strip">
      <p class="page-label">Purpose-Built for Your Industry</p>
      <h2>Ready for a System That Actually Fits?</h2>
      <p>Share your current workflows and pain points. We'll show you how a purpose-built system compares against the generic software you're fighting with today.</p>
      <div class="hero-actions" style="justify-content:center; margin-top:24px">
        <a href="<?= BASE_PATH ?>/#contact" class="btn btn-primary" data-track="cta" data-cta-location="industry-final">Get My Free Project Estimate</a>
        <a href="<?= BASE_PATH ?>/#ai-brief" class="btn btn-outline" data-track="cta" data-cta-location="industry-final">Get Rough Cost &amp; Timeline</a>
      </div>
    </div>

  </div>
</main>

<?php require __DIR__ . '/../../includes/footer.php'; ?>
<?php require __DIR__ . '/../../includes/scripts.php'; ?>
