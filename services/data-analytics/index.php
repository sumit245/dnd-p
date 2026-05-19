<?php
require __DIR__ . '/../../includes/config.php';

$page['title']       = 'Data Analytics, BI & AI Solutions in India | Dashandots';
$page['description'] = 'Custom analytics dashboards, BI reporting and AI-assisted workflows for Indian businesses. Turn raw data into clear, decision-ready insights your leadership can act on.';
$page['canonical']   = SITE_URL . '/services/data-analytics/';
$page['og_title']    = 'Data Analytics & AI Solutions | Dashandots Technology';
$page['og_desc']     = $page['description'];

require __DIR__ . '/../../includes/head.php';
require __DIR__ . '/../../includes/header.php';
?>

<main id="main-content">
  <div class="svc-page">

    <!-- HERO -->
    <div class="svc-hero">
      <p class="page-label">Data Analytics &amp; AI</p>
      <h1>Turn your business data into decisions your leadership can act on</h1>
      <p class="lead">We build real-time analytics dashboards, automated reporting pipelines, and AI-assisted tools that give leadership reliable visibility across operations, finance, sales, and customer activity.</p>
      <div class="hero-actions">
        <a href="<?= BASE_PATH ?>/#contact" class="btn btn-primary" data-track="cta" data-cta-location="analytics-hero">Get Dashboard Scope</a>
        <a href="<?= BASE_PATH ?>/#ai-brief" class="btn btn-outline" data-track="cta" data-cta-location="analytics-hero">Get Instant Estimate</a>
      </div>
    </div>

    <!-- THE PROBLEM -->
    <h2>The data problem most growing businesses face</h2>
    <p class="svc-body-text">Business data often sits across ERP, e-commerce, CRM, accounting, and operational systems. By the time reports are consolidated manually, leadership is working from delayed information. We unify those sources, automate the pipelines, and present decision-ready insights in real-time dashboards.</p>

    <div class="svc-feature-grid">
      <div class="svc-feature-card">
        <h3>Single source of truth</h3>
        <p>We aggregate data from your ERP, CRM, sales tools, and databases into one clean data warehouse — eliminating the "which report is correct?" problem.</p>
      </div>
      <div class="svc-feature-card">
        <h3>Real-time dashboards</h3>
        <p>Live KPI screens refreshed every few seconds. Drill down from company-level to branch, team, or individual — all without waiting for someone to run a query.</p>
      </div>
      <div class="svc-feature-card">
        <h3>Automated reporting</h3>
        <p>Daily, weekly, and monthly reports delivered to the right inboxes automatically, reducing manual exports, missed deadlines, and reporting errors.</p>
      </div>
      <div class="svc-feature-card">
        <h3>Predictive forecasting</h3>
        <p>ML models trained on your historical data to forecast demand, predict churn, flag slow-moving inventory, and surface sales opportunities before they expire.</p>
      </div>
      <div class="svc-feature-card">
        <h3>AI-assisted workflows</h3>
        <p>LLM-powered features inside your internal tools — auto-summarise customer notes, classify tickets, extract data from documents, draft personalised communications.</p>
      </div>
      <div class="svc-feature-card">
        <h3>Anomaly detection</h3>
        <p>Automatic alerts when metrics deviate from expected ranges — unusual spikes in returns, drops in conversion, cost overruns — before they become crises.</p>
      </div>
    </div>

    <!-- SOLUTIONS -->
    <h2>Solutions we build</h2>
    <ul class="svc-includes">
      <li>Executive KPI dashboards (revenue, margins, operational metrics)</li>
      <li>Sales pipeline analytics &amp; forecasting</li>
      <li>Inventory &amp; supply chain analytics</li>
      <li>Customer behaviour &amp; cohort analysis</li>
      <li>Fleet &amp; logistics performance dashboards</li>
      <li>Financial reporting automation (P&amp;L, cash flow, budget vs actuals)</li>
      <li>HR &amp; workforce analytics</li>
      <li>Marketing attribution &amp; campaign performance tracking</li>
      <li>ETL pipelines &amp; data warehouse setup</li>
      <li>AI document processing (invoices, purchase orders, contracts)</li>
      <li>Chatbot &amp; NLP-powered internal tools</li>
      <li>Custom ML model development &amp; deployment</li>
    </ul>

    <div class="svc-cta-strip">
      <p class="page-label">Common dashboard starting points</p>
      <h2>Start with the report your leadership asks for every week.</h2>
      <p>Most dashboard builds begin by automating one painful report: sales pipeline, stock aging, branch profitability, dispatch performance, finance summary, or customer follow-up health.</p>
      <div class="hero-actions" style="justify-content:center; margin-top:24px">
        <a href="<?= BASE_PATH ?>/#contact" class="btn btn-primary" data-track="cta" data-cta-location="analytics-mid">Scope my dashboard</a>
        <a href="<?= BASE_PATH ?>/#portfolio" class="btn btn-outline" data-track="cta" data-cta-location="analytics-mid">See Dashboard Proof</a>
      </div>
    </div>

    <!-- TECH STACK -->
    <h2>Technology &amp; tools we use</h2>
    <div class="svc-feature-grid">
      <div class="svc-feature-card">
        <h3>Data visualisation</h3>
        <p>Custom React dashboards with Recharts, D3.js, or Apache ECharts — or Metabase / Grafana for teams that prefer no-code dashboards.</p>
      </div>
      <div class="svc-feature-card">
        <h3>Data engineering</h3>
        <p>Python (Pandas, SQLAlchemy), Apache Airflow for pipeline orchestration, PostgreSQL &amp; MySQL as data warehouses, Redis for real-time caching.</p>
      </div>
      <div class="svc-feature-card">
        <h3>Machine learning</h3>
        <p>Scikit-learn, XGBoost, TensorFlow, and PyTorch for predictive models. MLflow for experiment tracking and model versioning.</p>
      </div>
      <div class="svc-feature-card">
        <h3>AI &amp; LLM Integration</h3>
        <p>OpenAI GPT, Anthropic Claude, and open-source LLMs (Mistral, LLaMA) via API — embedded into your workflows, not bolted on as a chatbot nobody uses.</p>
      </div>
    </div>

    <!-- HOW WE WORK -->
    <h2>Our engagement process</h2>
    <ul class="svc-includes">
      <li>Data audit — we map every data source, its format, quality, and access method</li>
      <li>KPI workshop — we work with leadership to define what success metrics matter most</li>
      <li>Pipeline architecture — design the ETL flow from sources to clean, queryable data</li>
      <li>Dashboard &amp; report prototyping — Figma mockups reviewed before any coding</li>
      <li>Build &amp; integrate — connect all data sources, build the visualisation layer</li>
      <li>Training &amp; handover — your team knows how to use and extend everything we build</li>
    </ul>

    <!-- CTA -->
    <div class="svc-cta-strip">
      <p class="page-label">Make decisions from current data</p>
      <h2>What could you do with clearer visibility into your operations?</h2>
      <p>Tell us what questions you can't answer today. We'll design a data solution that puts those answers in front of your team every morning.</p>
      <div class="hero-actions" style="justify-content:center; margin-top:24px">
        <a href="<?= BASE_PATH ?>/#contact" class="btn btn-primary" data-track="cta" data-cta-location="analytics-final">Get My Free Project Estimate</a>
        <a href="<?= BASE_PATH ?>/#ai-brief" class="btn btn-outline" data-track="cta" data-cta-location="analytics-final">Get Instant Estimate</a>
      </div>
    </div>

  </div>
</main>

<?php require __DIR__ . '/../../includes/footer.php'; ?>
<?php require __DIR__ . '/../../includes/scripts.php'; ?>
