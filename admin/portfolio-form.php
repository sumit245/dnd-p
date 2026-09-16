<?php
require_once __DIR__ . '/layout/header.php';
require_once __DIR__ . '/../includes/portfolio-taxonomy.php';

$message = '';
$isEdit = isset($_GET['id']) && is_numeric($_GET['id']);
$id = $isEdit ? $_GET['id'] : null;

// Default values
$portfolio = [
    'title' => '',
    'slug' => '',
    'category' => 'web',
    'industry' => '',
    'badge' => '',
    'sort_order' => 100,
    'short_description' => '',
    'client_name' => '',
    'client_url' => '',
    'tile_color' => '',
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
        'category' => in_array($_POST['category'] ?? '', ['erp', 'tms', 'hms', 'web', 'mobile'], true) ? $_POST['category'] : 'web',
        'industry' => portfolio_industry_is_valid($_POST['industry'] ?? null) ? $_POST['industry'] : null,
        'badge' => trim($_POST['badge'] ?? ''),
        'sort_order' => (int)($_POST['sort_order'] ?? 100),
        'client_name' => trim($_POST['client_name'] ?? ''),
        'client_url' => filter_var(trim($_POST['client_url'] ?? ''), FILTER_VALIDATE_URL) ?: null,
        'tile_color' => preg_match('/^#[0-9A-Fa-f]{6}$/', trim($_POST['tile_color'] ?? '')) ? strtoupper(trim($_POST['tile_color'])) : null,
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
            $stmt = $pdo->prepare('UPDATE portfolios SET title=?, slug=?, category=?, industry=?, badge=?, sort_order=?, client_name=?, client_url=?, tile_color=?, short_description=?, detailed_description=?, demo_url=?, username=?, password=?, image_path=?, gallery_images=? WHERE id=?');
            $stmt->execute([
                $portfolio['title'], $portfolio['slug'], $portfolio['category'], $portfolio['industry'], $portfolio['badge'], $portfolio['sort_order'],
                $portfolio['client_name'], $portfolio['client_url'], $portfolio['tile_color'], $portfolio['short_description'],
                $portfolio['detailed_description'], $portfolio['demo_url'], $portfolio['username'],
                $portfolio['password'], $portfolio['image_path'], $portfolio['gallery_images'], $id
            ]);
            $message = '<div class="alert alert-success">Portfolio updated successfully.</div>';
        } else {
            $stmt = $pdo->prepare('INSERT INTO portfolios (title, slug, category, industry, badge, sort_order, client_name, client_url, tile_color, short_description, detailed_description, demo_url, username, password, image_path, gallery_images) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
            $stmt->execute([
                $portfolio['title'], $portfolio['slug'], $portfolio['category'], $portfolio['industry'], $portfolio['badge'], $portfolio['sort_order'],
                $portfolio['client_name'], $portfolio['client_url'], $portfolio['tile_color'], $portfolio['short_description'],
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

        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label for="category">Category (portfolio filter) *</label>
                <select id="category" name="category" class="form-control">
                    <?php foreach (['erp' => 'ERP / CRM', 'tms' => 'Transport & Logistics', 'hms' => 'Healthcare (HMS)', 'web' => 'Web & SaaS', 'mobile' => 'Mobile Apps'] as $catVal => $catLabel): ?>
                        <option value="<?php echo $catVal; ?>" <?php echo ($portfolio['category'] ?? 'web') === $catVal ? 'selected' : ''; ?>><?php echo $catLabel; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="badge">Card badge</label>
                <input type="text" id="badge" name="badge" class="form-control" value="<?php echo htmlspecialchars($portfolio['badge'] ?? ''); ?>" placeholder="e.g. CRM, HRMS, ANDROID">
                <small style="color: var(--text-2);">Short label on the thumbnail. Blank = slug in caps.</small>
            </div>
            <div class="form-group">
                <label for="sort_order">Sort order</label>
                <input type="number" id="sort_order" name="sort_order" class="form-control" value="<?php echo (int)($portfolio['sort_order'] ?? 100); ?>">
                <small style="color: var(--text-2);">Lower shows first. Top 6 appear on the home page.</small>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label for="industry">Industry (portfolio page filter)</label>
                <select id="industry" name="industry" class="form-control">
                    <option value="">— none —</option>
                    <?php foreach (portfolio_industries() as $indVal => $indLabel): ?>
                        <option value="<?php echo $indVal; ?>" <?php echo ($portfolio['industry'] ?? '') === $indVal ? 'selected' : ''; ?>><?php echo htmlspecialchars($indLabel); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="client_name">Client name</label>
                <input type="text" id="client_name" name="client_name" class="form-control" value="<?php echo htmlspecialchars($portfolio['client_name'] ?? ''); ?>" placeholder="e.g. Sugs Lloyd Limited">
            </div>
            <div class="form-group">
                <label for="client_url">Client website</label>
                <input type="url" id="client_url" name="client_url" class="form-control" value="<?php echo htmlspecialchars($portfolio['client_url'] ?? ''); ?>" placeholder="https://">
                <small style="color: var(--text-2);">Card links here when there is no demo page.</small>
            </div>
            <div class="form-group">
                <label for="tile_color">Tile colour</label>
                <input type="color" id="tile_color" name="tile_color" class="form-control" value="<?php echo htmlspecialchars($portfolio['tile_color'] ?: '#C8293E'); ?>">
                <small style="color: var(--text-2);">Used when no screenshot is set.</small>
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
