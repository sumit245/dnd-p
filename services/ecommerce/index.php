<?php
require __DIR__ . '/../../includes/config.php';

$page['title']       = 'E-commerce & Portal Development Services in India | Dashandots';
$page['description'] = 'Custom B2B & B2C e-commerce development — multi-vendor marketplaces, dealer portals and self-service platforms. Built on Laravel, React & WooCommerce.';
$page['canonical']   = SITE_URL . '/services/ecommerce/';
$page['og_title']    = 'E-commerce & Portal Development | Dashandots Technology';
$page['og_desc']     = $page['description'];

require __DIR__ . '/../../includes/head.php';
require __DIR__ . '/../../includes/header.php';
?>

<main id="main-content">
  <div class="svc-page">

    <!-- HERO -->
    <div class="svc-hero">
      <p class="page-label">E-commerce &amp; Portal Development</p>
      <h1>E-commerce &amp; customer portals that convert and retain</h1>
      <p class="lead">We build high-performance online stores, B2B ordering portals, and multi-vendor marketplaces designed to maximise revenue, reduce operational overhead, and keep customers coming back.</p>
      <div class="hero-actions">
        <a href="<?= BASE_PATH ?>/#ai-brief" class="btn btn-primary" data-track="cta" data-cta-location="ecommerce-hero">Get Instant Estimate</a>
        <a href="<?= BASE_PATH ?>/#contact" class="btn btn-outline" data-track="cta" data-cta-location="ecommerce-hero">Discuss Your Store</a>
      </div>
    </div>

    <!-- WHY CUSTOM E-COM -->
    <h2>Beyond template stores</h2>
    <p class="svc-body-text">Shopify and WooCommerce templates get you live fast — but they hit a ceiling. Custom payment flows, dealer-specific pricing, bulk ordering logic, GST-compliant invoicing, and ERP integration all require custom development. We build stores that handle your actual business rules, not a generic retailer's.</p>

    <div class="svc-feature-grid">
      <div class="svc-feature-card">
        <h3>Customer-specific pricing</h3>
        <p>B2B portals with dealer tiers, customer-group discounts, credit limits, and personalised product catalogues — hidden from competitors and the public.</p>
      </div>
      <div class="svc-feature-card">
        <h3>GST-compliant invoicing</h3>
        <p>Automated CGST/SGST/IGST calculation, HSN code mapping, e-invoice generation, and GSTR-1 export — built for India's tax compliance requirements.</p>
      </div>
      <div class="svc-feature-card">
        <h3>ERP &amp; inventory sync</h3>
        <p>Real-time stock sync with your warehouse or ERP. No overselling, no manual updates, no customer disappointment on delivery timelines.</p>
      </div>
      <div class="svc-feature-card">
        <h3>Multi-vendor marketplace</h3>
        <p>Seller onboarding, commission management, payout splits, and dispute resolution — the infrastructure to run a platform business.</p>
      </div>
      <div class="svc-feature-card">
        <h3>Conversion-optimised UX</h3>
        <p>Persistent cart, one-click reorder, smart search with filters, guest checkout, and mobile-first design — reducing drop-offs at every stage.</p>
      </div>
      <div class="svc-feature-card">
        <h3>Payment gateway ready</h3>
        <p>Razorpay, PayU, CCAvenue, Stripe, UPI, COD, credit terms — all integrated and tested before go-live, not after.</p>
      </div>
    </div>

    <!-- WHAT WE BUILD -->
    <h2>Platforms we build</h2>
    <ul class="svc-includes">
      <li>B2C online stores (fashion, FMCG, electronics, D2C brands)</li>
      <li>B2B dealer &amp; distributor portals</li>
      <li>Multi-vendor marketplaces</li>
      <li>Subscription &amp; recurring billing platforms</li>
      <li>Wholesale &amp; bulk ordering portals</li>
      <li>Product configurators (spec-to-order, custom printing)</li>
      <li>Customer self-service portals (orders, returns, invoices)</li>
      <li>Vendor/supplier onboarding portals</li>
      <li>Auction &amp; reverse auction platforms</li>
      <li>WooCommerce customisation &amp; migration</li>
      <li>Headless commerce (Next.js frontend + custom API)</li>
      <li>Mobile shopping apps (iOS &amp; Android)</li>
    </ul>

    <div class="svc-cta-strip">
      <p class="page-label">For B2B and operations-heavy commerce</p>
      <h2>Most portal enquiries start with pricing, ordering, inventory, and invoice pain.</h2>
      <p>If repeat ordering and customer support depend on manual coordination, we can scope a self-service portal that connects products, stock, customer pricing, order status, and billing.</p>
      <div class="hero-actions" style="justify-content:center; margin-top:24px">
        <a href="<?= BASE_PATH ?>/#ai-brief" class="btn btn-primary" data-track="cta" data-cta-location="ecommerce-mid">Get Instant Estimate</a>
        <a href="<?= BASE_PATH ?>/#contact" class="btn btn-outline" data-track="cta" data-cta-location="ecommerce-mid">Build a Dealer Portal</a>
      </div>
    </div>

    <!-- KEY FEATURES -->
    <h2>Features we commonly implement</h2>
    <div class="svc-feature-grid">
      <div class="svc-feature-card">
        <h3>Advanced search &amp; filters</h3>
        <p>Elasticsearch-powered product search with category, price, brand, and attribute filters. Autocomplete, spell-correction, and synonym matching included.</p>
      </div>
      <div class="svc-feature-card">
        <h3>Loyalty &amp; rewards</h3>
        <p>Points programmes, referral systems, coupon engines, and cashback mechanisms to increase repeat purchases and LTV.</p>
      </div>
      <div class="svc-feature-card">
        <h3>Analytics dashboard</h3>
        <p>Real-time sales reporting, funnel visualisation, abandoned cart tracking, and cohort analysis — all in one internal dashboard.</p>
      </div>
      <div class="svc-feature-card">
        <h3>Logistics integration</h3>
        <p>Shiprocket, Delhivery, FedEx, Blue Dart, and custom courier APIs for automated label printing, tracking updates, and NDR management.</p>
      </div>
    </div>

    <!-- TECH STACK -->
    <h2>Technology we use</h2>
    <ul class="svc-includes">
      <li>Laravel + React (full custom builds with maximum flexibility)</li>
      <li>WooCommerce + custom plugins (for businesses with existing WordPress sites)</li>
      <li>Next.js headless commerce (for performance-critical storefronts)</li>
      <li>MySQL + Redis (transactional data + session/cache layer)</li>
      <li>Elasticsearch for product search at scale</li>
      <li>AWS S3 + CloudFront for image and media delivery</li>
      <li>Razorpay, PayU, Stripe, CCAvenue payment integrations</li>
    </ul>

    <!-- CTA -->
    <div class="svc-cta-strip">
      <p class="page-label">Ready to sell smarter?</p>
      <h2>Let's build your store or portal</h2>
      <p>Tell us about your products, your customers, and your current bottlenecks. We'll design a commerce solution that fits your business model precisely.</p>
      <div class="hero-actions" style="justify-content:center; margin-top:24px">
        <a href="<?= BASE_PATH ?>/#contact" class="btn btn-primary" data-track="cta" data-cta-location="ecommerce-final">Get My Free Project Estimate</a>
        <a href="<?= BASE_PATH ?>/#ai-brief" class="btn btn-outline" data-track="cta" data-cta-location="ecommerce-final">Get Instant Estimate</a>
      </div>
    </div>

  </div>
</main>

<?php require __DIR__ . '/../../includes/footer.php'; ?>
<?php require __DIR__ . '/../../includes/scripts.php'; ?>
