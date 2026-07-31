<?php
// inventory.php
require_once 'includes/db.php';
require_once 'includes/auth_check.php';
require_once 'models/warehouse.php';
require_once 'models/item.php';
require_once 'models/inventory.php';

require_login();

$action = $_GET['action'] ?? 'in';
$error = null;

// Handle POST actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postAction = $_POST['action'] ?? '';
    
    try {
        $date = !empty($_POST['date']) ? $_POST['date'] : null;

        if ($postAction === 'process_in') {
            inventory_stock_in($pdo, (int)$_POST['warehouse_id'], (int)$_POST['item_id'], (int)$_POST['quantity'], $_POST['reason'], $date);
            header("Location: dashboard.php");
            exit;
        } elseif ($postAction === 'process_out') {
            inventory_stock_out($pdo, (int)$_POST['warehouse_id'], (int)$_POST['item_id'], (int)$_POST['quantity'], $_POST['reason'], $date);
            header("Location: dashboard.php");
            exit;
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

$title = $action === 'in' ? "Stock In" : "Stock Out";
$warehouses = warehouse_all($pdo);
$items = item_all($pdo);

require 'views/layout/header.php';
if ($action === 'in') {
    require 'views/inventory/stock_in.php';
} else {
    require 'views/inventory/stock_out.php';
}
require 'views/layout/footer.php';
