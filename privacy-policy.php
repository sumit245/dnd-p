<?php
require __DIR__ . '/includes/config.php';
$page['title']       = 'Privacy Policy — ' . SITE_NAME;
$page['description'] = 'Privacy policy for Dashandots Technology. Learn how we collect, use, and protect your personal information.';
$page['canonical']   = SITE_URL . '/privacy-policy';
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
      <h1>Privacy Policy</h1>
      <p class="meta">Last updated: 25 April 2026 &nbsp;·&nbsp; Effective immediately &nbsp;·&nbsp; Applies to <a
          href="https://dashandots.com">dashandots.com</a></p>

      <div class="highlight-box">
        <p>Dashandots Technology respects your privacy. This policy explains what information we collect when you visit
          our website or submit an enquiry, and how we use it.</p>
      </div>

      <h2>1. Who We Are</h2>
      <p>Dashandots Technology ("Dashandots", "we", "us", "our") is a software development and technology consulting
        company based in India. Our website is <a href="https://dashandots.com">dashandots.com</a>. For privacy-related
        queries, use the contact form or email us<?php if (defined('SITE_EMAIL') && SITE_EMAIL !== ''): ?> at <a href="mailto:<?= htmlspecialchars(SITE_EMAIL, ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars(SITE_EMAIL) ?></a><?php endif; ?>.</p>

      <h2>2. Information We Collect</h2>
      <h3>Information you provide directly</h3>
      <p>When you submit an enquiry via our contact form, we collect:</p>
      <ul>
        <li>Your name</li>
        <li>Your email address</li>
        <li>Your company name (optional)</li>
        <li>Your phone number (optional)</li>
        <li>The service you are interested in</li>
        <li>The message or project description you submit</li>
      </ul>
      <h3>Information collected automatically</h3>
      <p>With your consent, we use Google Tag Manager (GTM) to load analytics tools that help us understand how visitors
        use the site (for example page views and Core Web Vitals). If you choose “Essential only,” GTM may still load but
        analytics storage remains disabled until you accept analytics cookies. We do not use advertising or remarketing
        pixels. Google Fonts may log your IP address per Google's privacy policy.</p>

      <h2>3. How We Use Your Information</h2>
      <p>We use the information you submit via the contact form solely to:</p>
      <ul>
        <li>Respond to your enquiry about our services</li>
        <li>Send you an automatic confirmation email acknowledging receipt</li>
        <li>Follow up on your project requirements</li>
      </ul>
      <p>We do not use your information for marketing without your explicit consent, and we do not sell, rent, or share
        your personal data with third parties.</p>

      <h2>4. Data Storage and Security</h2>
      <p>Enquiry data submitted through our contact form is transmitted via encrypted SMTP (TLS) to our business email
        business inbox (hosted by Google Workspace / Gmail). We do not store form submissions in a
        database. Your data is subject to Google's data protection practices.</p>
      <p>We take reasonable technical precautions — including HTTPS, input sanitization, and access controls — to protect
        data in transit.</p>

      <h2>5. Data Retention</h2>
      <p>We retain email correspondence (including enquiry data) for as long as reasonably necessary to fulfil the purpose
        for which it was collected — typically for the duration of a business relationship and up to 3 years thereafter
        for record-keeping purposes.</p>

      <h2>6. Your Rights</h2>
      <p>Depending on your jurisdiction, you may have the right to:</p>
      <ul>
        <li>Request access to the personal data we hold about you</li>
        <li>Request correction of inaccurate data</li>
        <li>Request deletion of your data</li>
        <li>Object to or restrict our processing of your data</li>
      </ul>
      <p>To exercise any of these rights, use the contact form<?php if (defined('SITE_EMAIL') && SITE_EMAIL !== ''): ?> or email us at <a href="mailto:<?= htmlspecialchars(SITE_EMAIL, ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars(SITE_EMAIL) ?></a><?php endif; ?>. We
        will respond within 30 days.</p>

      <h2 id="cookies">7. Cookies</h2>
      <p>We show a cookie banner on first visit. Your choice is stored in your browser (localStorage) as
        <code>dashandots_consent_v1</code>. “Accept analytics” enables analytics cookies via Google Consent Mode; “Essential
        only” keeps analytics disabled. We do not set advertising cookies. Session cookies may be used for admin login
        only. Google Fonts may use browser cache entries.</p>

      <h2>8. Third-Party Links</h2>
      <p>Our website contains links to LinkedIn, Twitter/X, and GitHub. These are external sites with their own privacy
        policies. We are not responsible for their practices.</p>

      <h2>9. Children's Privacy</h2>
      <p>Our services are not directed at children under the age of 16. We do not knowingly collect personal data from
        children.</p>

      <h2>10. Changes to This Policy</h2>
      <p>We may update this policy from time to time. The "Last updated" date at the top of this page reflects the most
        recent revision. Continued use of our website after changes constitutes acceptance of the updated policy.</p>

      <h2>11. Contact</h2>
      <p>For any privacy-related questions or requests, please contact:</p>
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
