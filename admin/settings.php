<?php
require_once __DIR__ . '/layout/header.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_verify()) {
        csrf_fail();
    }
    $hero_title = $_POST['hero_title'] ?? '';
    $hero_description = $_POST['hero_description'] ?? '';
    $about_us_text = $_POST['about_us_text'] ?? '';

    try {
        $stmt = $pdo->prepare('UPDATE site_settings SET value = ? WHERE key_name = ?');
        $stmt->execute([$hero_title, 'hero_title']);
        $stmt->execute([$hero_description, 'hero_description']);
        $stmt->execute([$about_us_text, 'about_us_text']);
        
        $message = '<div class="alert alert-success">Settings updated successfully.</div>';
    } catch (PDOException $e) {
        $message = '<div class="alert alert-error">Error updating settings: ' . htmlspecialchars($e->getMessage()) . '</div>';
    }
}

// Fetch current settings
$settings = [];
$stmt = $pdo->query('SELECT key_name, value FROM site_settings');
while ($row = $stmt->fetch()) {
    $settings[$row['key_name']] = $row['value'];
}
?>

<div class="page-header">
    <h1>Site Settings</h1>
</div>

<?php echo $message; ?>

<div class="card">
    <form method="POST" action="">
        <?php csrf_field(); ?>
        <h3>Hero Section</h3>
        <div class="form-group">
            <label for="hero_title">Hero Title</label>
            <input type="text" id="hero_title" name="hero_title" class="form-control" value="<?php echo htmlspecialchars($settings['hero_title'] ?? ''); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="hero_description">Hero Description</label>
            <textarea id="hero_description" name="hero_description" class="form-control" rows="4" required><?php echo htmlspecialchars($settings['hero_description'] ?? ''); ?></textarea>
        </div>

        <hr style="border: 0; border-top: 1px solid var(--border); margin: 30px 0;">

        <h3>About Us Section</h3>
        <div class="form-group">
            <label for="about_us_text">About Us Text</label>
            <textarea id="about_us_text" name="about_us_text" class="form-control" rows="6" required><?php echo htmlspecialchars($settings['about_us_text'] ?? ''); ?></textarea>
        </div>
        
        <button type="submit" class="btn btn-primary">Save Settings</button>
    </form>
</div>

<?php require_once __DIR__ . '/layout/footer.php'; ?>
