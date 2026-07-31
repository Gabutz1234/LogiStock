<?php
// models/shipment.php

function shipment_all($pdo) {
    return $pdo->query("
        SELECT s.*, 
               ow.name as origin_name, dw.name as destination_name, 
               f.name as fleet_name, u.username as creator_name
        FROM shipments s
        JOIN warehouses ow ON s.origin_warehouse_id = ow.id
        JOIN warehouses dw ON s.destination_warehouse_id = dw.id
        JOIN fleets f ON s.fleet_id = f.id
        JOIN users u ON s.created_by = u.id
        ORDER BY s.created_at DESC
    ")->fetchAll();
}

function shipment_get($pdo, $id) {
    $stmt = $pdo->prepare("SELECT * FROM shipments WHERE id = ?");
    $stmt->execute([$id]);
    $shipment = $stmt->fetch();
    if (!$shipment) return null;

    $stmt = $pdo->prepare("
        SELECT si.*, i.name as item_name, i.code as item_code, i.unit 
        FROM shipment_items si
        JOIN items i ON si.item_id = i.id
        WHERE si.shipment_id = ?
    ");
    $stmt->execute([$id]);
    $shipment['items'] = $stmt->fetchAll();
    return $shipment;
}

function shipment_create($pdo, $data, $items) {
    $pdo->beginTransaction();
    try {
        $stmt = $pdo->prepare("INSERT INTO shipments (origin_warehouse_id, destination_warehouse_id, fleet_id, created_by, status) VALUES (?, ?, ?, ?, 'DRAFT')");
        $stmt->execute([$data['origin_warehouse_id'], $data['destination_warehouse_id'], $data['fleet_id'], $data['created_by']]);
        $shipmentId = $pdo->lastInsertId();

        $stmt = $pdo->prepare("INSERT INTO shipment_items (shipment_id, item_id, quantity) VALUES (?, ?, ?)");
        foreach ($items as $item) {
            $stmt->execute([$shipmentId, $item['item_id'], $item['quantity']]);
        }
        $pdo->commit();
        return $shipmentId;
    } catch (Exception $e) {
        $pdo->rollBack();
        throw $e;
    }
}

function shipment_start_delivery($pdo, $id) {
    $pdo->beginTransaction();
    try {
        $shipment = shipment_get($pdo, $id);
        if (!$shipment || $shipment['status'] !== 'DRAFT') throw new Exception("Invalid status.");

        foreach ($shipment['items'] as $item) {
            $currentStock = inventory_get_stock($pdo, $shipment['origin_warehouse_id'], $item['item_id'], true);
            if ($currentStock < $item['quantity']) throw new Exception("Stok tidak mencukupi untuk {$item['item_name']}.");
        }

        foreach ($shipment['items'] as $item) {
            inventory_update_stock($pdo, $shipment['origin_warehouse_id'], $item['item_id'], -$item['quantity'], 'TRANSFER', "Shipment #$id leaving", $id);
        }

        $stmt = $pdo->prepare("UPDATE shipments SET status = 'ON_DELIVERY' WHERE id = ?");
        $stmt->execute([$id]);
        $pdo->commit();
    } catch (Exception $e) {
        $pdo->rollBack();
        throw $e;
    }
}

function shipment_receive($pdo, $id) {
    $pdo->beginTransaction();
    try {
        $shipment = shipment_get($pdo, $id);
        if (!$shipment || $shipment['status'] !== 'ON_DELIVERY') throw new Exception("Invalid status.");

        foreach ($shipment['items'] as $item) {
            inventory_update_stock($pdo, $shipment['destination_warehouse_id'], $item['item_id'], $item['quantity'], 'TRANSFER', "Shipment #$id received", $id);
        }

        $stmt = $pdo->prepare("UPDATE shipments SET status = 'RECEIVED' WHERE id = ?");
        $stmt->execute([$id]);
        $pdo->commit();
    } catch (Exception $e) {
        $pdo->rollBack();
        throw $e;
    }
}
