<?php

// models/warehouse.php

function warehouse_all($pdo) {

    return $pdo->query("
        SELECT * 
        FROM warehouses 
        ORDER BY name ASC
    ")->fetchAll();

}

function warehouse_create($pdo, $data) {

    $stmt = $pdo->prepare("
        INSERT INTO warehouses 
        (name, location, min_temperature, max_temperature) 
        VALUES (?, ?, ?, ?)
    ");

    $stmt->execute([
        $data['name'],
        $data['location'],
        $data['min_temperature'],
        $data['max_temperature']
    ]);

    return $pdo->lastInsertId();

}