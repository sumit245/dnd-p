<?php
require_once __DIR__ . '/layout/header.php';

$message = '';
$isEdit = isset($_GET['id']) && is_numeric($_GET['id']);
$id = $isEdit ? $_GET['id'] : null;

// Default values
$portfolio = [
    'title' => '',
    'slug' => '',
    'short_description' => '',
    'detailed_description' => '',
    'demo_url' => '',
    'username' => '',
    'password' => '',
    'image_path' => '',
    'gallery_images' => ''
];

if ($isEdit) {
    $stmt = $pdo->prepare('SELECT * FROM portfolios WHERE id = ?');
    $stmt->execute([$id]);
    $existing = $stmt->fetch();
    if ($existing) {
        $portfolio = $existing;
    } else {
        $isEdit = false;
        $id = null;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_verify()) {
        csrf_fail();
    }
    $portfolio = [
        'title' => $_POST['title'] ?? '',
        'slug' => $_POST['slug'] ?? '',
        'short_description' => $_POST['short_description'] ?? '',
        'detailed_description' => $_POST['detailed_description'] ?? '',
        'demo_url' => $_POST['demo_url'] ?? '',
        'username' => $_POST['username'] ?? '',
        'password' => $_POST['password'] ?? '',
        'image_path' => $_POST['image_path'] ?? '',
        'gallery_images' => $_POST['gallery_images'] ?? ''
    ];

    try {
        if ($isEdit) {
            $stmt = $pdo->prepare('UPDATE portfolios SET title=?, slug=?, short_description=?, detailed_description=?, demo_url=?, username=?, password=?, image_path=?, gallery_images=? WHERE id=?');
            $stmt->execute([
                $portfolio['title'], $portfolio['slug'], $portfolio['short_description'],
                $portfolio['detailed_description'], $portfolio['demo_url'], $portfolio['username'],
                $portfolio['password'], $portfolio['image_path'], $portfolio['gallery_images'], $id
            ]);
            $message = '<div class="alert alert-success">Portfolio updated successfully.</div>';
        } else {
            $stmt = $pdo->prepare('INSERT INTO portfolios (title, slug, short_description, detailed_description, demo_url, username, password, image_path, gallery_images) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
            $stmt->execute([
                $portfolio['title'], $portfolio['slug'], $portfolio['short_description'],
                $portfolio['detailed_description'], $portfolio['demo_url'], $portfolio['username'],
                $portfolio['password'], $portfolio['image_path'], $portfolio['gallery_images']
            ]);
            $id = $pdo->lastInsertId();
            $isEdit = true;
            $message = '<div class="alert alert-success">Portfolio created successfully.</div>';
        }
    } catch (PDOException $e) {
        $message = '<div class="alert alert-error">Error saving portfolio: ' . htmlspecialchars($e->getMessage()) . '</div>';
    }
}
?>

<div class="page-header">
    <h1><?php echo $isEdit ? 'Edit Portfolio' : 'Add New Portfolio'; ?></h1>
    <a href="portfolios.php" class="btn btn-secondary">Back to List</a>
</div>

<?php echo $message; ?>

<div class="card">
    <form method="POST" action="<?php echo $isEdit ? '?id='.$id : ''; ?>">
        <?php csrf_field(); ?>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label for="title">Title *</label>
                <input type="text" id="title" name="title" class="form-control" value="<?php echo htmlspecialchars($portfolio['title']); ?>" required>
            </div>
            <div class="form-group">
                <label for="slug">Slug (URL identifier) *</label>
                <input type="text" id="slug" name="slug" class="form-control" value="<?php echo htmlspecialchars($portfolio['slug']); ?>" required>
                <small style="color: var(--text-2);">e.g., erp, tms, hms</small>
            </div>
        </div>

        <div class="form-group">
            <label for="short_description">Short Description (For Homepage Grid) *</label>
            <textarea id="short_description" name="short_description" class="form-control" rows="3" required><?php echo htmlspecialchars($portfolio['short_description']); ?></textarea>
        </div>
        
        <div class="form-group">
            <label for="detailed_description">Detailed Description (For Demo Viewer)</label>
            <!-- TinyMCE Rich Text Editor -->
            <textarea id="detailed_description" name="detailed_description" class="form-control richtext"><?php echo htmlspecialchars($portfolio['detailed_description']); ?></textarea>
        </div>

        <hr style="border: 0; border-top: 1px solid var(--border); margin: 30px 0;">
        <h3>Demo & Credentials</h3>

        <div class="form-group">
            <label for="demo_url">Demo URL</label>
            <input type="url" id="demo_url" name="demo_url" class="form-control" value="<?php echo htmlspecialchars($portfolio['demo_url']); ?>">
            <small style="color: var(--text-2);">The actual URL where the demo is hosted (e.g., https://erp.dashandots.com/login)</small>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label for="username">Demo Username</label>
                <input type="text" id="username" name="username" class="form-control" value="<?php echo htmlspecialchars($portfolio['username']); ?>">
            </div>
            <div class="form-group">
                <label for="password">Demo Password</label>
                <input type="text" id="password" name="password" class="form-control" value="<?php echo htmlspecialchars($portfolio['password']); ?>">
            </div>
        </div>

        <div class="form-group">
            <label for="image_path">Cover Image URL <small style="font-weight:400;color:var(--text-2)">(main / hero screenshot)</small></label>
            <input type="text" id="image_path" name="image_path" class="form-control" value="<?php echo htmlspecialchars($portfolio['image_path']); ?>">
            <small style="color: var(--text-2);">Absolute or relative URL to the primary cover image shown large on the demo page.</small>
        </div>

        <div class="form-group">
            <label for="gallery_images">Gallery Screenshots <small style="font-weight:400;color:var(--text-2)">(4–6 secondary images)</small></label>
            <textarea id="gallery_images" name="gallery_images" class="form-control" rows="4" placeholder="One URL per line or comma-separated. E.g.:&#10;http://localhost/dashandots/assets/img/erp-inventory.png&#10;http://localhost/dashandots/assets/img/erp-sales.png"><?php echo htmlspecialchars($portfolio['gallery_images'] ?? ''); ?></textarea>
            <small style="color: var(--text-2);">Enter one image URL per line (or comma-separated). These appear as thumbnails beside the main image on the demo page. 4–6 images recommended.</small>
        </div>

        <button type="submit" class="btn btn-primary">Save Portfolio</button>
    </form>
</div>

<?php require_once __DIR__ . '/layout/footer.php'; ?>
