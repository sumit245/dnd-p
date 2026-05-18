<?php
require __DIR__ . '/../../includes/config.php';

$page['title']       = 'IoT & Embedded Software Development Services in India | Dashandots';
$page['description'] = 'Custom IoT platform development, firmware engineering and device-cloud connectivity for industrial, agricultural and consumer IoT products in India.';
$page['canonical']   = SITE_URL . '/services/iot-embedded/';
$page['og_title']    = 'IoT & Embedded Software Development | Dashandots Technology';
$page['og_desc']     = $page['description'];

require __DIR__ . '/../../includes/head.php';
require __DIR__ . '/../../includes/header.php';
?>

<main id="main-content">
  <div class="svc-page">

    <!-- HERO -->
    <div class="svc-hero">
      <p class="page-label">IoT &amp; Embedded Software</p>
      <h1>Connect Your Physical World to the Digital — Reliably and at Scale</h1>
      <p class="lead">From firmware on the chip to the cloud platform and the mobile app your customer uses to monitor it — we engineer the full IoT stack, so your connected product works the way you imagined it.</p>
      <div class="hero-actions">
        <a href="<?= BASE_PATH ?>/#contact" class="btn btn-primary">Discuss Your IoT Project</a>
        <a href="<?= BASE_PATH ?>/#portfolio" class="btn btn-outline">See Our Work</a>
      </div>
    </div>

    <!-- WHY US -->
    <h2>End-to-End IoT Development — One Team, Every Layer</h2>
    <p class="svc-body-text">Most IoT projects fail because firmware engineers, cloud architects, and app developers don't talk to each other. We're a single team that works across all three layers simultaneously — which means protocols are chosen correctly up front, edge constraints are respected in the cloud design, and the app is built for real device data, not mock data.</p>

    <div class="svc-feature-grid">
      <div class="svc-feature-card">
        <h3>Firmware &amp; Embedded C/C++</h3>
        <p>Lean, reliable firmware for ESP32, STM32, Arduino, Raspberry Pi, and custom PCBs. We write code that runs on constrained hardware without leaking memory or hanging.</p>
      </div>
      <div class="svc-feature-card">
        <h3>Device-Cloud Connectivity</h3>
        <p>MQTT, CoAP, HTTP/2, and WebSockets over WiFi, LTE, LoRaWAN, and BLE — we choose the right protocol for your power budget, bandwidth, and latency requirements.</p>
      </div>
      <div class="svc-feature-card">
        <h3>IoT Cloud Platform</h3>
        <p>Device registry, telemetry ingestion, rule engine, command dispatch, OTA update management, and a REST API for your application layer — all on AWS IoT or Azure IoT, or a custom open-source stack.</p>
      </div>
      <div class="svc-feature-card">
        <h3>Real-Time Dashboards</h3>
        <p>Live device monitoring with time-series charts, threshold alerts, geofencing, fleet maps, and historical data export — accessible from web and mobile.</p>
      </div>
      <div class="svc-feature-card">
        <h3>OTA Firmware Updates</h3>
        <p>Rollout updates to thousands of devices in the field without a service visit. Staged rollouts, rollback capability, and update success tracking included.</p>
      </div>
      <div class="svc-feature-card">
        <h3>Security from Day One</h3>
        <p>TLS/mTLS for all device communications, unique device certificates, encrypted storage on-chip, and cloud-side anomaly detection for compromised devices.</p>
      </div>
    </div>

    <!-- SOLUTIONS -->
    <h2>IoT Solutions We Build</h2>
    <ul class="svc-includes">
      <li>Industrial equipment monitoring &amp; predictive maintenance</li>
      <li>Cold chain &amp; temperature monitoring systems</li>
      <li>Smart energy metering &amp; power monitoring</li>
      <li>GPS tracking devices &amp; fleet telemetry platforms</li>
      <li>Agricultural IoT (soil sensors, irrigation automation, weather stations)</li>
      <li>Smart building &amp; facility management systems</li>
      <li>Water quality &amp; environmental monitoring</li>
      <li>Healthcare device connectivity (patient monitoring, asset tracking)</li>
      <li>Consumer IoT product firmware (wearables, smart home)</li>
      <li>Custom BLE device apps (iOS &amp; Android)</li>
      <li>LoRaWAN network setup &amp; gateway management</li>
      <li>Device provisioning &amp; zero-touch onboarding systems</li>
    </ul>

    <!-- EMBEDDED -->
    <h2>Embedded Software &amp; Hardware-Adjacent Work</h2>
    <p class="svc-body-text">Beyond IoT platforms, we take on embedded software projects where the software has to live close to hardware — real-time constraints, low power budgets, and hardware-specific peripherals.</p>
    <ul class="svc-includes">
      <li>RTOS-based firmware (FreeRTOS, Zephyr)</li>
      <li>Bootloader development &amp; secure boot</li>
      <li>Device driver development for custom peripherals</li>
      <li>Communication protocol implementation (Modbus, CANbus, RS-485)</li>
      <li>PCB bring-up and hardware debugging support</li>
      <li>Python/Rust applications on embedded Linux (Yocto, Buildroot)</li>
    </ul>

    <!-- INDUSTRIES -->
    <h2>Industries We Serve</h2>
    <div class="svc-feature-grid">
      <div class="svc-feature-card">
        <h3>Manufacturing</h3>
        <p>Machine uptime monitoring, OEE dashboards, predictive maintenance alerts, and production line telemetry for Industry 4.0 adoption.</p>
      </div>
      <div class="svc-feature-card">
        <h3>Agriculture</h3>
        <p>Soil moisture, temperature, and humidity sensing networks with automated irrigation triggers and crop advisory dashboards for farmers.</p>
      </div>
      <div class="svc-feature-card">
        <h3>Logistics &amp; Cold Chain</h3>
        <p>Real-time temperature and humidity monitoring for pharmaceutical, food, and chemical transport with automated breach alerts.</p>
      </div>
      <div class="svc-feature-card">
        <h3>Energy &amp; Utilities</h3>
        <p>Smart metering, load monitoring, DG performance tracking, and solar generation analytics for commercial and industrial facilities.</p>
      </div>
    </div>

    <!-- HOW WE WORK -->
    <h2>How We Approach IoT Projects</h2>
    <ul class="svc-includes">
      <li>Hardware selection guidance — we help you choose the right modules and connectivity for your deployment environment</li>
      <li>Architecture review — we validate protocol choices, cloud costs, and edge vs cloud compute split before you commit</li>
      <li>Firmware prototype — working device communicating with the cloud in the first sprint</li>
      <li>Cloud platform build — telemetry pipeline, device management, alerting, and APIs</li>
      <li>Dashboard &amp; mobile app — the interface your operators or end-customers will use daily</li>
      <li>Field deployment support — we help with provisioning, testing, and scaling to production</li>
      <li>Ongoing support — firmware bug fixes, cloud infrastructure scaling, feature additions</li>
    </ul>

    <!-- CTA -->
    <div class="svc-cta-strip">
      <p class="page-label">Ready to Connect Your Hardware?</p>
      <h2>Let's Engineer Your IoT Product Together</h2>
      <p>Whether you have hardware already chosen or are starting from a concept, we can take your connected product from prototype to production-scale deployment.</p>
      <div class="hero-actions" style="justify-content:center; margin-top:24px">
        <a href="<?= BASE_PATH ?>/#contact" class="btn btn-primary">Start the Conversation</a>
        <a href="<?= BASE_PATH ?>/#portfolio" class="btn btn-outline">View Portfolio</a>
      </div>
    </div>

  </div>
</main>

<?php require __DIR__ . '/../../includes/footer.php'; ?>
<?php require __DIR__ . '/../../includes/scripts.php'; ?>
