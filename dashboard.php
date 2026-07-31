<?php
// dashboard.php
require_once 'includes/db.php';
require_once 'includes/auth_check.php';
require_once 'models/inventory.php';

require_login();

$title = "Dashboard";
$overview = inventory_get_global_overview($pdo);

require 'views/layout/header.php';
require 'views/dashboard/index.php';
require 'views/layout/footer.php';
