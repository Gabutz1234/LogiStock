<?php
// profile.php

require_once 'includes/db.php';
require_once 'models/auth.php';

session_start();

// Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$title = "Profil";

// Ambil data user dari database
$stmt = $pdo->prepare("
    SELECT id, username, role, created_at
    FROM users
    WHERE id = ?
");

$stmt->execute([$_SESSION['user_id']]);

$user = $stmt->fetch();

if (!$user) {
    die("Data pengguna tidak ditemukan.");
}

// Load layout
require_once 'views/layout/header.php';
?>

<div class="header-actions">
    <div>
        <h1>Profil Pengguna</h1>
        <p class="subtitle">Informasi akun Anda</p>
    </div>
</div>

<div class="card profile-card">

    <div class="profile-header">

        <div class="large-avatar">
            <i data-lucide="user"></i>
        </div>
    </div>

    <div class="form-group">
        <label>Username</label>
        <input
            type="text"
            value="<?= htmlspecialchars($user['username']) ?>"
            readonly
        >
    </div>

    <div class="form-group">
        <label>Role</label>
        <input
            type="text"
            value="<?= $user['role'] === 'admin' ? 'Administrator' : 'Staf' ?>"
            readonly
        >
    </div>

    <div class="form-group">
        <label>Created at</label>
        <input
            type="text"
            value="<?= htmlspecialchars($user['created_at']) ?>"
            readonly
        >
    </div>

</div>

<script>
    lucide.createIcons();
</script>