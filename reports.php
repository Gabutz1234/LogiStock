<?php
// reports.php
require_once 'includes/db.php';
require_once 'includes/auth_check.php';
require_once 'models/inventory.php';

require_login();

$logs = inventory_get_logs($pdo);
$title = "Riwayat Stok";

require 'views/layout/header.php';
require 'views/inventory/stock_logs.php';
require 'views/layout/footer.php';
