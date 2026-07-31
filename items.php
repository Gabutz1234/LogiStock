<?php
// items.php
require_once 'includes/db.php';
require_once 'includes/auth_check.php';
require_once 'models/item.php';

require_admin();

if (isset($_POST['action']) && $_POST['action'] === 'create') {
    $data = [
        'code' => $_POST['code'] ?? '',
        'name' => $_POST['name'] ?? '',
        'unit' => $_POST['unit'] ?? '',
        'storage_temp' => $_POST['storage_temp'] ?? ''
    ];
    item_create($pdo, $data);
    header("Location: items.php");
    exit;
}

$title = "Items Catalog";
$items = item_all($pdo);

require 'views/layout/header.php';
require 'views/item/index.php';
require 'views/layout/footer.php';
