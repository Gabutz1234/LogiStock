<?php
// models/inventory.php

function inventory_get_stock($pdo, $warehouseId, $itemId, $forUpdate = false) {
    $sql = "SELECT quantity FROM stocks WHERE warehouse_id = ? AND item_id = ?";
    if ($forUpdate) $sql .= " FOR UPDATE";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$warehouseId, $itemId]);
    $result = $stmt->fetch();
    return $result ? (int)$result['quantity'] : 0;
}

function inventory_get_warehouse_stock($pdo, $warehouseId) {
    $stmt = $pdo->prepare("
        SELECT s.*, i.name as item_name, i.code as item_code, i.unit 
        FROM stocks s
        JOIN items i ON s.item_id = i.id
        WHERE s.warehouse_id = ?
        ORDER BY i.name ASC
    ");
    $stmt->execute([$warehouseId]);
    return $stmt->fetchAll();
}

function inventory_get_global_overview($pdo) {
    return $pdo->query("
        SELECT i.name as item_name, i.code as item_code, w.name as warehouse_name, s.quantity, i.unit
        FROM stocks s
        JOIN items i ON s.item_id = i.id
        JOIN warehouses w ON s.warehouse_id = w.id
        ORDER BY i.name, w.name
    ")->fetchAll();
}

function inventory_update_stock($pdo, $warehouseId, $itemId, $change, $type, $reason = null, $refId = null, $date = null) {
    // 1. Update/Upsert stock
    $stmt = $pdo->prepare("
        INSERT INTO stocks (warehouse_id, item_id, quantity) 
        VALUES (?, ?, ?)
        ON DUPLICATE KEY UPDATE quantity = quantity + VALUES(quantity)
    ");
    $stmt->execute([$warehouseId, $itemId, $change]);

    // 2. Log transaction
    $sql = "INSERT INTO stock_logs (warehouse_id, item_id, quantity_change, type, reason, reference_id" . ($date ? ", created_at" : "") . ")
            VALUES (?, ?, ?, ?, ?, ?" . ($date ? ", ?" : "") . ")";
    
    $params = [$warehouseId, $itemId, $change, $type, $reason, $refId];
    if ($date) $params[] = $date;

    $logStmt = $pdo->prepare($sql);
    $logStmt->execute($params);
}

function inventory_stock_in($pdo, $warehouseId, $itemId, $quantity, $reason = null, $date = null) {
    $pdo->beginTransaction();
    try {
        inventory_update_stock($pdo, $warehouseId, $itemId, $quantity, 'IN', $reason, null, $date);
        $pdo->commit();
    } catch (Exception $e) {
        $pdo->rollBack();
        throw $e;
    }
}

function inventory_stock_out($pdo, $warehouseId, $itemId, $quantity, $reason, $date = null) {
    $pdo->beginTransaction();
    try {
        $current = inventory_get_stock($pdo, $warehouseId, $itemId, true);
        if ($current < $quantity) throw new Exception("Stok tidak mencukupi.");
        inventory_update_stock($pdo, $warehouseId, $itemId, -$quantity, 'OUT', $reason, null, $date);
        $pdo->commit();
    } catch (Exception $e) {
        $pdo->rollBack();
        throw $e;
    }
}

function inventory_get_logs($pdo) {
    return $pdo->query("
        SELECT sl.*, i.name as item_name, i.code as item_code, w.name as warehouse_name
        FROM stock_logs sl
        JOIN items i ON sl.item_id = i.id
        JOIN warehouses w ON sl.warehouse_id = w.id
        ORDER BY sl.created_at DESC
    ")->fetchAll();
}
