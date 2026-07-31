<?php
// fleets.php
require_once 'includes/db.php';
require_once 'includes/auth_check.php';
require_once 'models/fleet.php';

require_admin();

if (isset($_POST['action']) && $_POST['action'] === 'create') {
    $data = [
        'name' => $_POST['name'] ?? '',
        'type' => $_POST['type'] ?? '',
        'license_plate' => $_POST['license_plate'] ?? ''
    ];
    fleet_create($pdo, $data);
    header("Location: fleets.php");
    exit;
}

$title = "Fleets";
$fleets = fleet_all($pdo);

require 'views/layout/header.php';
require 'views/fleet/index.php';
require 'views/layout/footer.php';
