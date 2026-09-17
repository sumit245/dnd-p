<?php
/**
 * Copywriting audit — update the 3 homepage texts stored in `site_settings`.
 *
 * Idempotent. Run locally and on production:
 *   php scripts/update-copywriting-audit.php
 *
 * Only hero_title and hero_description change; about_us_text is left as-is.
 */
declare(strict_types=1);

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/db.php';

$updates = [
    'hero_title'       => 'Your operations, centralised. Your data, visible. Your team, faster.',
    'hero_description' => 'Dashandots builds custom ERP, CRM, dashboards, portals, and mobile apps for growing Indian businesses — scoped around how you actually work, owned by you, supported after launch.',
];

$select = $pdo->prepare('SELECT value FROM site_settings WHERE key_name = ?');
$update = $pdo->prepare('UPDATE site_settings SET value = ? WHERE key_name = ?');
$insert = $pdo->prepare('INSERT INTO site_settings (key_name, value) VALUES (?, ?)');

foreach ($updates as $key => $value) {
    $select->execute([$key]);
    $current = $select->fetchColumn();

    if ($current === false) {
        $insert->execute([$key, $value]);
        echo "[insert] {$key}\n  -> {$value}\n";
        continue;
    }
    if ((string)$current === $value) {
        echo "[skip]   {$key} already up to date\n";
        continue;
    }
    $update->execute([$value, $key]);
    echo "[update] {$key}\n  was: {$current}\n  now: {$value}\n";
}
echo "Done.\n";
