<?php
require_once __DIR__ . '/../includes/security.php';
admin_session_start();
$_SESSION = [];
session_destroy();
header('Location: login.php');
exit;
