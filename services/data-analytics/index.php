<?php
require __DIR__ . '/../../includes/config.php';

$page['title']       = 'Data Analytics, Business Intelligence & AI Solutions in India | Dashandots';
$page['description'] = 'Custom analytics dashboards, BI reporting and AI-assisted workflows for Indian businesses. Turn raw data into decisions that drive measurable growth.';
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
      <h1>Turn Your Business Data into Decisions That Drive Revenue</h1>
      <p class="lead">We build real-time analytics dashboards, automated reporting pipelines, and AI-assisted tools that give your team instant visibility — so decisions are made on facts, not gut feeling.</p>
      <div class="hero-actions">
        <a href="<?= BASE_PATH ?>/#contact" class="btn btn-primary">Talk to a Data Expert</a>
        <a href="<?= BASE_PATH ?>/#portfolio" class="btn btn-outline">See Dashboard Examples</a>
      </div>
    </div>

    <!-- THE PROBLEM -->
    <h2>The Data Problem Most Growing Businesses Face</h2>
    <p class="svc-body-text">Your ERP has data. Your e-commerce platform has data. Your CRM has data. Your accounts team has data in Excel. But nobody can see all of it in one place, and by the time a report reaches leadership, it's three days old. We solve exactly that — unifying your data sources, automating the pipelines, and presenting insights in real-time dashboards that actually get used.</p>

    <div class="svc-feature-grid">
      <div class="svc-feature-card">
        <h3>Single Source of Truth</h3>
        <p>We aggregate data from your ERP, CRM, sales tools, and databases into one clean data warehouse — eliminating the "which report is correct?" problem.</p>
      </div>
      <div class="svc-feature-card">
        <h3>Real-Time Dashboards</h3>
        <p>Live KPI screens refreshed every few seconds. Drill down from company-level to branch, team, or individual — all without waiting for someone to run a query.</p>
      </div>
      <div class="svc-feature-card">
        <h3>Automated Reporting</h3>
        <p>Daily, weekly, and monthly reports delivered to the right inboxes automatically. No manual Excel exports, no missed deadlines, no human error.</p>
      </div>
      <div class="svc-feature-card">
        <h3>Predictive Forecasting</h3>
        <p>ML models trained on your historical data to forecast demand, predict churn, flag slow-moving inventory, and surface sales opportunities before they expire.</p>
      </div>
      <div class="svc-feature-card">
        <h3>AI-Assisted Workflows</h3>
        <p>LLM-powered features inside your internal tools — auto-summarise customer notes, classify tickets, extract data from documents, draft personalised communications.</p>
      </div>
      <div class="svc-feature-card">
        <h3>Anomaly Detection</h3>
        <p>Automatic alerts when metrics deviate from expected ranges — unusual spikes in returns, drops in conversion, cost overruns — before they become crises.</p>
      </div>
    </div>

    <!-- SOLUTIONS -->
    <h2>Solutions We Build</h2>
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

    <!-- TECH STACK -->
    <h2>Technology &amp; Tools We Use</h2>
    <div class="svc-feature-grid">
      <div class="svc-feature-card">
        <h3>Data Visualisation</h3>
        <p>Custom React dashboards with Recharts, D3.js, or Apache ECharts — or Metabase / Grafana for teams that prefer no-code dashboards.</p>
      </div>
      <div class="svc-feature-card">
        <h3>Data Engineering</h3>
        <p>Python (Pandas, SQLAlchemy), Apache Airflow for pipeline orchestration, PostgreSQL &amp; MySQL as data warehouses, Redis for real-time caching.</p>
      </div>
      <div class="svc-feature-card">
        <h3>Machine Learning</h3>
        <p>Scikit-learn, XGBoost, TensorFlow, and PyTorch for predictive models. MLflow for experiment tracking and model versioning.</p>
      </div>
      <div class="svc-feature-card">
        <h3>AI &amp; LLM Integration</h3>
        <p>OpenAI GPT, Anthropic Claude, and open-source LLMs (Mistral, LLaMA) via API — embedded into your workflows, not bolted on as a chatbot nobody uses.</p>
      </div>
    </div>

    <!-- HOW WE WORK -->
    <h2>Our Engagement Process</h2>
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
      <p class="page-label">Start Making Data-Driven Decisions</p>
      <h2>What Would You Do if You Had Perfect Visibility?</h2>
      <p>Tell us what questions you can't answer today. We'll design a data solution that puts those answers in front of your team every morning.</p>
      <div class="hero-actions" style="justify-content:center; margin-top:24px">
        <a href="<?= BASE_PATH ?>/#contact" class="btn btn-primary">Book a Data Discovery Call</a>
        <a href="<?= BASE_PATH ?>/#portfolio" class="btn btn-outline">View Our Work</a>
      </div>
    </div>

  </div>
</main>

<?php require __DIR__ . '/../../includes/footer.php'; ?>
<?php require __DIR__ . '/../../includes/scripts.php'; ?>
