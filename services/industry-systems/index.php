<?php
require __DIR__ . '/../../includes/config.php';

$page['title']       = 'HMS, Hotel PMS & TMS Software Development | Dashandots';
$page['description'] = 'Custom Hospital Management (HMS), Hotel PMS, Transport (TMS) and Finance software for Indian enterprises. Industry-grade systems built for your sector.';
$page['canonical']   = SITE_URL . '/services/industry-systems/';
$page['og_title']    = 'Industry Management Systems | Dashandots Technology';
$page['og_desc']     = $page['description'];
$page['keywords']    = 'hospital management system development India, hotel PMS software development, transport management system India, custom finance accounting software, industry-specific ERP development';
$page['active_nav']  = 'services';


require_once __DIR__ . '/../../includes/service-schema.php';
$serviceSchema = service_schema([
  'slug'        => 'industry-systems',
  'name'        => 'Industry-Specific Management Systems Development',
  'serviceType' => [
    'Hospital management system development',
    'Hotel property management system development',
    'Transport management system development',
    'Finance and accounting software development',
  ],
  'description' => $page['description'],
  'catalogName' => 'Industry management systems',
  'offers'      => [
    'Hospital management system (HMS) with OPD, IPD, pharmacy and billing',
    'Hotel property management system (PMS) with reservations and housekeeping',
    'Transport management system (TMS) with dispatch and fleet tracking',
    'GST-ready finance and accounting software with Tally integration',
  ],
]);

require_once __DIR__ . '/../../includes/schema-breadcrumb.php';
$page['jsonld'][] = service_schema_jsonld($serviceSchema);
$page['jsonld'][] = breadcrumb_schema_jsonld(breadcrumb_schema([
  ['name' => 'Services', 'url' => '/#services'],
  ['name' => 'Industry Systems', 'url' => '/services/industry-systems/'],
]));
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php require __DIR__ . '/../../includes/head.php'; ?>
</head>
<body>
<?php require __DIR__ . '/../../includes/header.php'; ?>

<main id="main-content">
  <div class="svc-page">

    <!-- HERO -->
    <div class="svc-hero">
      <p class="page-label">Services &rsaquo; Industry Systems</p>
      <h1>Hospital, hotel and transport management software development</h1>
      <p class="lead">Dashandots develops hospital management systems (HMS), hotel property management systems (PMS), and transport management systems (TMS). Each project starts with your staff roles, operational workflows, reporting needs and existing software.</p>
      <div class="hero-actions">
        <a href="<?= BASE_PATH ?>/#ai-brief" class="btn btn-primary" data-track="cta" data-cta-location="industry-hero">Scope Your System</a>
        <a href="<?= BASE_PATH ?>/portfolio" class="btn btn-outline" data-track="cta" data-cta-location="industry-hero">View live demos</a>
      </div>
    </div>

    <!-- INTRO -->
    <h2>When does industry-specific custom software make sense?</h2>
    <p class="svc-body-text">Custom development is an option when a standard product cannot cover important handovers, permissions or reporting without repeated manual work. Compare available products first, then document the remaining gaps. The proposal should identify which workflows are included, which systems must connect and who validates the requirements.</p>

    <div class="svc-feature-grid">
      <div class="svc-feature-card">
        <h3>No Per-User Licence</h3>
        <p>No per-user licence for the custom application. Hosting, support, third-party products and new features may add costs; ownership and handover follow the project agreement.</p>
      </div>
      <div class="svc-feature-card">
        <h3>Documented Requirements</h3>
        <p>Identify required records, approvals, access controls and reports with your operational and compliance teams. Software features alone do not establish accreditation or regulatory compliance.</p>
      </div>
      <div class="svc-feature-card">
        <h3>Integrates with What You Have</h3>
        <p>Lab equipment, biometrics, payment terminals, third-party APIs; we write the connectors so the system speaks every device and service in your ecosystem.</p>
      </div>
      <div class="svc-feature-card">
        <h3>Role-Based for Every Staff Level</h3>
        <p>From ground-level operators to department heads and C-suite, every role sees exactly what they need: nothing more, nothing less.</p>
      </div>
    </div>

    <!-- HMS -->
    <h2 id="hospital-management-system">Hospital Management System (HMS)</h2>
    <p class="svc-body-text">A hospital management system connects registration, appointments, patient records, pharmacy and billing. Outpatient department (OPD) workflows cover visits without admission; inpatient department (IPD) workflows cover admitted patients. Review the <a href="<?= BASE_PATH ?>/demo/hms">hospital management system demo</a> and its evaluation checklist, then confirm the modules needed for your facility. Our <a href="<?= BASE_PATH ?>/services/hospital-management-system/">hospital management software service</a> covers modules, cost drivers, integrations and rollout in full.</p>
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
        <a href="<?= BASE_PATH ?>/demo/hms" class="btn btn-primary" target="_blank" rel="noopener" data-track="demo" data-demo-slug="hms">Hospital Management System Demo</a>
        <a href="<?= BASE_PATH ?>/demo/tms" class="btn btn-outline" target="_blank" rel="noopener" data-track="demo" data-demo-slug="tms">TMS Demo</a>
        <a href="<?= BASE_PATH ?>/demo/erp" class="btn btn-outline" target="_blank" rel="noopener" data-track="demo" data-demo-slug="erp">ERP Demo</a>
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
    <p class="svc-body-text">Our TMS gives fleet operators and logistics companies end-to-end visibility (from order creation to final delivery) while automating the paperwork that slows operations down.</p>
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
      <p class="page-label">Purpose-built for your industry</p>
      <h2>Ready for a system that actually fits?</h2>
      <p>Share your current workflows and pain points. We'll show you how a purpose-built system compares against the generic software you're fighting with today.</p>
      <div class="hero-actions" style="justify-content:center; margin-top:24px">
        <a href="<?= BASE_PATH ?>/#contact" class="btn btn-primary" data-track="cta" data-cta-location="industry-final">Talk to Our Team</a>
        <a href="<?= BASE_PATH ?>/#ai-brief" class="btn btn-outline" data-track="cta" data-cta-location="industry-final">Scope Your Project</a>
      </div>
    </div>

  </div>
</main>

<?php require __DIR__ . '/../../includes/footer.php'; ?>
<?php require __DIR__ . '/../../includes/scripts.php'; ?>
</body>
</html>
