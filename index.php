<?php
require __DIR__ . '/includes/config.php';
require __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/portfolio-media.php';

// Fetch settings
$settings = [];
$stmt = $pdo->query('SELECT key_name, value FROM site_settings');
while ($row = $stmt->fetch()) {
  $settings[$row['key_name']] = $row['value'];
}

// Fetch portfolios
$portfoliosStmt = $pdo->query('SELECT * FROM portfolios ORDER BY created_at ASC');
$portfolios = $portfoliosStmt->fetchAll();

// Homepage-specific SEO: override title and description for maximum keyword coverage
$page['title'] = 'Custom ERP & CRM Software Developer in India | Dashandots';
$page['preload_images'] = ['/assets/img/hero-corporate-bg.webp'];
$heroTitle = trim($settings['hero_title'] ?? '');
$heroDescription = trim($settings['hero_description'] ?? '');
if ($heroTitle === '') {
  $heroTitle = 'Custom ERP & CRM for Growing SMEs';
}
if ($heroDescription === '') {
  $heroDescription = 'Dashandots builds ERP, CRM, dashboard, portal, and mobile platforms for growing businesses — for clearer operations and dependable long-term support.';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php include __DIR__ . '/includes/head.php'; ?>

  <!-- Schema.org Structured Data (homepage-specific) -->
  <script type="application/ld+json">
{
  "@context":"https://schema.org",
  "@graph":[
    {
      "@type":"Organization",
      "@id":"https://dashandots.com/#organization",
      "name":"Dashandots Technology",
      "url":"https://dashandots.com",
      "logo":"<?= SITE_LOGO_URL ?>",
      "description":"Full-cycle software development and technology consulting. Specialising in ERP, CRM, TMS, HMS, Hotel PMS, web and mobile applications for SMEs and enterprises.",
      <?php if (defined('SITE_EMAIL') && SITE_EMAIL !== ''): ?>"email":"<?= htmlspecialchars(SITE_EMAIL, ENT_QUOTES, 'UTF-8') ?>",<?php endif; ?>
      "address":{"@type":"PostalAddress","addressLocality":"Gurugram","addressRegion":"Delhi NCR","addressCountry":"IN"},
      "areaServed":"Worldwide",
      "knowsAbout":["ERP Software","CRM Software","Transport Management System","Hospital Management System","Mobile App Development","Web Development","IoT"]
    },
    {
      "@type":"WebSite",
      "@id":"https://dashandots.com/#website",
      "url":"https://dashandots.com",
      "name":"Dashandots Technology",
      "publisher":{"@id":"https://dashandots.com/#organization"}
    },
    {
      "@type":"FAQPage",
      "mainEntity":[
        {"@type":"Question","name":"Do you work with small and mid-size businesses?","acceptedAnswer":{"@type":"Answer","text":"Yes. Our delivery model is optimised for SMEs and growing companies, while still maintaining enterprise-grade standards in architecture, security and code quality."}},
        {"@type":"Question","name":"How do you estimate cost and timeline?","acceptedAnswer":{"@type":"Answer","text":"We start with a structured discovery of your requirements, then provide a detailed estimate before any commitment. Get an indicative range using our project brief tool."}},
        {"@type":"Question","name":"Can you integrate with Tally or legacy ERP?","acceptedAnswer":{"@type":"Answer","text":"In most cases, yes. We have experience integrating with accounting tools, payment gateways, logistics APIs and legacy systems via custom connectors and APIs."}},
        {"@type":"Question","name":"What happens after the project goes live?","acceptedAnswer":{"@type":"Answer","text":"We offer structured support and AMC options covering monitoring, bug fixes, enhancements and ongoing feature development."}},
        {"@type":"Question","name":"What engagement models do you offer?","acceptedAnswer":{"@type":"Answer","text":"We offer three models: fixed-price projects with a clear scope and deliverables; time & material for evolving products where requirements change; and dedicated squads as an extension of your own team."}},
        {"@type":"Question","name":"Are you a software development company in Delhi, India?","acceptedAnswer":{"@type":"Answer","text":"Yes. Dashandots Technology is based in Gurugram, Delhi NCR. We are a full-cycle custom software development company serving clients across Delhi, the rest of India, and globally. Our core services include ERP development, CRM systems, mobile app development, hotel management software (PMS), hospital management software (HMS), and transport management systems (TMS)."}},
        {"@type":"Question","name":"Do you build hotel management software and property management systems (PMS)?","acceptedAnswer":{"@type":"Answer","text":"Yes. Our Hotel PMS is a complete hotel management system covering reservations, front-office, housekeeping, POS, and guest management. We build custom hotel management software tailored to boutique hotels, hotel chains, and resorts across India — fully integrated with billing, GST, and channel management."}},
        {"@type":"Question","name":"Can you develop custom project management software?","acceptedAnswer":{"@type":"Answer","text":"Absolutely. We build custom project management software and task-tracking platforms as standalone tools or integrated modules within your ERP or CRM. Whether you need agile sprint boards, milestone tracking, resource planning, or client-facing project portals — we design and develop the solution from scratch to match your exact workflow."}}
      ]
    },
    {
      "@type":"ProfessionalService",
      "@id":"https://dashandots.com/#service",
      "name":"Dashandots Technology",
      "description":"Software development agency specializing in custom ERP, CRM, TMS, HMS, and mobile applications for SMEs in India and globally.",
      "url":"https://dashandots.com",
      <?php if (defined('SITE_PHONE') && SITE_PHONE !== ''): ?>"telephone":"<?= htmlspecialchars(SITE_PHONE, ENT_QUOTES, 'UTF-8') ?>",<?php endif; ?>
      <?php if (defined('SITE_EMAIL') && SITE_EMAIL !== ''): ?>"email":"<?= htmlspecialchars(SITE_EMAIL, ENT_QUOTES, 'UTF-8') ?>",<?php endif; ?>
      "image":"<?= SITE_LOGO_URL ?>",
      "address":{"@type":"PostalAddress","addressLocality":"Gurugram","addressRegion":"Delhi NCR","addressCountry":"IN"},
      "priceRange":"$$",
      "areaServed":"Worldwide",
      "makesOffer":[
        {"@type":"Offer","itemOffered":{"@type":"Service","name":"ERP Development"}},
        {"@type":"Offer","itemOffered":{"@type":"Service","name":"CRM Development"}},
        {"@type":"Offer","itemOffered":{"@type":"Service","name":"Mobile App Development"}}
      ]
    }
  ]
}
</script>
</head>

<body>

  <?php include __DIR__ . '/includes/header.php'; ?>

  <main id="main-content" tabindex="-1">
    <!-- ═══════════════════════════════ HERO ═══════════════════════════════ -->
    <section id="home" aria-labelledby="hero-heading">
      <div class="container">
        <div class="hero-grid">
          <div class="hero-content reveal visible">
            <div class="hero-tag"><span aria-hidden="true"></span>Dashboards · Mobile Apps · Custom Software
            </div>
            <h1 id="hero-heading" class="hero-h1"><?php echo htmlspecialchars($heroTitle); ?></h1>
            <p class="hero-desc"><?php echo htmlspecialchars($heroDescription); ?></p>
            <div class="hero-ctas">
              <a href="#ai-brief" class="btn btn-primary" data-track="cta" data-cta-location="hero">Get Instant
                Estimate</a>
              <a href="#portfolio" class="btn btn-outline" data-track="cta" data-cta-location="hero">See Our Work</a>
            </div>
            <ul class="hero-meta">
              <li class="hero-meta-item">150+ Clients Served</li>
              <li class="hero-meta-item">450+ Projects Delivered</li>
              <li class="hero-meta-item">5+ Years Experience</li>
            </ul>
          </div>
          <!-- Pure CSS/SVG animated diagram — replaces broken THREE.js -->
          <div class="hero-diagram reveal reveal-delay-2 visible" aria-hidden="true">
            <svg viewBox="0 0 400 380" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
              <defs>
                <style>
                  .orbit-line {
                    stroke: #E0DED8;
                    stroke-width: 1;
                    fill: none;
                    stroke-dasharray: 4 4;
                    animation: dash 2s linear infinite
                  }

                  @keyframes dash {
                    to {
                      stroke-dashoffset: -20
                    }
                  }

                  .node-pill {
                    filter: drop-shadow(0 2px 6px rgba(0, 0, 0, .08))
                  }

                  .center-bg {
                    fill: #FEF2F4;
                    animation: cpulse 3s ease-in-out infinite
                  }

                  @keyframes cpulse {

                    0%,
                    100% {
                      r: 52
                    }

                    50% {
                      r: 56
                    }
                  }

                  .n1 {
                    animation: fn1 5s ease-in-out infinite
                  }

                  .n2 {
                    animation: fn2 5s ease-in-out infinite .5s
                  }

                  .n3 {
                    animation: fn3 5s ease-in-out infinite 1s
                  }

                  .n4 {
                    animation: fn4 5s ease-in-out infinite 1.5s
                  }

                  .n5 {
                    animation: fn5 5s ease-in-out infinite 2s
                  }

                  @keyframes fn1 {

                    0%,
                    100% {
                      transform: translate(0, 0)
                    }

                    50% {
                      transform: translate(-4px, -8px)
                    }
                  }

                  @keyframes fn2 {

                    0%,
                    100% {
                      transform: translate(0, 0)
                    }

                    50% {
                      transform: translate(4px, -6px)
                    }
                  }

                  @keyframes fn3 {

                    0%,
                    100% {
                      transform: translate(0, 0)
                    }

                    50% {
                      transform: translate(-5px, 6px)
                    }
                  }

                  @keyframes fn4 {

                    0%,
                    100% {
                      transform: translate(0, 0)
                    }

                    50% {
                      transform: translate(5px, 7px)
                    }
                  }

                  @keyframes fn5 {

                    0%,
                    100% {
                      transform: translate(0, 0)
                    }

                    50% {
                      transform: translate(0px, -9px)
                    }
                  }
                </style>
              </defs>
              <!-- connecting lines -->
              <line class="orbit-line" x1="200" y1="190" x2="80" y2="90" />
              <line class="orbit-line" x1="200" y1="190" x2="330" y2="80" />
              <line class="orbit-line" x1="200" y1="190" x2="55" y2="290" />
              <line class="orbit-line" x1="200" y1="190" x2="355" y2="295" />
              <line class="orbit-line" x1="200" y1="190" x2="200" y2="50" />
              <!-- center circle -->
              <circle class="center-bg" cx="200" cy="190" r="52" />
              <circle cx="200" cy="190" r="52" fill="none" stroke="#C8293E" stroke-width="1.5" stroke-dasharray="3 3" />
              <text x="200" y="185" font-size="11" font-weight="700" text-anchor="middle" fill="#C8293E"
                font-family="Inter,Arial,sans-serif" letter-spacing=".06em">WE</text>
              <text x="200" y="200" font-size="11" font-weight="700" text-anchor="middle" fill="#C8293E"
                font-family="Inter,Arial,sans-serif" letter-spacing=".06em">BUILD</text>
              <!-- satellite nodes -->
              <g class="n1 node-pill">
                <rect x="28" y="66" width="104" height="32" rx="16" fill="white" stroke="#E8E6E0" stroke-width="1" />
                <text x="80" y="86" font-size="11" font-weight="600" text-anchor="middle" fill="#333"
                  font-family="Inter,Arial,sans-serif">Websites</text>
              </g>
              <g class="n2 node-pill">
                <rect x="278" y="56" width="92" height="32" rx="16" fill="white" stroke="#E8E6E0" stroke-width="1" />
                <text x="324" y="76" font-size="11" font-weight="600" text-anchor="middle" fill="#333"
                  font-family="Inter,Arial,sans-serif">Mobile Apps</text>
              </g>
              <g class="n3 node-pill">
                <rect x="18" y="272" width="110" height="32" rx="16" fill="white" stroke="#E8E6E0" stroke-width="1" />
                <text x="73" y="292" font-size="11" font-weight="600" text-anchor="middle" fill="#333"
                  font-family="Inter,Arial,sans-serif">IoT &amp; Embedded</text>
              </g>
              <g class="n4 node-pill">
                <rect x="278" y="278" width="110" height="32" rx="16" fill="white" stroke="#E8E6E0" stroke-width="1" />
                <text x="333" y="298" font-size="11" font-weight="600" text-anchor="middle" fill="#333"
                  font-family="Inter,Arial,sans-serif">Analytics &amp; AI</text>
              </g>
              <g class="n5 node-pill">
                <rect x="148" y="28" width="104" height="32" rx="16" fill="white" stroke="#E8E6E0" stroke-width="1" />
                <text x="200" y="48" font-size="11" font-weight="600" text-anchor="middle" fill="#333"
                  font-family="Inter,Arial,sans-serif">Dashboards</text>
              </g>
            </svg>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══════════════════════════════ TRUST BAR ═══════════════════════════════ -->
    <!-- TODO: Replace contents same repetitive contents look forced -->
    <div class="trust-bar" role="region" aria-label="Company highlights">
      <div class="container">
        <div class="trust-inner">
          <span class="trust-item"><span class="trust-dot" aria-hidden="true"></span>150+ Clients Served</span>
          <span class="trust-item"><span class="trust-dot" aria-hidden="true"></span>450+ Projects Delivered</span>
          <span class="trust-item"><span class="trust-dot" aria-hidden="true"></span>ERP · CRM · TMS · HMS ·
            Dashboards</span>
          <span class="trust-item"><span class="trust-dot" aria-hidden="true"></span>Serving
            Globally</span>
          <span class="trust-item"><span class="trust-dot" aria-hidden="true"></span>Open to Long-Term Support</span>
        </div>
      </div>
    </div>

    <section class="estimate-jump" aria-labelledby="estimate-jump-heading">
      <div class="container">
        <div class="estimate-jump-inner reveal">
          <div>
            <p class="section-label">Not ready to call?</p>
            <h2 id="estimate-jump-heading">Find what your project needs.</h2>
            <p>Budget uncertainty is one of the most common reasons software projects stall before they even start.
              Answer five questions and get a realistic budget range, delivery timeline, and a shareable project
              brief — all in under two minutes, no commitments needed.</p>
          </div>
          <a href="#ai-brief" class="btn btn-primary" data-track="cta" data-cta-location="estimate-jump">Get Instant
            Estimate</a>
        </div>
      </div>
    </section>

    <!-- ═══════════════════════════════ ABOUT ═══════════════════════════════ -->
    <section id="about" aria-labelledby="about-heading">
      <div class="container">
        <div class="about-grid">
          <div class="reveal">
            <p class="section-label">About us</p>
            <h2 id="about-heading" class="section-title">We build for owners who don't fit in a template.</h2>
            <p class="section-sub">
              <?php echo nl2br(htmlspecialchars($settings['about_us_text'] ?? 'Dashandots Technology is an end-to-end software development and technology consulting company based in India.')); ?>
            </p>
            <div class="about-cards">
              <div class="about-card">
                <h3>Our Mission</h3>
                <p>To simplify complex business processes using technology and make well-engineered software
                  accessible to SMEs.</p>
              </div>
              <div class="about-card">
                <h3>Our Vision</h3>
                <p>To be the most trusted technology partner for businesses who want long‑term digital platforms
                  that keep paying back after launch.</p>
              </div>
            </div>
            <div class="about-stat-row">
              <div class="about-stat">
                <div class="num">450+</div>
                <div class="label">Projects Delivered</div>
              </div>
              <div class="about-stat">
                <div class="num">150+</div>
                <div class="label">Clients Served</div>
              </div>
              <div class="about-stat">
                <div class="num">5+</div>
                <div class="label">Years Experience</div>
              </div>
            </div>
            <?php if (defined('SITE_FOUNDER_NAME') && SITE_FOUNDER_NAME !== ''): ?>
              <div class="founder-card">
                <p class="section-label">Founder-led discovery</p>
                <h3><?= htmlspecialchars(SITE_FOUNDER_NAME) ?></h3>
                <p><?= htmlspecialchars(SITE_FOUNDER_TITLE) ?>. High-intent enquiries can start with a founder-led
                  workflow review before detailed scoping.</p>
                <?php if (defined('SITE_FOUNDER_LINKEDIN') && SITE_FOUNDER_LINKEDIN !== ''): ?>
                  <a href="<?= htmlspecialchars(SITE_FOUNDER_LINKEDIN, ENT_QUOTES, 'UTF-8') ?>" target="_blank"
                    rel="noopener">View LinkedIn profile &rarr;</a>
                <?php endif; ?>
              </div>
            <?php endif; ?>
          </div>
          <div class="about-right reveal reveal-delay-1">
            <div class="diff-item">
              <div class="diff-icon"><svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" fill="none"
                  stroke="#C8293E" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M8 12.5 L5.5 15 C3.5 17 1 14.5 3 12.5 L6 9.5" />
                  <path d="M12 7.5 L14.5 5 C16.5 3 19 5.5 17 7.5 L14 10.5" />
                  <path d="M7.5 12.5 L12.5 7.5" />
                </svg></div>
              <div>
                <h3>End‑to‑end capabilities</h3>
                <p>ERP, CRM, dashboards, portals, mobile apps, HMS, TMS, and hotel PMS under one practical delivery
                  team.</p>
              </div>
            </div>
            <div class="diff-item">
              <div class="diff-icon"><svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" fill="none"
                  stroke="#C8293E" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M12 2 L5 11 H10.5 L8 18 L15 9 H9.5 Z" fill="rgba(200,41,62,.15)" />
                </svg></div>
              <div>
                <h3>Enterprise process, SME speed</h3>
                <p>Formal, structured delivery with SME‑friendly timelines and commercial models.</p>
              </div>
            </div>
            <div class="diff-item">
              <div class="diff-icon"><svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" fill="none"
                  stroke="#C8293E" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                  <rect x="4" y="1" width="12" height="18" rx="2.5" />
                  <circle cx="10" cy="16" r="1" fill="#C8293E" stroke="none" />
                  <path d="M8 3.5 H12" />
                </svg></div>
              <div>
                <h3>Mobile‑first by default</h3>
                <p>Fast, mobile‑first experiences with elegant, minimal visual language across every product.</p>
              </div>
            </div>
            <div class="diff-item">
              <div class="diff-icon"><svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" fill="none"
                  stroke="#C8293E" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                  <rect x="3" y="5" width="14" height="11" rx="2.5" />
                  <circle cx="7.5" cy="10" r="1.5" />
                  <circle cx="12.5" cy="10" r="1.5" />
                  <path d="M7.5 13 Q10 15 12.5 13" />
                  <path d="M10 5 V2.5 M8.5 2.5 H11.5" />
                  <path d="M3 9 H1 M17 9 H19" />
                </svg></div>
              <div>
                <h3>AI‑assisted presales</h3>
                <p>AI‑assisted tools for requirement capture and realistic, fast project scoping.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══════════════════════════════ SERVICES ═══════════════════════════════ -->
    <section id="services" aria-labelledby="services-heading">
      <div class="container">
        <div class="reveal">
          <p class="section-label">Services</p>
          <h2 id="services-heading" class="section-title">Build the business platform your operations actually need.
          </h2>
          <p class="section-sub">Start with the system you need most: ERP, CRM, portal, dashboard, mobile app, HMS, TMS,
            or PMS. We scope it around the way your team already works.</p>
        </div>
        <div class="services-grid">
          <article class="service-card reveal">
            <div class="service-icon" aria-hidden="true"><svg viewBox="0 0 22 22" xmlns="http://www.w3.org/2000/svg"
                fill="none" stroke="#C8293E" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="9" />
                <path d="M11 2 C8 6 8 16 11 20 M11 2 C14 6 14 16 11 20" />
                <path d="M2 11 H20 M2.5 7 H19.5 M2.5 15 H19.5" />
              </svg></div>
            <h3>Custom Web &amp; Mobile Apps</h3>
            <p class="service-tag">React · Laravel · Node.js · Flutter · React Native</p>
            <p>High‑performance, mobile‑first applications that digitise your operations, customer journeys, and
              internal workflows.</p>
            <ul class="service-list" aria-label="Includes">
              <li>Responsive web apps &amp; portals</li>
              <li>Native‑like mobile apps (Flutter, React Native)</li>
              <li>PWAs and admin consoles</li>
            </ul>
            <a href="<?= BASE_PATH ?>/services/web-mobile-apps/" class="service-learn-more">Learn more &#x2192;</a>
          </article>
          <article class="service-card reveal reveal-delay-1">
            <div class="service-icon" aria-hidden="true"><svg viewBox="0 0 22 22" xmlns="http://www.w3.org/2000/svg"
                fill="none" stroke="#C8293E" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                <rect x="2" y="13" width="4" height="7" rx="1" />
                <rect x="9" y="8" width="4" height="12" rx="1" />
                <rect x="16" y="4" width="4" height="16" rx="1" />
                <path d="M2 21 H20" />
              </svg></div>
            <h3>ERP, CRM &amp; Business Automation</h3>
            <p class="service-tag">Custom ERP/CRM platforms tailored to your scale</p>
            <p>Centralise data, standardise workflows, and gain visibility across finance, inventory, HR, sales, and
              support.</p>
            <ul class="service-list" aria-label="Includes">
              <li>Custom ERP &amp; CRM implementations</li>
              <li>Workflow automation &amp; approvals</li>
              <li>Integrations with Tally &amp; third‑party tools</li>
            </ul>
            <a href="<?= BASE_PATH ?>/services/erp-development/" class="service-learn-more">Learn more &#x2192;</a>
          </article>
          <article class="service-card reveal reveal-delay-2">
            <div class="service-icon" aria-hidden="true"><svg viewBox="0 0 22 22" xmlns="http://www.w3.org/2000/svg"
                fill="none" stroke="#C8293E" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                <path d="M1 2 H4 L6.5 13 H17 L19 6 H6" />
                <circle cx="8.5" cy="17" r="1.8" />
                <circle cx="15.5" cy="17" r="1.8" />
              </svg></div>
            <h3>E‑commerce &amp; Portals</h3>
            <p class="service-tag">Conversion‑ready stores and portals for B2B/B2C</p>
            <p>Modern buying experiences with unified inventory, payments, and fulfilment for your customers and
              partners.</p>
            <ul class="service-list" aria-label="Includes">
              <li>B2B/B2C commerce &amp; marketplaces</li>
              <li>Customer, vendor &amp; employee portals</li>
              <li>Secure payments &amp; order tracking</li>
            </ul>
            <a href="<?= BASE_PATH ?>/services/ecommerce/" class="service-learn-more">Learn more &#x2192;</a>
          </article>
          <article class="service-card reveal">
            <div class="service-icon" aria-hidden="true"><svg viewBox="0 0 22 22" xmlns="http://www.w3.org/2000/svg"
                fill="none" stroke="#C8293E" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                <rect x="2" y="5" width="18" height="16" rx="1.5" />
                <path d="M2 11 H20" />
                <path d="M9 5 V3 H13 V5" />
                <path d="M9 8 H13 M11 6.5 V9.5" />
                <rect x="7" y="14" width="4" height="7" rx="1" />
                <rect x="12" y="14" width="3.5" height="5" rx="1" />
              </svg></div>
            <h3>Hotel, Hospital &amp; Industry Management Systems</h3>
            <p class="service-tag">HMS · Hotel PMS · TMS · Finance &amp; Accounting</p>
            <p>Configurable platforms for healthcare, hospitality, logistics, finance, and more — built around how your
              industry actually works.</p>
            <ul class="service-list" aria-label="Includes">
              <li>Hospital &amp; clinic management (HMS)</li>
              <li>Hotel &amp; property management (PMS)</li>
              <li>Transport management systems (TMS)</li>
            </ul>
            <a href="<?= BASE_PATH ?>/services/industry-systems/" class="service-learn-more">Learn more &#x2192;</a>
          </article>
          <article class="service-card reveal reveal-delay-1">
            <div class="service-icon" aria-hidden="true"><svg viewBox="0 0 22 22" xmlns="http://www.w3.org/2000/svg"
                fill="none" stroke="#C8293E" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                <rect x="4" y="4" width="14" height="14" rx="3" />
                <circle cx="8.5" cy="9" r="1.5" />
                <circle cx="13.5" cy="9" r="1.5" />
                <path d="M8.5 13 Q11 15.5 13.5 13" />
                <path d="M4 8 H1 M4 14 H1 M18 8 H21 M18 14 H21 M8 4 V1 M14 4 V1" />
              </svg></div>
            <h3>Data, Analytics &amp; AI</h3>
            <p class="service-tag">Dashboards · Forecasting · AI‑assisted workflows</p>
            <p>Turn your data into decisions with tailored dashboards, predictive models, and intelligent automation
              built into your systems.</p>
            <ul class="service-list" aria-label="Includes">
              <li>Operational analytics &amp; reporting</li>
              <li>Forecasting &amp; anomaly detection</li>
              <li>AI‑powered tools &amp; assistants</li>
            </ul>
            <a href="<?= BASE_PATH ?>/services/data-analytics/" class="service-learn-more">Learn more &#x2192;</a>
          </article>
          <article class="service-card reveal reveal-delay-2">
            <div class="service-icon" aria-hidden="true"><svg viewBox="0 0 22 22" xmlns="http://www.w3.org/2000/svg"
                fill="none" stroke="#C8293E" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                <rect x="5" y="2" width="12" height="10" rx="2" />
                <path d="M8 2 V0 M14 2 V0" />
                <path d="M5 8 C2 8 2 12 2 14 C2 17 5 18 11 18 C17 18 20 17 20 14 C20 12 20 8 17 8" />
                <circle cx="8" cy="13" r="1.2" fill="#C8293E" stroke="none" />
                <circle cx="14" cy="13" r="1.2" fill="#C8293E" stroke="none" />
                <path d="M11 18 V21" />
              </svg></div>
            <h3>IoT &amp; Embedded Software</h3>
            <p class="service-tag">MATLAB · LabVIEW · Keil · Arduino · Device‑cloud</p>
            <p>Connect devices, sensors, and backend systems with reliable firmware and IoT dashboards that scale with
              your operations.</p>
            <ul class="service-list" aria-label="Includes">
              <li>Embedded firmware &amp; control systems</li>
              <li>IoT data platforms &amp; dashboards</li>
              <li>Integrations into ERP &amp; field apps</li>
            </ul>
            <a href="<?= BASE_PATH ?>/services/iot-embedded/" class="service-learn-more">Learn more &#x2192;</a>
          </article>
        </div>
        <div class="how-we-work reveal">
          <h3 class="hww-title">How we work</h3>
          <div class="hww-steps">
            <div class="step">
              <div class="step-num">1</div>
              <div class="step-label"><strong>Discover &amp; Plan</strong>Align on goals, scope &amp; delivery roadmap
              </div>
            </div>
            <div class="step">
              <div class="step-num">2</div>
              <div class="step-label"><strong>Build &amp; Iterate</strong>Develop in sprints with regular client demos
              </div>
            </div>
            <div class="step">
              <div class="step-num">3</div>
              <div class="step-label"><strong>Deploy &amp; Support</strong>Go live, train your team &amp; support
                long‑term</div>
            </div>
          </div>
        </div>
        <div class="mid-cta reveal">
          <div>
            <h3>Want to know what this would cost for your workflow?</h3>
            <p>Generate a rough budget and timeline before booking a call.</p>
          </div>
          <a href="#ai-brief" class="btn btn-primary" data-track="cta" data-cta-location="after-services">Get Instant
            Estimate</a>
        </div>
      </div>
    </section>

    <!-- ═══════════════════════════════ INDUSTRIES ═══════════════════════════════ -->
    <section id="industries" aria-labelledby="industries-heading">
      <div class="container">
        <div class="reveal">
          <p class="section-label">Industries</p>
          <h2 id="industries-heading" class="section-title">Industry expertise that shortens your learning curve.</h2>
          <p class="section-sub">We bring ready‑to‑adapt patterns for key verticals so your team spends less time
            explaining processes and more time validating solutions.</p>
        </div>
        <div class="industries-grid">
          <article class="industry-card reveal">
            <div class="ind-icon" aria-hidden="true"><svg viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg"
                fill="none" stroke="#C8293E" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <rect x="4" y="20" width="40" height="24" rx="2" />
                <path d="M4 20 L16 12 L16 20" />
                <path d="M16 20 L28 12 L28 20" />
                <path d="M28 20 L40 12" />
                <rect x="10" y="27" width="6" height="8" rx="1" />
                <rect x="21" y="27" width="6" height="8" rx="1" />
                <rect x="32" y="27" width="6" height="10" rx="1" />
                <path d="M22 10 L22 4 M26 10 L26 4 M24 4 L24 2" />
              </svg></div>
            <h3>Manufacturing</h3>
            <p class="sub">Production, inventory, quality, assets</p>
            <div class="challenge-box">
              <div class="label">Challenge</div>
              <p>Disconnected systems, manual inventory tracking, no real‑time production visibility.</p>
            </div>
            <div class="ind-tags"><span class="ind-tag">Production planning</span><span class="ind-tag">Quality
                control</span><span class="ind-tag">Asset management</span></div>
          </article>
          <article class="industry-card reveal reveal-delay-1">
            <div class="ind-icon" aria-hidden="true"><svg viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg"
                fill="none" stroke="#C8293E" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M10 14 H38 L34 36 H14 Z" />
                <path d="M18 14 C18 9 30 9 30 14" />
                <circle cx="18" cy="20" r="1.5" fill="#C8293E" stroke="none" />
                <circle cx="30" cy="20" r="1.5" fill="#C8293E" stroke="none" />
                <path d="M16 28 Q24 34 32 28" />
                <path d="M6 8 L10 14" />
              </svg></div>
            <h3>Retail &amp; E‑commerce</h3>
            <p class="sub">Stores, warehouses, omni‑channel</p>
            <div class="challenge-box">
              <div class="label">Challenge</div>
              <p>Multi‑channel inventory sync, POS complexity, and inconsistent customer experiences.</p>
            </div>
            <div class="ind-tags"><span class="ind-tag">Omnichannel POS</span><span class="ind-tag">Inventory
                sync</span><span class="ind-tag">Analytics</span></div>
          </article>
          <article class="industry-card reveal reveal-delay-2">
            <div class="ind-icon" aria-hidden="true"><svg viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg"
                fill="none" stroke="#C8293E" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <rect x="2" y="18" width="26" height="18" rx="2" />
                <path d="M28 22 L36 22 L44 30 L44 36 L28 36 Z" />
                <circle cx="10" cy="38" r="4" />
                <circle cx="36" cy="38" r="4" />
                <path d="M2 28 L28 28" />
                <path d="M14 36 L30 36" />
                <path d="M36 22 L36 28 M40 28 L44 28" />
              </svg></div>
            <h3>Transport &amp; Logistics</h3>
            <p class="sub">Fleet, trips, routes, billing</p>
            <div class="challenge-box">
              <div class="label">Challenge</div>
              <p>Manual trip planning, route inefficiency, and slow billing cycles waste time and revenue.</p>
            </div>
            <div class="ind-tags"><span class="ind-tag">Fleet tracking</span><span class="ind-tag">Route
                optimisation</span><span class="ind-tag">Automated billing</span></div>
          </article>
          <article class="industry-card reveal reveal-delay-3">
            <div class="ind-icon" aria-hidden="true"><svg viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg"
                fill="none" stroke="#C8293E" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <rect x="6" y="10" width="36" height="34" rx="2" />
                <path d="M6 22 H42" />
                <path d="M18 10 L18 6 L30 6 L30 10" />
                <path d="M21 16 H27 M24 13 V19" />
                <rect x="12" y="28" width="8" height="16" rx="1" />
                <rect x="28" y="28" width="8" height="10" rx="1" />
              </svg></div>
            <h3>Healthcare</h3>
            <p class="sub">Hospitals, clinics, labs</p>
            <div class="challenge-box">
              <div class="label">Challenge</div>
              <p>Fragmented patient records, OPD/IPD delays, and disconnected pharmacy/lab systems.</p>
            </div>
            <div class="ind-tags"><span class="ind-tag">OPD/IPD management</span><span
                class="ind-tag">Pharmacy</span><span class="ind-tag">LIS</span></div>
          </article>
          <article class="industry-card reveal">
            <div class="ind-icon" aria-hidden="true"><svg viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg"
                fill="none" stroke="#C8293E" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <rect x="6" y="8" width="36" height="36" rx="2" />
                <path d="M6 18 H42" />
                <rect x="12" y="24" width="7" height="6" rx="1" />
                <rect x="21" y="24" width="7" height="6" rx="1" />
                <rect x="30" y="24" width="7" height="6" rx="1" />
                <rect x="12" y="34" width="7" height="10" rx="1" />
                <rect x="28" y="34" width="7" height="10" rx="1" />
                <path d="M20 44 V34 Q24 30 28 34 V44" />
                <path d="M16 8 L16 4 M24 8 L24 4 M32 8 L32 4" />
              </svg></div>
            <h3>Hospitality &amp; Travel</h3>
            <p class="sub">Hotels, resorts, tours</p>
            <div class="challenge-box">
              <div class="label">Challenge</div>
              <p>Overbooking, disconnected front‑office and housekeeping, and multi‑channel booking chaos.</p>
            </div>
            <div class="ind-tags"><span class="ind-tag">Reservations</span><span class="ind-tag">Housekeeping
                sync</span><span class="ind-tag">Multi‑channel</span></div>
          </article>
          <article class="industry-card reveal reveal-delay-1">
            <div class="ind-icon" aria-hidden="true"><svg viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg"
                fill="none" stroke="#C8293E" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <rect x="4" y="14" width="40" height="26" rx="3" />
                <circle cx="24" cy="27" r="7" />
                <path d="M24 22 L24 32 M20 25 Q24 22 28 25 M20 29 Q24 32 28 29" />
                <path d="M10 14 L10 8 L38 8 L38 14" />
                <circle cx="10" cy="27" r="2" fill="#C8293E" stroke="none" />
                <circle cx="38" cy="27" r="2" fill="#C8293E" stroke="none" />
              </svg></div>
            <h3>Finance &amp; Accounting</h3>
            <p class="sub">Accounting, billing, GST</p>
            <div class="challenge-box">
              <div class="label">Challenge</div>
              <p>Manual data entry, GST compliance burden, and poor integration with existing accounting tools.</p>
            </div>
            <div class="ind-tags"><span class="ind-tag">GST automation</span><span class="ind-tag">Tally
                integration</span><span class="ind-tag">Dashboards</span></div>
          </article>
          <article class="industry-card reveal reveal-delay-2">
            <div class="ind-icon" aria-hidden="true"><svg viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg"
                fill="none" stroke="#C8293E" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M24 8 L44 18 L24 28 L4 18 Z" />
                <path d="M12 22 L12 34 C12 34 16 40 24 40 C32 40 36 34 36 34 L36 22" />
                <path d="M44 18 L44 30 M44 30 L42 32 M44 30 L46 32" />
                <circle cx="44" cy="30" r="1.5" fill="#C8293E" stroke="none" />
              </svg></div>
            <h3>Education &amp; Training</h3>
            <p class="sub">LMS, portals, assessments</p>
            <div class="challenge-box">
              <div class="label">Challenge</div>
              <p>Managing student data, delivering blended learning, and automating assessments at scale.</p>
            </div>
            <div class="ind-tags"><span class="ind-tag">Learning management</span><span class="ind-tag">Student
                portals</span><span class="ind-tag">Assessments</span></div>
          </article>
          <article class="industry-card reveal reveal-delay-3">
            <div class="ind-icon" aria-hidden="true"><svg viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg"
                fill="none" stroke="#C8293E" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M24 4 C24 4 36 8 36 24 L24 38 L12 24 C12 8 24 4 24 4 Z" />
                <circle cx="24" cy="20" r="4" />
                <path d="M12 24 L6 32 L14 30 Z" />
                <path d="M36 24 L42 32 L34 30 Z" />
                <path d="M20 38 L18 44 L24 40 L30 44 L28 38" />
              </svg></div>
            <h3>Startups &amp; Products</h3>
            <p class="sub">MVPs to scale‑ups</p>
            <div class="challenge-box">
              <div class="label">Challenge</div>
              <p>Moving fast, validating quickly, and building scalable architecture without technical debt.</p>
            </div>
            <div class="ind-tags"><span class="ind-tag">Rapid MVP</span><span class="ind-tag">Scalable
                architecture</span><span class="ind-tag">Product engineering</span></div>
          </article>
        </div>
      </div>
    </section>

    <!-- ═══════════════════════════════ SOLUTIONS ═══════════════════════════════ -->
    <section id="solutions" aria-labelledby="solutions-heading">
      <div class="container">
        <div class="reveal">
          <p class="section-label">Solutions</p>
          <h2 id="solutions-heading" class="section-title">Modular management systems tailored to your business.</h2>
          <p class="section-sub">Choose from our solution accelerators for ERP, CRM, TMS, HMS, Hotel PMS, and Finance —
            each configurable to your processes and scale.</p>
        </div>
        <div class="solutions-grid">
          <article class="solution-card reveal"><span class="sol-badge">ERP</span>
            <h3>ERP Platform</h3>
            <p class="sub-text">Finance, inventory, procurement, HR</p>
            <p>A configurable ERP foundation to unify your core business functions, data, and reporting across
              departments and locations.</p>
            <div class="sol-tags"><span class="sol-tag">Finance</span><span class="sol-tag">Inventory</span><span
                class="sol-tag">Procurement</span><span class="sol-tag">HR</span></div>
          </article>
          <article class="solution-card reveal reveal-delay-1"><span class="sol-badge">CRM</span>
            <h3>CRM Platform</h3>
            <p class="sub-text">Leads, pipelines, support</p>
            <p>Manage the full customer lifecycle from first touch to long‑term retention with pipeline, ticketing, and
              communication tools.</p>
            <div class="sol-tags"><span class="sol-tag">Leads &amp; deals</span><span
                class="sol-tag">Ticketing</span><span class="sol-tag">Automation</span></div>
          </article>
          <article class="solution-card reveal reveal-delay-2"><span class="sol-badge">TMS</span>
            <h3>Transport Management</h3>
            <p class="sub-text">Fleet, trips, routes, billing</p>
            <p>Digitise dispatch, routing, tracking, and billing for logistics and transport businesses of all sizes.
            </p>
            <div class="sol-tags"><span class="sol-tag">Fleet</span><span class="sol-tag">Dispatch</span><span
                class="sol-tag">GPS tracking</span></div>
          </article>
          <article class="solution-card reveal"><span class="sol-badge">HMS</span>
            <h3>Hospital Management Software (HMS)</h3>
            <p class="sub-text">OPD, IPD, billing, pharmacy, LIS</p>
            <p>End‑to‑end hospital and clinic management with patient‑centric UX, from registration to discharge and
              billing.</p>
            <div class="sol-tags"><span class="sol-tag">OPD/IPD</span><span class="sol-tag">Pharmacy</span><span
                class="sol-tag">LIS</span></div>
          </article>
          <article class="solution-card reveal reveal-delay-1"><span class="sol-badge">PMS</span>
            <h3>Hotel Management System &amp; PMS</h3>
            <p class="sub-text">Reservations, front-office, POS</p>
            <p>Reservation, front‑office, housekeeping, and POS in one cohesive platform. Reduce overbooking and improve
              guest experience.</p>
            <div class="sol-tags"><span class="sol-tag">Reservations</span><span
                class="sol-tag">Front‑office</span><span class="sol-tag">POS</span></div>
          </article>
          <article class="solution-card reveal reveal-delay-2"><span class="sol-badge">Finance</span>
            <h3>Financial &amp; Accounting Software</h3>
            <p class="sub-text">Invoicing, ledgers, GST</p>
            <p>Accounting workflows that reflect how your finance team actually works — with GST automation and Tally
              integration.</p>
            <div class="sol-tags"><span class="sol-tag">GST</span><span class="sol-tag">Invoicing</span><span
                class="sol-tag">Tally</span></div>
          </article>
        </div>
        <div class="mid-cta reveal">
          <div>
            <h3>Not sure which system to build first?</h3>
            <p>We usually start with the workflow causing the most leakage: sales, stock, billing, dispatch, reporting,
              or follow-ups.</p>
          </div>
          <a href="#contact" class="btn btn-primary" data-track="cta" data-cta-location="after-solutions">Book Free
            Consultation</a>
        </div>
      </div>
    </section>

    <!-- ═══════════════════════════════ PORTFOLIO ═══════════════════════════════ -->
    <section id="portfolio" aria-labelledby="portfolio-heading">
      <div class="container">
        <div class="portfolio-header reveal">
          <div>
            <p class="section-label">Portfolio</p>
            <h2 id="portfolio-heading" class="section-title">Selected work &amp; solution demos.</h2>
            <p class="section-sub">A glimpse into the types of platforms we build. Reach out for a detailed walkthrough.
            </p>
          </div>
          <div class="portfolio-filters" role="group" aria-label="Filter portfolio">
            <button type="button" class="filter-btn active" data-filter="all" aria-pressed="true">All</button>
            <button type="button" class="filter-btn" data-filter="erp" aria-pressed="false">ERP/CRM</button>
            <button type="button" class="filter-btn" data-filter="tms" aria-pressed="false">TMS</button>
            <button type="button" class="filter-btn" data-filter="hms" aria-pressed="false">HMS</button>
            <button type="button" class="filter-btn" data-filter="web" aria-pressed="false">Web &amp; Mobile</button>
          </div>
        </div>
        <div class="portfolio-grid">
          <?php if (!empty($portfolios)): ?>
            <?php foreach ($portfolios as $index => $portfolio): ?>
              <?php
              $delayClass = $index > 0 ? 'reveal-delay-' . min($index, 3) : '';
              $slugUpper = strtoupper($portfolio['slug']);
              ?>
              <article class="portfolio-card reveal <?php echo $delayClass; ?>"
                data-type="<?php echo htmlspecialchars($portfolio['slug']); ?>">
                <div class="port-thumb" style="background:none; padding: 0;">
                  <span class="port-type" style="z-index:2;"><?php echo htmlspecialchars($slugUpper); ?></span>
                  <?php if (!empty($portfolio['image_path'])): ?>
                    <?php
                    echo portfolio_picture_html(
                      $portfolio['image_path'],
                      $portfolio['title'] . ' mockup',
                      [
                        'loading' => $index === 0 ? 'eager' : 'lazy',
                        'fetchpriority' => $index === 0 ? 'high' : '',
                      ]
                    );
                    ?>
                  <?php else: ?>
                    <div
                      style="width: 100%; height: 100%; background: var(--surface-2); display: flex; align-items: center; justify-content: center; color: var(--text-2);">
                      No Image</div>
                  <?php endif; ?>
                </div>
                <div class="port-body">
                  <h3><?php echo htmlspecialchars($portfolio['title']); ?></h3>
                  <p class="port-cat"><?php echo htmlspecialchars($slugUpper); ?></p>
                  <p><?php echo htmlspecialchars($portfolio['short_description']); ?></p>
                  <a href="<?= BASE_PATH ?>/demo/view.php?slug=<?php echo urlencode($portfolio['slug']); ?>"
                    class="port-demo-link" target="_blank" rel="noopener" data-track="demo"
                    data-demo-slug="<?php echo htmlspecialchars($portfolio['slug']); ?>">
                    View Demo &rarr;
                  </a>
                </div>
              </article>
            <?php endforeach; ?>
          <?php else: ?>
            <p style="text-align:center; grid-column: 1 / -1; padding: 40px; color: var(--text-2);">New portfolio updates
              coming soon.</p>
          <?php endif; ?>
        </div>
        <div class="mid-cta reveal">
          <div>
            <h3>Need an ERP, CRM, HMS, TMS, or portal like these?</h3>
            <p>Share your workflow and we will suggest the quickest useful first phase.</p>
          </div>
          <a href="#contact" class="btn btn-primary" data-track="cta" data-cta-location="after-portfolio">Build
            Something Similar</a>
        </div>
      </div>
    </section>

    <!-- ═══════════════════════════════ CASE STUDIES ═══════════════════════════════ -->
    <section id="case-studies" aria-labelledby="cs-heading">
      <div class="container">
        <div class="reveal">
          <p class="section-label">Case Studies</p>
          <h2 id="cs-heading" class="section-title">Outcomes our clients see in practice.</h2>
        </div>
        <div class="cs-grid proof-grid">
          <article class="cs-card reveal proof-card" data-track="proof-card" data-proof-type="tms">
            <p class="cs-meta">TMS · Logistics &amp; Transport</p>
            <h3>Faster dispatch planning for transport teams</h3>
            <p><strong>Problem:</strong> manual trip planning and billing delays. <strong>Solution:</strong> TMS with
              trips, route visibility, POD capture, and billing workflows. <strong>Result:</strong> dispatch work moves
              from scattered calls and sheets into one operational dashboard.</p>
            <a href="<?= BASE_PATH ?>/demo/view.php?slug=tms" class="proof-link" target="_blank" rel="noopener"
              data-track="demo" data-demo-slug="tms">View TMS proof &rarr;</a>
          </article>
          <article class="cs-card reveal reveal-delay-1 proof-card" data-track="proof-card" data-proof-type="hms">
            <p class="cs-meta">HMS · Healthcare</p>
            <h3>Cleaner patient, billing, pharmacy, and appointment flow</h3>
            <p><strong>Problem:</strong> fragmented OPD/IPD records and slow billing. <strong>Solution:</strong> HMS
              modules for registration, scheduling, billing, pharmacy, and reports. <strong>Result:</strong> staff work
              from a shared patient journey instead of disconnected registers.</p>
            <a href="<?= BASE_PATH ?>/demo/view.php?slug=hms" class="proof-link" target="_blank" rel="noopener"
              data-track="demo" data-demo-slug="hms">View HMS proof &rarr;</a>
          </article>
          <article class="cs-card reveal reveal-delay-2 proof-card" data-track="proof-card" data-proof-type="erp">
            <p class="cs-meta">ERP · Inventory &amp; Operations</p>
            <h3>One place for inventory, sales, purchases, finance, and approvals</h3>
            <p><strong>Problem:</strong> owners could not see live stock, orders, payments, and branch performance.
              <strong>Solution:</strong> modular ERP dashboard with role-based access. <strong>Result:</strong>
              decisions move from delayed reports to current business data.
            </p>
            <a href="<?= BASE_PATH ?>/demo/view.php?slug=erp" class="proof-link" target="_blank" rel="noopener"
              data-track="demo" data-demo-slug="erp">View ERP proof &rarr;</a>
          </article>
          <article class="cs-card reveal proof-card" data-track="proof-card" data-proof-type="portal">
            <p class="cs-meta">Portal · Dealers &amp; Customers</p>
            <h3>Self-service ordering and customer visibility</h3>
            <p><strong>Problem:</strong> repeat orders, invoices, and follow-ups stayed on phone calls.
              <strong>Solution:</strong> dealer or customer portal with pricing, order status, invoices, and support.
              <strong>Result:</strong> fewer manual follow-ups and cleaner repeat transactions.
            </p>
            <a href="<?= BASE_PATH ?>/services/ecommerce/" class="proof-link" data-track="proof-card"
              data-proof-type="portal-detail">Build a portal &rarr;</a>
          </article>
          <article class="cs-card reveal reveal-delay-1 proof-card" data-track="proof-card" data-proof-type="analytics">
            <p class="cs-meta">Dashboards · Analytics</p>
            <h3>Live KPIs instead of manual Excel reporting</h3>
            <p><strong>Problem:</strong> leadership reporting was delayed across ERP, accounts, and sales systems.
              <strong>Solution:</strong> BI dashboards and automated reports. <strong>Result:</strong> leadership gets
              daily visibility into revenue, stock, margins, sales, and operations.
            </p>
            <a href="<?= BASE_PATH ?>/services/data-analytics/" class="proof-link" data-track="proof-card"
              data-proof-type="analytics-detail">Scope dashboards &rarr;</a>
          </article>
          <article class="cs-card reveal reveal-delay-2 proof-card" data-track="proof-card" data-proof-type="pms">
            <p class="cs-meta">PMS · Hospitality</p>
            <h3>Reservations, housekeeping, billing, and guest workflows in sync</h3>
            <p><strong>Problem:</strong> front desk, housekeeping, POS, and OTA bookings operated separately.
              <strong>Solution:</strong> hotel PMS with operational modules and reporting. <strong>Result:</strong>
              fewer booking mistakes and clearer day-to-day room control.
            </p>
            <a href="<?= BASE_PATH ?>/services/industry-systems/" class="proof-link" data-track="proof-card"
              data-proof-type="pms-detail">Explore PMS systems &rarr;</a>
          </article>
        </div>
        <div class="mid-cta reveal">
          <div>
            <h3>Have a similar workflow problem?</h3>
            <p>Send a short requirement and we will respond with the likely first phase, timeline, and rough budget
              range.</p>
          </div>
          <a href="#contact" class="btn btn-primary" data-track="cta" data-cta-location="after-proof">Build Something
            Similar</a>
        </div>
      </div>
    </section>

    <!-- ═══════════════════════════════ RESOURCES ═══════════════════════════════ -->
    <section id="resources" aria-labelledby="resources-heading">
      <div class="container">
        <div class="reveal">
          <p class="section-label">Resources</p>
          <h2 id="resources-heading" class="section-title">Guides &amp; insights for growing businesses.</h2>
          <p class="section-sub">Practical frameworks and perspectives on ERP, CRM, and software strategy for growing
            businesses.</p>
        </div>
        <div class="resources-grid">
          <article class="resource-card reveal">
            <p class="res-cat">ERP · Strategy</p>
            <h3>How SMEs can approach ERP implementation</h3>
            <p>A practical framework for selecting, phasing, and rolling out ERP in a growing organisation without
              disrupting operations.</p>
          </article>
          <article class="resource-card reveal reveal-delay-1">
            <p class="res-cat">UX · Portals</p>
            <h3>Designing mobile‑first B2B portals</h3>
            <p>Principles for building portals that field teams and business partners actually enjoy using — on any
              device, any time.</p>
          </article>
          <article class="resource-card reveal reveal-delay-2">
            <p class="res-cat">Strategy · Build vs Buy</p>
            <h3>When to use custom software vs off‑the‑shelf</h3>
            <p>How to decide between customising a product and building a tailored platform — with a decision framework
              for each scenario.</p>
          </article>
        </div>
      </div>
    </section>

    <!-- ═══════════════════════════════ TECH STACK ═══════════════════════════════ -->
    <section id="tech-stack" aria-labelledby="tech-heading">
      <div class="container">
        <div class="reveal">
          <p class="section-label">Technology</p>
          <h2 id="tech-heading" class="section-title">Modern, battle‑tested technology stack.</h2>
          <p class="section-sub">Technologies that balance innovation with stability — so your systems stay performant,
            maintainable, and secure.</p>
        </div>
        <div class="tech-grid">
          <div class="tech-card reveal">
            <h3>Backend &amp; APIs</h3>
            <p>Laravel, Node.js, Spring Boot, Python / Django</p>
          </div>
          <div class="tech-card reveal reveal-delay-1">
            <h3>Frontend</h3>
            <p>React, Three.js, HTML5, CSS3, modern JavaScript</p>
          </div>
          <div class="tech-card reveal reveal-delay-2">
            <h3>Mobile</h3>
            <p>Flutter, React Native for Android &amp; iOS</p>
          </div>
          <div class="tech-card reveal">
            <h3>Data &amp; Storage</h3>
            <p>PostgreSQL, MongoDB, Redis, modern analytics tools</p>
          </div>
          <div class="tech-card reveal reveal-delay-1">
            <h3>IoT &amp; Embedded</h3>
            <p>MATLAB, LabVIEW, Keil, Arduino, custom firmware</p>
          </div>
          <div class="tech-card reveal reveal-delay-2">
            <h3>Specialised</h3>
            <p>Blockchain integrations, third‑party platform connectors</p>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══════════════════════════════ WHY US ═══════════════════════════════ -->
    <section id="why-us" aria-labelledby="why-heading">
      <div class="container">
        <div class="reveal">
          <p class="section-label">Why choose us</p>
          <h2 id="why-heading" class="section-title">A partner focused on outcomes, not just deliverables.</h2>
        </div>
        <div class="why-grid">
          <div class="why-card reveal">
            <div class="why-num" aria-hidden="true">01</div>
            <div>
              <h3>Enterprise‑grade quality</h3>
              <p>Architecture, security, and performance standards comparable to large IT firms — delivered at
                SME‑compatible speed and cost.</p>
            </div>
          </div>
          <div class="why-card reveal reveal-delay-1">
            <div class="why-num" aria-hidden="true">02</div>
            <div>
              <h3>SME‑friendly approach</h3>
              <p>Phased roadmaps, transparent communication, and commercial models designed around how growing
                businesses actually operate.</p>
            </div>
          </div>
          <div class="why-card reveal reveal-delay-2">
            <div class="why-num" aria-hidden="true">03</div>
            <div>
              <h3>Domain‑aware delivery</h3>
              <p>Pre‑built patterns for logistics, healthcare, hospitality, finance, and more — so you don't pay for us
                to learn your industry.</p>
            </div>
          </div>
          <div class="why-card reveal reveal-delay-3">
            <div class="why-num" aria-hidden="true">04</div>
            <div>
              <h3>Long‑term partnership</h3>
              <p>Support, maintenance, and continuous improvement after go‑live. We build systems designed to grow with
                your business.</p>
            </div>
          </div>
        </div>

        <!-- ═══════════════════════════════ COMPARISON TABLE ═══════════════════════════════ -->
        <div class="reveal">
          <h3 style="margin: 60px 0 24px; font-size: 24px; text-align: center; color: var(--text-1);">How We Compare
          </h3>
          <div class="dnd-comparison-table-wrapper">
            <table class="dnd-comparison-table">
              <thead>
                <tr>
                  <th>Evaluation Factor</th>
                  <th>Dashandots Custom ERP</th>
                  <th>Off-the-shelf SaaS</th>
                  <th>In-house Build</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><strong>Customization & Fit</strong></td>
                  <td>100% tailored to your specific workflows and operations.</td>
                  <td>Forced to adapt your business to their standard software.</td>
                  <td>100% tailored, but highly dependent on your internal team.</td>
                </tr>
                <tr>
                  <td><strong>Long-term Cost (TCO)</strong></td>
                  <td>One-time build cost + low maintenance. Very cost-effective at scale.</td>
                  <td>Per-user/per-month fees scale exponentially as you grow.</td>
                  <td>Extremely high (hiring, retaining, and managing developers).</td>
                </tr>
                <tr>
                  <td><strong>Speed to Market</strong></td>
                  <td>Fast. We use pre-built industry patterns and dedicated squads.</td>
                  <td>Instant (if you accept out-of-the-box limitations).</td>
                  <td>Slowest. Months spent hiring and establishing infrastructure.</td>
                </tr>
                <tr>
                  <td><strong>Ownership & IP</strong></td>
                  <td>You own the code, the intellectual property, and your data entirely.</td>
                  <td>Vendor lock-in. You own nothing but your exported data.</td>
                  <td>You own it, but key knowledge leaves if your lead developer quits.</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

      </div>
    </section>

    <!-- ═══════════════════════════════ FAQ ═══════════════════════════════ -->
    <section id="faq" aria-labelledby="faq-heading">
      <div class="container">
        <div class="reveal" style="text-align:center">
          <p class="section-label">FAQ</p>
          <h2 id="faq-heading" class="section-title">Answers to common questions.</h2>
        </div>
        <div class="faq-list">
          <div class="faq-item">
            <button class="faq-q" aria-expanded="false">Do you work with small and mid‑size businesses?<svg
                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" aria-hidden="true">
                <line x1="12" y1="5" x2="12" y2="19" />
                <line x1="5" y1="12" x2="19" y2="12" />
              </svg></button>
            <div class="faq-a">
              <div class="faq-a-inner">Yes. Our delivery model is optimised for SMEs and growing companies, while still
                maintaining enterprise‑grade standards in architecture, security, and code quality.</div>
            </div>
          </div>
          <div class="faq-item">
            <button class="faq-q" aria-expanded="false">How do you estimate cost and timeline for a project?<svg
                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" aria-hidden="true">
                <line x1="12" y1="5" x2="12" y2="19" />
                <line x1="5" y1="12" x2="19" y2="12" />
              </svg></button>
            <div class="faq-a">
              <div class="faq-a-inner">We start with a structured discovery of your requirements, then provide a
                detailed estimate before any commitment. Use the contact form below for an initial scope discussion — we
                typically respond within 24 hours.</div>
            </div>
          </div>
          <div class="faq-item">
            <button class="faq-q" aria-expanded="false">Can you integrate with existing tools like Tally or a legacy
              ERP?<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" aria-hidden="true">
                <line x1="12" y1="5" x2="12" y2="19" />
                <line x1="5" y1="12" x2="19" y2="12" />
              </svg></button>
            <div class="faq-a">
              <div class="faq-a-inner">In most cases, yes. We have experience integrating with accounting tools (Tally,
                Zoho Books), payment gateways, logistics APIs, and legacy systems via custom connectors and REST/SOAP
                APIs.</div>
            </div>
          </div>
          <div class="faq-item">
            <button class="faq-q" aria-expanded="false">What happens after the project goes live?<svg
                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" aria-hidden="true">
                <line x1="12" y1="5" x2="12" y2="19" />
                <line x1="5" y1="12" x2="19" y2="12" />
              </svg></button>
            <div class="faq-a">
              <div class="faq-a-inner">We offer structured support and AMC (Annual Maintenance Contract) options that
                cover monitoring, bug fixes, enhancements, and ongoing feature development. You're never left alone
                post‑launch.</div>
            </div>
          </div>
          <div class="faq-item">
            <button class="faq-q" aria-expanded="false">What engagement models do you offer?<svg
                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" aria-hidden="true">
                <line x1="12" y1="5" x2="12" y2="19" />
                <line x1="5" y1="12" x2="19" y2="12" />
              </svg></button>
            <div class="faq-a">
              <div class="faq-a-inner">We offer three models: fixed‑price projects with a clear scope and deliverables;
                time &amp; material for evolving products where requirements change; and dedicated squads as an
                extension of your own team.</div>
            </div>
          </div>
          <div class="faq-item">
            <button class="faq-q" aria-expanded="false">Are you a software development company in Delhi, India?<svg
                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" aria-hidden="true">
                <line x1="12" y1="5" x2="12" y2="19" />
                <line x1="5" y1="12" x2="19" y2="12" />
              </svg></button>
            <div class="faq-a">
              <div class="faq-a-inner">Yes. Dashandots Technology is based in Gurugram, Delhi NCR. We are a full-cycle
                custom software development company serving clients across Delhi, the rest of India, and globally. Our
                core services include ERP development, CRM systems, mobile app development, hotel management software
                (PMS), hospital management software (HMS), and transport management systems (TMS).</div>
            </div>
          </div>
          <div class="faq-item">
            <button class="faq-q" aria-expanded="false">Do you build hotel management software and property management
              systems (PMS)?<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" aria-hidden="true">
                <line x1="12" y1="5" x2="12" y2="19" />
                <line x1="5" y1="12" x2="19" y2="12" />
              </svg></button>
            <div class="faq-a">
              <div class="faq-a-inner">Yes. Our Hotel PMS is a complete hotel management system covering reservations,
                front-office, housekeeping, POS, and guest management. We build custom hotel management software
                tailored to boutique hotels, hotel chains, and resorts across India — fully integrated with billing,
                GST, and channel management.</div>
            </div>
          </div>
          <div class="faq-item">
            <button class="faq-q" aria-expanded="false">Can you develop custom project management software?<svg
                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" aria-hidden="true">
                <line x1="12" y1="5" x2="12" y2="19" />
                <line x1="5" y1="12" x2="19" y2="12" />
              </svg></button>
            <div class="faq-a">
              <div class="faq-a-inner">Absolutely. We build custom project management software and task-tracking
                platforms as standalone tools or integrated modules within your ERP or CRM. Whether you need agile
                sprint boards, milestone tracking, resource planning, or client-facing project portals — we design and
                develop the solution from scratch to match your exact workflow.</div>
            </div>
          </div>
        </div>
      </div>
    </section>


    <!-- ═══════════════════════════ AI PROJECT BRIEF & COST ESTIMATE ═══════════════════════════ -->
    <section id="ai-brief" aria-labelledby="wizard-heading">
      <div class="container">
        <div class="reveal" style="text-align:center">
          <p class="section-label">AI‑Assisted Scoping</p>
          <h2 id="wizard-heading" class="section-title">Get an instant project brief &amp; cost estimate.</h2>
          <p class="section-sub" style="margin:0 auto">Not sure where to start? Answer 5 quick questions and we'll
            generate a structured project brief with a realistic budget and timeline range — and pre‑fill your enquiry
            form instantly.</p>
        </div>

        <div class="wizard-wrap reveal">
          <!-- Progress bar -->
          <div class="wizard-progress" id="wizProgress" role="tablist" aria-label="Wizard steps">
            <div class="wp-step active" data-step="1">
              <div class="wp-dot">1</div>
              <div class="wp-label">Project Type</div>
            </div>
            <div class="wp-step" data-step="2">
              <div class="wp-dot">2</div>
              <div class="wp-label">Scale</div>
            </div>
            <div class="wp-step" data-step="3">
              <div class="wp-dot">3</div>
              <div class="wp-label">Features</div>
            </div>
            <div class="wp-step" data-step="4">
              <div class="wp-dot">4</div>
              <div class="wp-label">Integrations</div>
            </div>
            <div class="wp-step" data-step="5">
              <div class="wp-dot">5</div>
              <div class="wp-label">Your Details</div>
            </div>
          </div>

          <!-- STEP 1: Project type -->
          <div class="wizard-pane active" id="wizPane1">
            <h3 class="wizard-pane-title">What are you looking to build?</h3>
            <p class="wizard-pane-sub">Select the type of software that best matches your requirement.</p>
            <div class="wiz-type-grid" id="typeGrid">
              <div class="wiz-type-card" data-type="Website">
                <div class="wt-icon"><svg viewBox="0 0 24 24" fill="none" stroke="#C8293E" stroke-width="1.7"
                    stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="12" cy="12" r="9" />
                    <path d="M12 3 C9.5 7 9.5 17 12 21 M12 3 C14.5 7 14.5 17 12 21" />
                    <path d="M3 12 H21 M3.5 8 H20.5 M3.5 16 H20.5" />
                  </svg></div>
                <div class="wt-label">Website / Landing Page</div>
              </div>
              <div class="wiz-type-card" data-type="Web App">
                <div class="wt-icon"><svg viewBox="0 0 24 24" fill="none" stroke="#C8293E" stroke-width="1.7"
                    stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg">
                    <rect x="2" y="4" width="20" height="14" rx="2" />
                    <path d="M2 18 H22" />
                    <path d="M7 21 H17 M12 18 V21" />
                    <path d="M7 8 L10 11 L7 14" />
                    <path d="M13 14 H17" />
                  </svg></div>
                <div class="wt-label">Custom Web App / Portal</div>
              </div>
              <div class="wiz-type-card" data-type="Mobile App">
                <div class="wt-icon"><svg viewBox="0 0 24 24" fill="none" stroke="#C8293E" stroke-width="1.7"
                    stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg">
                    <rect x="6" y="1" width="12" height="22" rx="3" />
                    <circle cx="12" cy="18.5" r="1.2" fill="#C8293E" stroke="none" />
                    <path d="M9 4.5 H15" />
                  </svg></div>
                <div class="wt-label">Mobile App (iOS / Android)</div>
              </div>
              <div class="wiz-type-card" data-type="ERP">
                <div class="wt-icon"><svg viewBox="0 0 24 24" fill="none" stroke="#C8293E" stroke-width="1.7"
                    stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg">
                    <rect x="3" y="3" width="18" height="20" rx="1.5" />
                    <path d="M3 9 H21" />
                    <rect x="7" y="13" width="3" height="3" rx="0.5" />
                    <rect x="14" y="13" width="3" height="3" rx="0.5" />
                    <rect x="10" y="16" width="4" height="7" rx="0.5" />
                    <path d="M7 6 H10 M14 6 H17" />
                  </svg></div>
                <div class="wt-label">ERP / Business Management</div>
              </div>
              <div class="wiz-type-card" data-type="CRM">
                <div class="wt-icon"><svg viewBox="0 0 24 24" fill="none" stroke="#C8293E" stroke-width="1.7"
                    stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg">
                    <path d="M2 8 L8 5 L12 8 L16 5 L22 8" />
                    <path d="M2 8 C2 8 4 16 8 16 L12 14 L16 16 C20 16 22 8 22 8" />
                    <path d="M8 16 L8 20 M16 16 L16 20" />
                    <path d="M12 8 L12 14" />
                  </svg></div>
                <div class="wt-label">CRM / Sales Pipeline</div>
              </div>
              <div class="wiz-type-card" data-type="TMS">
                <div class="wt-icon"><svg viewBox="0 0 24 24" fill="none" stroke="#C8293E" stroke-width="1.7"
                    stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg">
                    <rect x="1" y="8" width="13" height="10" rx="1.5" />
                    <path d="M14 11 L18 11 L22 15 L22 18 L14 18 Z" />
                    <circle cx="5" cy="20" r="2" />
                    <circle cx="18" cy="20" r="2" />
                    <path d="M7 18 L15 18" />
                    <path d="M18 11 L18 15 L22 15" />
                  </svg></div>
                <div class="wt-label">Transport &amp; Logistics (TMS)</div>
              </div>
              <div class="wiz-type-card" data-type="HMS">
                <div class="wt-icon"><svg viewBox="0 0 24 24" fill="none" stroke="#C8293E" stroke-width="1.7"
                    stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg">
                    <rect x="3" y="6" width="18" height="17" rx="1.5" />
                    <path d="M3 12 H21" />
                    <path d="M9 6 V4 H15 V6" />
                    <path d="M10 9 H14 M12 7.5 V10.5" />
                    <rect x="7" y="15" width="4" height="8" rx="0.5" />
                    <rect x="14" y="15" width="3.5" height="5.5" rx="0.5" />
                  </svg></div>
                <div class="wt-label">Hospital / Clinic (HMS)</div>
              </div>
              <div class="wiz-type-card" data-type="Hotel PMS">
                <div class="wt-icon"><svg viewBox="0 0 24 24" fill="none" stroke="#C8293E" stroke-width="1.7"
                    stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg">
                    <rect x="2" y="4" width="20" height="19" rx="1.5" />
                    <path d="M2 10 H22" />
                    <rect x="6" y="14" width="4" height="3.5" rx="0.5" />
                    <rect x="14" y="14" width="4" height="3.5" rx="0.5" />
                    <path d="M10 23 V17 Q12 14.5 14 17 V23" />
                    <path d="M7 4 V2 M12 4 V2 M17 4 V2" />
                  </svg></div>
                <div class="wt-label">Hotel / Property (PMS)</div>
              </div>
              <div class="wiz-type-card" data-type="Finance Software">
                <div class="wt-icon"><svg viewBox="0 0 24 24" fill="none" stroke="#C8293E" stroke-width="1.7"
                    stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg">
                    <rect x="2" y="8" width="20" height="14" rx="2" />
                    <circle cx="12" cy="15" r="4" />
                    <path d="M12 12 V18 M10 13.5 Q12 11.5 14 13.5 M10 16.5 Q12 18.5 14 16.5" />
                    <path d="M6 8 V5 H18 V8" />
                    <circle cx="5" cy="15" r="1" fill="#C8293E" stroke="none" />
                    <circle cx="19" cy="15" r="1" fill="#C8293E" stroke="none" />
                  </svg></div>
                <div class="wt-label">Finance &amp; Accounting</div>
              </div>
              <div class="wiz-type-card" data-type="IoT/Embedded">
                <div class="wt-icon"><svg viewBox="0 0 24 24" fill="none" stroke="#C8293E" stroke-width="1.7"
                    stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="12" cy="12" r="3.5" />
                    <path
                      d="M12 2 L13.5 5.5 L17 4 L17 7.5 L20.5 8 L19 11.5 L22 12 L19 12.5 L20.5 16 L17 16.5 L17 20 L13.5 18.5 L12 22 L10.5 18.5 L7 20 L7 16.5 L3.5 16 L5 12.5 L2 12 L5 11.5 L3.5 8 L7 7.5 L7 4 L10.5 5.5 Z"
                      stroke-linejoin="round" />
                  </svg></div>
                <div class="wt-label">IoT / Embedded System</div>
              </div>
            </div>
            <div class="wizard-nav">
              <div></div>
              <button class="wiz-btn wiz-btn-primary" id="step1Next" disabled onclick="wizNext(1)">Next: Scale &amp;
                Size →</button>
            </div>
          </div>

          <!-- STEP 2: Scale -->
          <div class="wizard-pane" id="wizPane2">
            <h3 class="wizard-pane-title">What is the scale of this project?</h3>
            <p class="wizard-pane-sub">This helps us estimate team size, architecture complexity, and timelines.</p>
            <div class="wiz-scale-options" id="scaleGrid">
              <label class="wiz-radio-card" data-scale="Small" onclick="selectScale(this)">
                <input type="radio" name="scale" value="Small">
                <div>
                  <div class="wrc-title">Small — Startup / MVP</div>
                  <div class="wrc-desc">Solo founder, startup, or a quick MVP to validate an idea. Simple workflows,
                    limited users.</div>
                </div>
              </label>
              <label class="wiz-radio-card" data-scale="Medium" onclick="selectScale(this)">
                <input type="radio" name="scale" value="Medium">
                <div>
                  <div class="wrc-title">Medium — Growing Business</div>
                  <div class="wrc-desc">10–200 users, multiple departments, moderate integrations, some reporting.</div>
                </div>
              </label>
              <label class="wiz-radio-card" data-scale="Large" onclick="selectScale(this)">
                <input type="radio" name="scale" value="Large">
                <div>
                  <div class="wrc-title">Large — Enterprise / Multi-location</div>
                  <div class="wrc-desc">200+ users, multi-branch or multi-company, complex permissions, advanced
                    analytics.</div>
                </div>
              </label>
            </div>
            <div class="wizard-nav">
              <button class="wiz-btn wiz-btn-secondary" onclick="wizBack(2)">← Back</button>
              <button class="wiz-btn wiz-btn-primary" id="step2Next" disabled onclick="wizNext(2)">Next: Key Features
                →</button>
            </div>
          </div>

          <!-- STEP 3: Features -->
          <div class="wizard-pane" id="wizPane3">
            <h3 class="wizard-pane-title">Which features are most important?</h3>
            <p class="wizard-pane-sub">Select all that apply — each feature influences the estimate.</p>
            <div class="wiz-check-grid" id="featuresGrid">
              <label class="wiz-check-card" onclick="toggleCheck(this)"><input type="checkbox"
                  value="User roles &amp; permissions"><span class="wcc-label">User roles &amp;
                  permissions</span></label>
              <label class="wiz-check-card" onclick="toggleCheck(this)"><input type="checkbox"
                  value="Dashboard &amp; analytics"><span class="wcc-label">Dashboard &amp; analytics</span></label>
              <label class="wiz-check-card" onclick="toggleCheck(this)"><input type="checkbox"
                  value="Notifications &amp; alerts"><span class="wcc-label">Notifications &amp; alerts</span></label>
              <label class="wiz-check-card" onclick="toggleCheck(this)"><input type="checkbox"
                  value="Document management"><span class="wcc-label">Document management</span></label>
              <label class="wiz-check-card" onclick="toggleCheck(this)"><input type="checkbox"
                  value="Automated workflows"><span class="wcc-label">Automated workflows</span></label>
              <label class="wiz-check-card" onclick="toggleCheck(this)"><input type="checkbox"
                  value="Mobile app companion"><span class="wcc-label">Mobile app companion</span></label>
              <label class="wiz-check-card" onclick="toggleCheck(this)"><input type="checkbox"
                  value="Reports &amp; exports"><span class="wcc-label">Reports &amp; exports</span></label>
              <label class="wiz-check-card" onclick="toggleCheck(this)"><input type="checkbox"
                  value="Real-time tracking / maps"><span class="wcc-label">Real-time tracking / maps</span></label>
              <label class="wiz-check-card" onclick="toggleCheck(this)"><input type="checkbox"
                  value="AI / ML features"><span class="wcc-label">AI / ML features</span></label>
              <label class="wiz-check-card" onclick="toggleCheck(this)"><input type="checkbox"
                  value="Multi-language / localisation"><span class="wcc-label">Multi-language /
                  localisation</span></label>
              <label class="wiz-check-card" onclick="toggleCheck(this)"><input type="checkbox"
                  value="Online payments"><span class="wcc-label">Online payments</span></label>
              <label class="wiz-check-card" onclick="toggleCheck(this)"><input type="checkbox"
                  value="API for third-party access"><span class="wcc-label">API for third-party access</span></label>
            </div>
            <div class="wizard-nav">
              <button class="wiz-btn wiz-btn-secondary" onclick="wizBack(3)">← Back</button>
              <button class="wiz-btn wiz-btn-primary" onclick="wizNext(3)">Next: Integrations →</button>
            </div>
          </div>

          <!-- STEP 4: Integrations -->
          <div class="wizard-pane" id="wizPane4">
            <h3 class="wizard-pane-title">Any integrations or platforms needed?</h3>
            <p class="wizard-pane-sub">Integrations add real complexity. Select any that apply.</p>
            <div class="wiz-check-grid" id="integrationsGrid">
              <label class="wiz-check-card" onclick="toggleCheck(this)"><input type="checkbox"
                  value="Tally / accounting software"><span class="wcc-label">Tally / accounting software</span></label>
              <label class="wiz-check-card" onclick="toggleCheck(this)"><input type="checkbox"
                  value="Payment gateway (Razorpay, Stripe)"><span class="wcc-label">Payment gateway</span></label>
              <label class="wiz-check-card" onclick="toggleCheck(this)"><input type="checkbox"
                  value="WhatsApp / SMS notifications"><span class="wcc-label">WhatsApp / SMS
                  notifications</span></label>
              <label class="wiz-check-card" onclick="toggleCheck(this)"><input type="checkbox"
                  value="GST / e-invoicing (IRP)"><span class="wcc-label">GST / e-invoicing (IRP)</span></label>
              <label class="wiz-check-card" onclick="toggleCheck(this)"><input type="checkbox"
                  value="GPS / fleet tracking"><span class="wcc-label">GPS / fleet tracking</span></label>
              <label class="wiz-check-card" onclick="toggleCheck(this)"><input type="checkbox"
                  value="IoT sensors / devices"><span class="wcc-label">IoT sensors / devices</span></label>
              <label class="wiz-check-card" onclick="toggleCheck(this)"><input type="checkbox"
                  value="Third-party REST APIs"><span class="wcc-label">Third-party REST APIs</span></label>
              <label class="wiz-check-card" onclick="toggleCheck(this)"><input type="checkbox"
                  value="Google / Microsoft SSO"><span class="wcc-label">Google / Microsoft SSO</span></label>
              <label class="wiz-check-card" onclick="toggleCheck(this)"><input type="checkbox"
                  value="Cloud storage (AWS S3 / Azure)"><span class="wcc-label">Cloud storage (AWS /
                  Azure)</span></label>
            </div>
            <div class="wizard-nav">
              <button class="wiz-btn wiz-btn-secondary" onclick="wizBack(4)">← Back</button>
              <button class="wiz-btn wiz-btn-primary" onclick="wizNext(4)">Next: Your Details →</button>
            </div>
          </div>

          <!-- STEP 5: Contact details -->
          <div class="wizard-pane" id="wizPane5">
            <h3 class="wizard-pane-title">Almost there — tell us a bit about yourself.</h3>
            <p class="wizard-pane-sub">Your details help us personalise the project brief and pre-fill the enquiry form.
            </p>
            <div class="wizard-contact-grid">
              <div class="wiz-input-group">
                <label for="wizName">Your name <span style="color:var(--accent)">*</span></label>
                <input type="text" id="wizName" placeholder="e.g. Rahul Sharma" autocomplete="name">
              </div>
              <div class="wiz-input-group">
                <label for="wizEmail">Email address <span style="color:var(--accent)">*</span></label>
                <input type="email" id="wizEmail" placeholder="you@company.com" autocomplete="email">
              </div>
              <div class="wiz-input-group">
                <label for="wizCompany">Company / Organisation</label>
                <input type="text" id="wizCompany" placeholder="Your company name" autocomplete="organization">
              </div>
              <div class="wiz-input-group">
                <label for="wizPhone">Phone (optional)</label>
                <input type="tel" id="wizPhone" placeholder="+91 98765 43210" autocomplete="tel">
              </div>
            </div>
            <div class="wiz-input-group" style="margin-bottom:28px">
              <label for="wizIdea">Describe your idea in a few words</label>
              <textarea id="wizIdea"
                placeholder="e.g. I need a fleet tracking app for my logistics company with billing and driver management…"></textarea>
            </div>
            <div class="wizard-nav">
              <button class="wiz-btn wiz-btn-secondary" onclick="wizBack(5)">← Back</button>
              <button class="wiz-btn wiz-btn-primary" id="step5Generate" onclick="generateBrief()">✦ Generate My Project
                Brief</button>
            </div>
          </div>

          <!-- RESULT PANE -->
          <div id="wizResultPane">
            <div class="wiz-result-card">
              <div class="wiz-result-header">
                <div>
                  <div
                    style="font-size:11px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--accent);margin-bottom:6px">
                    AI-Generated Project Brief</div>
                  <div class="wiz-result-title">Project Brief for <span id="resProjectType">—</span></div>
                  <div style="font-size:13px;color:var(--text-3);margin-top:4px" id="resClientName"></div>
                </div>
                <div class="wiz-badges">
                  <div class="wiz-badge">
                    <div class="wb-label">Estimated Budget</div>
                    <div class="wb-val" id="resBudget">—</div>
                  </div>
                  <div class="wiz-badge">
                    <div class="wb-label">Timeline</div>
                    <div class="wb-val" id="resTimeline">—</div>
                  </div>
                  <div class="wiz-badge">
                    <div class="wb-label">Complexity</div>
                    <div class="wb-val" id="resComplexity">—</div>
                  </div>
                </div>
              </div>
              <div class="wiz-brief-section">
                <h4>Project Summary</h4>
                <div class="wiz-brief-text" id="resSummary"></div>
              </div>
              <div class="wiz-brief-section">
                <h4>Scope Highlights</h4>
                <div class="wiz-brief-text" id="resScope"></div>
              </div>
              <div class="wiz-brief-section">
                <h4>Recommended Tech Stack</h4>
                <div class="wiz-brief-text" id="resTech"></div>
              </div>
              <div class="wiz-brief-section">
                <h4>Key Assumptions &amp; Notes</h4>
                <div class="wiz-brief-text" id="resNotes"></div>
              </div>
              <div class="wiz-result-actions">
                <button class="wiz-btn wiz-btn-primary" onclick="prefillContactForm()">→ Pre-fill Enquiry Form &amp;
                  Send</button>
                <button class="wiz-btn wiz-btn-secondary" onclick="resetWizard()">↺ Start Over</button>
              </div>
            </div>
          </div>

        </div><!-- /.wizard-wrap -->
      </div>
    </section>

    <!-- ═══════════════════════════════ CONTACT STRIP ═══════════════════════════════ -->
    <div class="contact-strip" role="complementary" aria-label="Call to action">
      <div class="container">
        <div class="strip-inner">
          <div>
            <h2>Ready to centralise your business operations?</h2>
            <p>Tell us about your workflow and we'll respond within 1 business day with the likely approach, timeline,
              and rough budget range.</p>
          </div>
          <a href="#contact" class="btn btn-white" data-track="cta" data-cta-location="contact-strip">Get My Free
            Project Estimate</a>
        </div>
      </div>
    </div>

    <!-- ═══════════════════════════════ CONTACT ═══════════════════════════════ -->
    <section id="contact" aria-labelledby="contact-heading">
      <div class="container">
        <div class="reveal" style="text-align:center;margin-bottom:16px">
          <p class="section-label">Contact</p>
          <h2 id="contact-heading" class="section-title">Get a free project estimate.</h2>
          <p class="section-sub" style="margin:0 auto">We respond within 1 business day with suggested approach,
            estimated timeline, and rough budget range. No spam. No obligation.</p>
        </div>
        <div class="contact-grid">
          <!-- FORM -->
          <div class="contact-form-wrap reveal">
            <h3>Send your requirement</h3>
            <form id="contactForm" novalidate>
              <div class="hp-field" aria-hidden="true">
                <label for="website">Website</label>
                <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
              </div>
              <div class="form-row">
                <div class="form-group">
                  <label for="name">Your name <span aria-hidden="true" style="color:var(--accent)">*</span></label>
                  <input type="text" id="name" name="name" placeholder="Sumit Kumar" required autocomplete="name">
                </div>
                <div class="form-group">
                  <label for="company">Company</label>
                  <input type="text" id="company" name="company" placeholder="Your company" autocomplete="organization">
                </div>
              </div>
              <div class="form-row">
                <div class="form-group">
                  <label for="email">Work email <span aria-hidden="true" style="color:var(--accent)">*</span></label>
                  <input type="email" id="email" name="email" placeholder="you@company.com" required
                    autocomplete="email">
                </div>
                <div class="form-group">
                  <label for="phone">Phone (optional)</label>
                  <input type="tel" id="phone" name="phone" placeholder="+91 98765 43210" autocomplete="tel">
                </div>
              </div>
              <div class="form-group">
                <label for="service">Service interested in</label>
                <select id="service" name="service">
                  <option value="">Select a service…</option>
                  <option>ERP Development</option>
                  <option>CRM Development</option>
                  <option>Transport Management System (TMS)</option>
                  <option>Hospital Management System (HMS)</option>
                  <option>Hotel / Property Management (PMS)</option>
                  <option>Custom Web Application</option>
                  <option>Mobile App (iOS / Android)</option>
                  <option>E‑commerce / Portal</option>
                  <option>Data, Analytics &amp; AI</option>
                  <option>IoT &amp; Embedded</option>
                  <option>Other</option>
                </select>
              </div>
              <div class="form-group">
                <label for="message">How can we help? <span aria-hidden="true"
                    style="color:var(--accent)">*</span></label>
                <textarea id="message" name="message" placeholder="Briefly describe your project, challenge, or idea…"
                  required></textarea>
              </div>
              <button type="submit" class="form-submit" id="submitBtn">
                <span class="btn-text">Get My Free Project Estimate →</span>
                <span class="spinner" aria-hidden="true"></span>
              </button>
              <p class="form-reassurance">We respond within 1 business day. No spam. No obligation.</p>
              <div class="form-status" id="formStatus" role="alert" aria-live="polite"></div>
            </form>
          </div>
          <!-- CONTACT DETAILS -->
          <div class="contact-info reveal reveal-delay-1">
            <h3>Get in touch directly</h3>
            <div class="contact-detail-list">
              <?php if (defined('SITE_EMAIL') && SITE_EMAIL !== ''): ?>
                <div class="contact-detail">
                  <div class="cd-icon" aria-hidden="true"><svg viewBox="0 0 22 22" xmlns="http://www.w3.org/2000/svg"
                      fill="none" stroke="#C8293E" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                      <rect x="2" y="5" width="18" height="13" rx="2" />
                      <path d="M2 7 L11 13 L20 7" />
                    </svg></div>
                  <div>
                    <div class="cd-label">Email</div>
                    <div class="cd-value"><a href="mailto:<?= htmlspecialchars(SITE_EMAIL, ENT_QUOTES, 'UTF-8') ?>"
                        data-track="cta" data-cta-location="contact-info"><?= htmlspecialchars(SITE_EMAIL) ?></a></div>
                  </div>
                </div>
              <?php endif; ?>
              <?php if (defined('SITE_PHONE') && SITE_PHONE !== ''): ?>
                <div class="contact-detail">
                  <div class="cd-icon" aria-hidden="true"><svg viewBox="0 0 22 22" xmlns="http://www.w3.org/2000/svg"
                      fill="none" stroke="#C8293E" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                      <path
                        d="M6 2 L10 6 L8 9 C9.5 12 12 14.5 15 16 L18 14 L22 18 C20.5 21 17.5 21.5 14 20 C8 17.5 4.5 14 2 8 C.5 4.5 3 2.8 6 2 Z" />
                    </svg></div>
                  <div>
                    <div class="cd-label">Phone</div>
                    <div class="cd-value"><a
                        href="tel:<?= htmlspecialchars(preg_replace('/\s+/', '', SITE_PHONE), ENT_QUOTES, 'UTF-8') ?>"
                        data-track="phone" data-cta-location="contact-info"><?= htmlspecialchars(SITE_PHONE) ?></a></div>
                  </div>
                </div>
              <?php endif; ?>
              <?php if (defined('SITE_WHATSAPP_URL') && SITE_WHATSAPP_URL !== ''): ?>
                <div class="contact-detail">
                  <div class="cd-icon" aria-hidden="true"><svg viewBox="0 0 22 22" xmlns="http://www.w3.org/2000/svg"
                      fill="none" stroke="#C8293E" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                      <path d="M11 2 A8 8 0 0 1 19 10 A8 8 0 0 1 7 17 L3 18 L4 14 A8 8 0 0 1 11 2 Z" />
                      <path d="M8 8 C8.5 11 10.5 13 14 14" />
                    </svg></div>
                  <div>
                    <div class="cd-label">WhatsApp</div>
                    <div class="cd-value"><a href="<?= htmlspecialchars(SITE_WHATSAPP_URL, ENT_QUOTES, 'UTF-8') ?>"
                        target="_blank" rel="noopener" data-track="whatsapp" data-cta-location="contact-info">Talk to a
                        software consultant</a></div>
                  </div>
                </div>
              <?php endif; ?>
              <?php if (defined('SITE_ADDRESS') && SITE_ADDRESS !== ''): ?>
                <div class="contact-detail">
                  <div class="cd-icon" aria-hidden="true"><svg viewBox="0 0 22 22" xmlns="http://www.w3.org/2000/svg"
                      fill="none" stroke="#C8293E" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                      <path d="M11 2 C7.5 2 5 4.7 5 8 C5 12.5 11 20 11 20 C11 20 17 12.5 17 8 C17 4.7 14.5 2 11 2 Z" />
                      <circle cx="11" cy="8" r="2.5" />
                    </svg></div>
                  <div>
                    <div class="cd-label">Location</div>
                    <div class="cd-value"><?= htmlspecialchars(SITE_ADDRESS) ?></div>
                  </div>
                </div>
              <?php endif; ?>
              <?php if (defined('SITE_FOUNDER_NAME') && SITE_FOUNDER_NAME !== ''): ?>
                <div class="contact-detail founder-detail">
                  <div class="cd-icon" aria-hidden="true"><svg viewBox="0 0 22 22" xmlns="http://www.w3.org/2000/svg"
                      fill="none" stroke="#C8293E" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                      <circle cx="11" cy="7" r="4" />
                      <path d="M3 20 C4.5 15 17.5 15 19 20" />
                    </svg></div>
                  <div>
                    <div class="cd-label">Founder-led discovery</div>
                    <div class="cd-value">
                      <?= htmlspecialchars(SITE_FOUNDER_NAME) ?> · <?= htmlspecialchars(SITE_FOUNDER_TITLE) ?>
                      <?php if (defined('SITE_FOUNDER_LINKEDIN') && SITE_FOUNDER_LINKEDIN !== ''): ?>
                        <br><a href="<?= htmlspecialchars(SITE_FOUNDER_LINKEDIN, ENT_QUOTES, 'UTF-8') ?>" target="_blank"
                          rel="noopener">View LinkedIn</a>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
              <?php endif; ?>
              <div class="contact-detail">
                <div class="cd-icon" aria-hidden="true"><svg viewBox="0 0 22 22" xmlns="http://www.w3.org/2000/svg"
                    fill="none" stroke="#C8293E" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="13" r="8" />
                    <path d="M11 9 V14 L14 16" />
                    <path d="M8 2 H14 M11 2 V5" />
                    <path d="M18 5 L19.5 6.5" />
                  </svg></div>
                <div>
                  <div class="cd-label">Response time</div>
                  <div class="cd-value">Within 24 hours, Monday–Friday</div>
                </div>
              </div>
            </div>
            <div style="margin-top:8px">
              <p
                style="font-size:13px;color:var(--text-3);margin-bottom:12px;font-weight:600;text-transform:uppercase;letter-spacing:.08em">
                Follow us</p>
              <div class="social-links">
                <a href="https://www.linkedin.com/company/102707174/" target="_blank" rel="noopener noreferrer"
                  class="social-link" aria-label="LinkedIn">
                  <svg viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z" />
                    <rect x="2" y="9" width="4" height="12" />
                    <circle cx="4" cy="4" r="2" />
                  </svg>
                </a>
                <a href="https://twitter.com/dashandots" target="_blank" rel="noopener noreferrer" class="social-link"
                  aria-label="Twitter / X">
                  <svg viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path
                      d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                  </svg>
                </a>
                <a href="https://github.com/dashandots" target="_blank" rel="noopener noreferrer" class="social-link"
                  aria-label="GitHub">
                  <svg viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path
                      d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22" />
                  </svg>
                </a>
              </div>
            </div>
            <div
              style="margin-top:32px;background:var(--surface-2);border-radius:var(--r-md);padding:22px;border:.5px solid var(--border)">
              <h3 style="font-size:15px;font-weight:700;margin-bottom:10px">Engagement models</h3>
              <div style="display:flex;flex-direction:column;gap:8px">
                <div style="font-size:13px;color:var(--text-2);display:flex;gap:10px"><span
                    style="color:var(--accent);font-weight:700">→</span>Fixed‑price projects with clear scope</div>
                <div style="font-size:13px;color:var(--text-2);display:flex;gap:10px"><span
                    style="color:var(--accent);font-weight:700">→</span>Time &amp; material for evolving products</div>
                <div style="font-size:13px;color:var(--text-2);display:flex;gap:10px"><span
                    style="color:var(--accent);font-weight:700">→</span>Dedicated squads as an extension of your team
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

  <?php include __DIR__ . '/includes/footer.php'; ?>
  <?php include __DIR__ . '/includes/scripts.php'; ?>

</body>

</html>
