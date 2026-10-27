<?php
/**
 * /demo/tms — thin wrapper around demo/view.php.
 *
 * These three pages predate view.php and carried their own copy of the SEO
 * setup, so they missed the per-row meta overrides, the breadcrumb and the
 * SoftwareApplication schema. Delegating keeps one code path.
 */
$_GET['slug'] = 'tms';
require __DIR__ . '/view.php';
