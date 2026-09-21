<?php
// users.php

require_once 'includes/db.php';
require_once 'includes/auth_check.php';
require_once 'models/user.php';

require_admin();

// ===============================
// PROSES TAMBAH USER
// ===============================
if (isset($_POST['action']) && $_POST['action'] === 'create') {

    $data = [
        'username' => $_POST['username'] ?? '',
        'password' => $_POST['password'] ?? '',
        'role' => $_POST['role'] ?? 'user'
    ];

    user_create($pdo, $data);

    header("Location: users.php");
    exit;
}

// ===============================
// PROSES UPDATE USER
// ===============================
if (isset($_POST['action']) && $_POST['action'] === 'update') {

    $id = $_POST['id'] ?? null;

    $data = [
        'username' => $_POST['username'] ?? '',
        'password' => $_POST['password'] ?? '',
        'role' => $_POST['role'] ?? 'user'
    ];

    if ($id) {
        user_update($pdo, $id, $data);
    }

    header("Location: users.php");
    exit;
}

// ===============================
// PROSES HAPUS USER
// ===============================
if (isset($_GET['action']) && $_GET['action'] === 'delete') {

    $id = $_GET['id'] ?? null;

    if ($id) {
        user_delete($pdo, $id);
    }

    header("Location: users.php");
    exit;
}

// ===============================
// AMBIL DATA USER UNTUK EDIT
// ===============================
$editUser = null;

if (isset($_GET['action']) && $_GET['action'] === 'edit') {

    $id = $_GET['id'] ?? null;

    if ($id) {
        $editUser = user_get($pdo, $id);
    }
}


// ===============================
// AMBIL DATA USER
// ===============================
$users = user_all($pdo);

$title = "Kelola User";

require 'views/layout/header.php';
require 'views/user/index.php';
require 'views/layout/footer.php';
