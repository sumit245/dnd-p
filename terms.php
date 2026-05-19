<?php
require __DIR__ . '/includes/config.php';
$page['title']       = 'Terms of Service — ' . SITE_NAME;
$page['description'] = 'Read the terms of service for Dashandots Technology. Understand your rights and obligations when using our custom software development services.';
$page['canonical']   = SITE_URL . '/terms';
$page['og_title']    = $page['title'];
$page['active_nav']  = '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
<?php include __DIR__ . '/includes/head.php'; ?>
</head>

<body>

<?php include __DIR__ . '/includes/header.php'; ?>

  <main id="main-content">
    <div class="page-wrap">
      <p class="page-label">Legal</p>
      <h1>Terms of Service</h1>
      <p class="meta">Last updated: 25 April 2026 &nbsp;·&nbsp; Effective immediately &nbsp;·&nbsp; Applies to <a
          href="https://dashandots.com">dashandots.com</a></p>

      <div class="highlight-box">
        <p>These Terms of Service ("Terms") govern your access to and use of the website
          <a href="https://dashandots.com">dashandots.com</a> and any services provided by Dashandots Technology.
          By using our website or engaging our services, you agree to be bound by these Terms.</p>
      </div>

      <h2>1. About Dashandots Technology</h2>
      <p>Dashandots Technology ("Dashandots", "we", "us", "our") is a software development and technology consulting
        company based in India. We specialise in building custom enterprise software including ERP, CRM, TMS, HMS,
        web applications, and mobile applications.</p>

      <h2>2. Services</h2>
      <p>Dashandots provides custom software development, consulting, and technology services. The specific terms,
        scope, timeline, and pricing for any project are agreed upon in writing via a separate Statement of Work (SOW)
        or project proposal.</p>

      <h2>3. Intellectual Property</h2>
      <h3>Our website content</h3>
      <p>All content on this website — including text, graphics, logos, images, and code — is owned by
        Dashandots Technology and is protected by applicable intellectual property laws. You may not copy, reproduce,
        or redistribute any part of this website without our written consent.</p>
      <h3>Client project deliverables</h3>
      <p>Ownership of custom software deliverables is governed by the terms in the applicable project agreement or SOW.
        Unless otherwise stated in writing, upon full payment, the client receives ownership of the custom code
        developed specifically for their project.</p>

      <h2>4. Use of the Website</h2>
      <p>You agree to use our website only for lawful purposes and in a manner that does not infringe the rights of,
        restrict, or inhibit anyone else's use of the website. You may not:</p>
      <ul>
        <li>Use the site for any fraudulent or unlawful purpose</li>
        <li>Attempt to gain unauthorised access to our systems</li>
        <li>Introduce viruses or other malicious code</li>
        <li>Scrape, harvest, or extract data in bulk without permission</li>
      </ul>

      <h2>5. Contact Form and Enquiries</h2>
      <p>Information submitted through our contact form or project brief wizard is used solely to respond to your
        enquiry. By submitting an enquiry, you confirm that the information you provide is accurate and that you
        consent to being contacted by Dashandots regarding your request.</p>

      <h2>6. Limitation of Liability</h2>
      <p>This website and its content are provided "as is" without warranty of any kind, either express or implied.
        Dashandots Technology shall not be liable for any direct, indirect, incidental, or consequential damages
        arising from the use of or inability to use this website.</p>

      <h2>7. Third-Party Links</h2>
      <p>Our website may contain links to external websites (e.g., LinkedIn, Twitter/X, GitHub). These links are
        provided for convenience only. We do not endorse or accept responsibility for the content or practices of
        third-party websites.</p>

      <h2>8. Project Agreements</h2>
      <p>These Terms govern the use of our website only. The delivery of custom software services is governed by
        separate project agreements, which may include terms for:</p>
      <ul>
        <li>Project scope and deliverables</li>
        <li>Payment milestones and schedules</li>
        <li>Timelines and acceptance criteria</li>
        <li>Confidentiality and non-disclosure</li>
        <li>Warranties and support</li>
      </ul>

      <h2>9. Governing Law</h2>
      <p>These Terms shall be governed by and construed in accordance with the laws of India. Any disputes arising
        from these Terms shall be subject to the exclusive jurisdiction of the courts in India.</p>

      <h2>10. Changes to These Terms</h2>
      <p>We may update these Terms from time to time. The "Last updated" date at the top of this page reflects the
        most recent revision. Continued use of our website after changes constitutes acceptance of the updated Terms.</p>

      <h2>11. Contact</h2>
      <p>If you have any questions about these Terms, please contact:</p>
      <p><strong>Dashandots Technology</strong><br>
        <?php if (defined('SITE_EMAIL') && SITE_EMAIL !== ''): ?>Email: <a href="mailto:<?= htmlspecialchars(SITE_EMAIL, ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars(SITE_EMAIL) ?></a><br><?php endif; ?>
        <?php if (defined('SITE_ADDRESS') && SITE_ADDRESS !== ''): ?>Address: <?= htmlspecialchars(SITE_ADDRESS) ?><br><?php endif; ?>
        Website: <a href="https://dashandots.com">dashandots.com</a></p>
    </div>
  </main>

<?php include __DIR__ . '/includes/footer.php'; ?>
<?php include __DIR__ . '/includes/scripts.php'; ?>

</body>

</html>
