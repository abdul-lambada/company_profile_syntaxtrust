<?php
require_once '../../config/auth.php';

// Check if user is logged in
requireLogin();

$content = '../views/pages/dashboard.php';
include '../views/layouts/main.php';
?>
