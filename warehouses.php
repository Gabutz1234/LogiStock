<?php
// warehouses.php
require_once 'includes/db.php';
require_once 'includes/auth_check.php';
require_once 'models/warehouse.php';

require_admin();

if (isset($_POST['action']) && $_POST['action'] === 'create') {
    $data = [
        'name' => $_POST['name'] ?? '',
        'location' => $_POST['location'] ?? ''
    ];
    warehouse_create($pdo, $data);
    header("Location: warehouses.php");
    exit;
}

$title = "Warehouses";
$warehouses = warehouse_all($pdo);

require 'views/layout/header.php';
require 'views/warehouse/index.php';
require 'views/layout/footer.php';
