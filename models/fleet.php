<?php
// models/fleet.php

function fleet_all($pdo) {
    return $pdo->query("SELECT * FROM fleets ORDER BY name ASC")->fetchAll();
}

function fleet_create($pdo, $data) {
    $stmt = $pdo->prepare("INSERT INTO fleets (name, type, license_plate) VALUES (?, ?, ?)");
    $stmt->execute([$data['name'], $data['type'], $data['license_plate']]);
    return $pdo->lastInsertId();
}
