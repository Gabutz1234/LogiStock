<?php

require_once 'includes/db.php';
require_once 'models/auth.php';

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if ($password !== $confirm_password) {

        $error = "Password dan konfirmasi password tidak sama.";

    } else {

        if (auth_register($pdo, $username, $password)) {
            header("Location: index.php");
            exit;
        } else {
            $error = "Username sudah digunakan atau registrasi gagal.";
        }
    }
}

require 'views/auth/register.php';