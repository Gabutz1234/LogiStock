<?php
// transfers.php
require_once 'includes/db.php';
require_once 'includes/auth_check.php';
require_once 'models/warehouse.php';
require_once 'models/item.php';
require_once 'models/fleet.php';
require_once 'models/inventory.php';
require_once 'models/shipment.php';

require_login();

$action = $_GET['action'] ?? 'index';
$error = null;

// Handle POST actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postAction = $_POST['action'] ?? '';
    
    try {
        if ($postAction === 'process_create') {
            $data = [
                'origin_warehouse_id' => (int)$_POST['origin_warehouse_id'],
                'destination_warehouse_id' => (int)$_POST['destination_warehouse_id'],
                'fleet_id' => (int)$_POST['fleet_id'],
                'created_by' => $_SESSION['user_id']
            ];
            
            $items = [];
            $itemIds = $_POST['item_ids'] ?? [];
            $quantities = $_POST['quantities'] ?? [];
            for ($i = 0; $i < count($itemIds); $i++) {
                if ($quantities[$i] > 0) {
                    $items[] = ['item_id' => (int)$itemIds[$i], 'quantity' => (int)$quantities[$i]];
                }
            }
            
            if (empty($items)) throw new Exception("No items selected.");
            if ($data['origin_warehouse_id'] === $data['destination_warehouse_id']) {
                throw new Exception("Origin and destination cannot be the same.");
            }

            shipment_create($pdo, $data, $items);
            header("Location: transfers.php");
            exit;
        } elseif ($postAction === 'dispatch') {
            require_admin();
            shipment_start_delivery($pdo, (int)$_POST['id']);
            header("Location: transfers.php");
            exit;
        } elseif ($postAction === 'receive') {
            require_admin();
            shipment_receive($pdo, (int)$_POST['id']);
            header("Location: transfers.php");
            exit;
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

$warehouses = warehouse_all($pdo);
$items = item_all($pdo);
$fleets = fleet_all($pdo);
$shipments = shipment_all($pdo);

$title = "Inter-Warehouse Transfers";

require 'views/layout/header.php';
if ($action === 'create') {
    require 'views/shipment/create.php';
} else {
    require 'views/shipment/index.php';
}
require 'views/layout/footer.php';
