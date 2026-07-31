<?php
// models/item.php

function item_all($pdo) {
    return $pdo->query("SELECT * FROM items ORDER BY name ASC")->fetchAll();
}

function item_create($pdo, $data) {
    $stmt = $pdo->prepare("INSERT INTO items (code, name, unit, storage_temp) VALUES (?, ?, ?, ?)");
    $stmt->execute([$data['code'], $data['name'], $data['unit'], $data['storage_temp']]);
    return $pdo->lastInsertId();
}
