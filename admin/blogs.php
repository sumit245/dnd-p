<?php
require_once __DIR__ . '/layout/header.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id']) && is_numeric($_POST['delete_id'])) {
    if (!csrf_verify()) {
        csrf_fail();
    }
    $id = (int) $_POST['delete_id'];
    try {
        $stmt = $pdo->prepare('DELETE FROM blogs WHERE id = ?');
        $stmt->execute([$id]);
        $message = '<div class="alert alert-success">Blog post deleted successfully.</div>';
    } catch (PDOException $e) {
        error_log('Blog delete failed: ' . $e->getMessage());
        $message = '<div class="alert alert-error">Could not delete this post. Please try again.</div>';
    }
}

$stmt = $pdo->query('SELECT * FROM blogs ORDER BY created_at DESC');
$blogs = $stmt->fetchAll();
?>

<div class="page-header">
    <h1>Blogs</h1>
    <a href="blog-form.php" class="btn btn-primary">+ Create New Blog Post</a>
</div>

<?php echo $message; ?>

<div class="card" style="padding: 0; overflow: hidden;">
    <table class="table">
        <thead style="background: var(--surface-2);">
            <tr>
                <th>Title</th>
                <th>Status</th>
                <th>Created</th>
                <th style="text-align: right;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($blogs) > 0): ?>
                <?php foreach ($blogs as $blog): ?>
                    <tr>
                        <td><strong><?php echo htmlspecialchars($blog['title']); ?></strong><br><small style="color: var(--text-2);">/blog/post.php?slug=<?php echo htmlspecialchars($blog['slug']); ?></small></td>
                        <td>
                            <?php if ($blog['status'] === 'published'): ?>
                                <span style="background: #dcfce7; color: #166534; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold;">Published</span>
                            <?php else: ?>
                                <span style="background: #f1f5f9; color: #475569; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold;">Draft</span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo date('M j, Y', strtotime($blog['created_at'])); ?></td>
                        <td style="text-align: right;">
                            <div class="flex-actions" style="justify-content: flex-end;">
                                <?php if ($blog['status'] === 'published'): ?>
                                    <a href="../blog/post.php?slug=<?php echo $blog['slug']; ?>" target="_blank" class="btn btn-secondary">View</a>
                                <?php endif; ?>
                                <a href="blog-form.php?id=<?php echo $blog['id']; ?>" class="btn btn-primary" style="background: var(--text-2);">Edit</a>
                                <form method="post" style="display:inline" onsubmit="return confirm('Are you sure you want to delete this post?');">
                                    <?php csrf_field(); ?>
                                    <input type="hidden" name="delete_id" value="<?php echo (int) $blog['id']; ?>">
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" style="text-align: center; padding: 20px;">No blog posts found. Create one to get started.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/layout/footer.php'; ?>
