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

            $warehouseId = (int)$_POST['warehouse_id'];
            $itemId = (int)$_POST['item_id'];
            $quantity = (int)$_POST['quantity'];
            $reason = $_POST['reason'] ?? '';

            // Ambil data gudang
            $stmtWarehouse = $pdo->prepare("
                SELECT name, min_temperature, max_temperature
                FROM warehouses
                WHERE id = ?
            ");

            $stmtWarehouse->execute([$warehouseId]);
            $warehouse = $stmtWarehouse->fetch();

            if (!$warehouse) {
                throw new Exception("Gudang tidak ditemukan.");
            }

            // Ambil data barang
            $stmtItem = $pdo->prepare("
                SELECT name, storage_temp
                FROM items
                WHERE id = ?
            ");

            $stmtItem->execute([$itemId]);
            $item = $stmtItem->fetch();

            if (!$item) {
                throw new Exception("Barang tidak ditemukan.");
            }

            // Ambil suhu penyimpanan barang
            $itemTemp = (float)$item['storage_temp'];

            // Ambil batas suhu gudang
            $minTemp = (float)$warehouse['min_temperature'];
            $maxTemp = (float)$warehouse['max_temperature'];

            // CEK SUHU
            if ($itemTemp < $minTemp || $itemTemp > $maxTemp) {

                throw new Exception(
                    "Stok ditolak. Suhu penyimpanan {$item['name']} adalah {$itemTemp}°C, " .
                    "sedangkan gudang {$warehouse['name']} hanya menerima suhu " .
                    "{$minTemp}°C sampai {$maxTemp}°C."
                );
            }

            // Jika suhu sesuai, stok boleh masuk
            inventory_stock_in(
                $pdo,
                $warehouseId,
                $itemId,
                $quantity,
                $reason,
                $date
            );

            header("Location: dashboard.php");
            exit;

        } elseif ($postAction === 'process_out') {

            inventory_stock_out(
                $pdo,
                (int)$_POST['warehouse_id'],
                (int)$_POST['item_id'],
                (int)$_POST['quantity'],
                $_POST['reason'],
                $date
            );

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