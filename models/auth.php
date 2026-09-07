<?php
// models/auth.php

/**
 * Authenticate a user.
 */
function auth_login($pdo, $username, $password)
{
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        return true;
    }
    return false;
}

function auth_register($pdo, $username, $password)
{
    // Cek apakah username sudah ada
    $stmt = $pdo->prepare(
        "SELECT id FROM users WHERE username = ?"
    );

    $stmt->execute([$username]);

    if ($stmt->fetch()) {
        return false;
    }

    // Hash password
    $hashed_password = password_hash(
        $password,
        PASSWORD_DEFAULT
    );

    // Masukkan user baru
    $stmt = $pdo->prepare(
        "INSERT INTO users (username, password)
         VALUES (?, ?)"
    );

    return $stmt->execute([
        $username,
        $hashed_password
    ]);
}