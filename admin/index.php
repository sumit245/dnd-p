<?php
require_once __DIR__ . '/layout/header.php';

// Fetch some basic stats
$blogsCount = $pdo->query('SELECT COUNT(*) FROM blogs')->fetchColumn();
$portfoliosCount = $pdo->query('SELECT COUNT(*) FROM portfolios')->fetchColumn();
?>

<div class="page-header">
    <h1>Dashboard</h1>
</div>

<div class="card">
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['admin_username']); ?>!</h2>
    <p>Use the sidebar navigation to manage your website content.</p>
</div>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
    <div class="card">
        <h3>Blogs</h3>
        <p style="font-size: 32px; font-weight: bold; color: var(--accent); margin: 10px 0;"><?php echo $blogsCount; ?></p>
        <p>Total published and draft articles.</p>
        <a href="blogs.php" class="btn btn-secondary">Manage Blogs</a>
    </div>
    
    <div class="card">
        <h3>Portfolios & Demos</h3>
        <p style="font-size: 32px; font-weight: bold; color: var(--accent); margin: 10px 0;"><?php echo $portfoliosCount; ?></p>
        <p>Total portfolio items managed.</p>
        <a href="portfolios.php" class="btn btn-secondary">Manage Portfolios</a>
    </div>
</div>

<?php require_once __DIR__ . '/layout/footer.php'; ?>
