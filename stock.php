<?php
// stock.php
require_once 'includes/db.php';
require_once 'includes/auth_check.php';
require_once 'models/warehouse.php';
require_once 'models/inventory.php';

require_login();

$warehouseId = isset($_GET['warehouse_id']) ? (int)$_GET['warehouse_id'] : null;

// Populate data for filters
$warehouses = warehouse_all($pdo);

// Fetch stock based on filter
if ($warehouseId) {
    $stockItems = inventory_get_warehouse_stock($pdo, $warehouseId);
} else {
    // Flatten global overview logic slightly for the detailed list
    $stockItems = inventory_get_global_overview($pdo);
}

$title = "Data Stok";

require 'views/layout/header.php';
require 'views/inventory/stock_list.php';
require 'views/layout/footer.php';
