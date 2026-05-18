<?php
require __DIR__ . '/includes/config.php';
$page['title']       = 'Page Not Found — ' . SITE_NAME;
$page['description'] = 'The page you are looking for could not be found.';
$page['canonical']   = SITE_URL . '/404';
$page['active_nav']  = '';
$page['robots']      = 'noindex';
http_response_code(404);
?>
<!DOCTYPE html>
<html lang="en">

<head>
<?php include __DIR__ . '/includes/head.php'; ?>
</head>

<body>

<?php include __DIR__ . '/includes/header.php'; ?>

  <main id="main-content">
    <div class="page-wrap" style="text-align:center; padding-top:100px; padding-bottom:120px">
      <p class="page-label">Error 404</p>
      <h1 style="font-size:clamp(48px, 8vw, 96px); margin-bottom:24px; opacity:.15">404</h1>
      <h2 style="font-size:24px; font-weight:700; margin-bottom:12px">Page not found</h2>
      <p style="color:var(--text-2); margin-bottom:32px">The page you're looking for doesn't exist, has been moved, or was never here to begin with.</p>
      <a href="<?= BASE_PATH ?>/" class="btn btn-primary">Back to Home</a>
    </div>
  </main>

<?php include __DIR__ . '/includes/footer.php'; ?>
<?php include __DIR__ . '/includes/scripts.php'; ?>

</body>

</html>
