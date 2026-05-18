<?php
require_once __DIR__ . '/../../includes/security.php';
admin_session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/db.php';
csrf_ensure_token();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashandots CMS</title>
    <!-- TinyMCE CDN — key from .env TINY_MCE_API -->
    <script src="https://cdn.tiny.cloud/1/<?= htmlspecialchars($_ENV['TINY_MCE_API'] ?? 'no-api-key') ?>/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <style>
        :root {
            --surface-1: #ffffff;
            --surface-2: #f8fafc;
            --border: #e2e8f0;
            --accent: #0ea5e9;
            --accent-hover: #0284c7;
            --text-1: #0f172a;
            --text-2: #475569;
            --sidebar-width: 250px;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: var(--surface-2);
            color: var(--text-1);
            margin: 0;
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            width: var(--sidebar-width);
            background: var(--surface-1);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }
        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid var(--border);
        }
        .sidebar-header h2 {
            margin: 0;
            font-size: 20px;
            color: var(--accent);
        }
        .sidebar-nav {
            padding: 20px 0;
            flex-grow: 1;
        }
        .sidebar-nav a {
            display: block;
            padding: 12px 20px;
            color: var(--text-2);
            text-decoration: none;
            font-weight: 500;
            transition: background 0.2s, color 0.2s;
        }
        .sidebar-nav a:hover, .sidebar-nav a.active {
            background: var(--surface-2);
            color: var(--accent);
            border-left: 3px solid var(--accent);
        }
        .main-content {
            flex-grow: 1;
            margin-left: var(--sidebar-width);
            padding: 40px;
        }
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            border-bottom: 1px solid var(--border);
            padding-bottom: 20px;
        }
        .page-header h1 {
            margin: 0;
            font-size: 28px;
        }
        
        /* Form & Table Styles */
        .card {
            background: var(--surface-1);
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            padding: 24px;
            margin-bottom: 24px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }
        .form-control {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid var(--border);
            border-radius: 4px;
            font-size: 16px;
            box-sizing: border-box;
            font-family: inherit;
        }
        .form-control:focus {
            outline: none;
            border-color: var(--accent);
        }
        .btn {
            display: inline-block;
            padding: 10px 16px;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            border: 1px solid transparent;
            transition: all 0.2s;
        }
        .btn-primary {
            background: var(--accent);
            color: white;
        }
        .btn-primary:hover {
            background: var(--accent-hover);
        }
        .btn-secondary {
            background: var(--surface-2);
            color: var(--text-1);
            border-color: var(--border);
        }
        .btn-secondary:hover {
            background: #e2e8f0;
        }
        .btn-danger {
            background: #ef4444;
            color: white;
        }
        .btn-danger:hover {
            background: #dc2626;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table th, .table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid var(--border);
        }
        .table th {
            font-weight: 600;
            color: var(--text-2);
        }
        .alert {
            padding: 12px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .alert-success {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }
        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }
        
        .flex-actions {
            display: flex;
            gap: 8px;
        }
    </style>
</head>
<body>
    <aside class="sidebar">
        <div class="sidebar-header">
            <h2>Dashandots CMS</h2>
        </div>
        <nav class="sidebar-nav">
            <a href="index.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">Dashboard</a>
            <a href="settings.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'settings.php' ? 'active' : ''; ?>">Site Settings</a>
            <a href="portfolios.php" class="<?php echo strpos($_SERVER['PHP_SELF'], 'portfolio') !== false ? 'active' : ''; ?>">Portfolios & Demos</a>
            <a href="blogs.php" class="<?php echo strpos($_SERVER['PHP_SELF'], 'blog') !== false ? 'active' : ''; ?>">Blogs</a>
            <a href="logout.php">Logout</a>
        </nav>
    </aside>
    <main class="main-content">
