<?php
// models/warehouse.php

function warehouse_all($pdo) {
    return $pdo->query("SELECT * FROM warehouses ORDER BY name ASC")->fetchAll();
}

function warehouse_create($pdo, $data) {
    $stmt = $pdo->prepare("INSERT INTO warehouses (name, location) VALUES (?, ?)");
    $stmt->execute([$data['name'], $data['location']]);
    return $pdo->lastInsertId();
}
