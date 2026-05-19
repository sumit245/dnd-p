<?php
require_once __DIR__ . '/layout/header.php';

$message = '';

// Handle Delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id']) && is_numeric($_POST['delete_id'])) {
    if (!csrf_verify()) {
        csrf_fail();
    }
    $id = (int) $_POST['delete_id'];
    try {
        $stmt = $pdo->prepare('DELETE FROM portfolios WHERE id = ?');
        $stmt->execute([$id]);
        $message = '<div class="alert alert-success">Portfolio item deleted successfully.</div>';
    } catch (PDOException $e) {
        error_log('Portfolio delete failed: ' . $e->getMessage());
        $message = '<div class="alert alert-error">Could not delete this item. Please try again.</div>';
    }
}

$stmt = $pdo->query('SELECT * FROM portfolios ORDER BY created_at DESC');
$portfolios = $stmt->fetchAll();
?>

<div class="page-header">
    <h1>Portfolios & Demos</h1>
    <a href="portfolio-form.php" class="btn btn-primary">+ Add New Portfolio</a>
</div>

<?php echo $message; ?>

<div class="card" style="padding: 0; overflow: hidden;">
    <table class="table">
        <thead style="background: var(--surface-2);">
            <tr>
                <th>Title</th>
                <th>Slug</th>
                <th>Demo URL</th>
                <th style="text-align: right;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($portfolios) > 0): ?>
                <?php foreach ($portfolios as $portfolio): ?>
                    <tr>
                        <td><strong><?php echo htmlspecialchars($portfolio['title']); ?></strong></td>
                        <td><code><?php echo htmlspecialchars($portfolio['slug']); ?></code></td>
                        <td>
                            <?php if ($portfolio['demo_url']): ?>
                                <a href="<?php echo htmlspecialchars($portfolio['demo_url']); ?>" target="_blank"><?php echo htmlspecialchars($portfolio['demo_url']); ?></a>
                            <?php else: ?>
                                <span style="color: var(--text-2);">None</span>
                            <?php endif; ?>
                        </td>
                        <td style="text-align: right;">
                            <div class="flex-actions" style="justify-content: flex-end;">
                                <a href="portfolio-form.php?id=<?php echo $portfolio['id']; ?>" class="btn btn-secondary">Edit</a>
                                <form method="post" style="display:inline" onsubmit="return confirm('Are you sure you want to delete this item?');">
                                    <?php csrf_field(); ?>
                                    <input type="hidden" name="delete_id" value="<?php echo (int) $portfolio['id']; ?>">
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" style="text-align: center; padding: 20px;">No portfolios found. Create one to get started.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/layout/footer.php'; ?>
