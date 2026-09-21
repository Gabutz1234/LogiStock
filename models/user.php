<?php
// models/user.php

// ===============================
// READ - Menampilkan semua user
// ===============================
function user_all($pdo) {
    $stmt = $pdo->query("
        SELECT id, username, role, created_at
        FROM users
        ORDER BY id DESC
    ");

    return $stmt->fetchAll();
}


// ===============================
// READ - Mengambil 1 user
// ===============================
function user_get($pdo, $id) {
    $stmt = $pdo->prepare("
        SELECT id, username, role, created_at
        FROM users
        WHERE id = ?
    ");

    $stmt->execute([$id]);

    return $stmt->fetch();
}


// ===============================
// CREATE - Menambah user
// ===============================
function user_create($pdo, $data) {

    // Cek username sudah digunakan atau belum
    $stmt = $pdo->prepare("
        SELECT id
        FROM users
        WHERE username = ?
    ");

    $stmt->execute([$data['username']]);

    if ($stmt->fetch()) {
        return false;
    }

    // Hash password
    $hashed_password = password_hash(
        $data['password'],
        PASSWORD_DEFAULT
    );

    // Simpan user
    $stmt = $pdo->prepare("
        INSERT INTO users
        (username, password, role)
        VALUES (?, ?, ?)
    ");

    return $stmt->execute([
        $data['username'],
        $hashed_password,
        $data['role']
    ]);
}


// ===============================
// UPDATE - Mengubah user
// ===============================
function user_update($pdo, $id, $data) {

    // Jika password diisi, password ikut diubah
    if (!empty($data['password'])) {

        $hashed_password = password_hash(
            $data['password'],
            PASSWORD_DEFAULT
        );

        $stmt = $pdo->prepare("
            UPDATE users
            SET username = ?,
                password = ?,
                role = ?
            WHERE id = ?
        ");

        return $stmt->execute([
            $data['username'],
            $hashed_password,
            $data['role'],
            $id
        ]);
    }

    // Jika password kosong, password lama tetap digunakan
    $stmt = $pdo->prepare("
        UPDATE users
        SET username = ?,
            role = ?
        WHERE id = ?
    ");

    return $stmt->execute([
        $data['username'],
        $data['role'],
        $id
    ]);
}


// ===============================
// DELETE - Menghapus user
// ===============================
function user_delete($pdo, $id) {

    $stmt = $pdo->prepare("
        DELETE FROM users
        WHERE id = ?
    ");

    return $stmt->execute([$id]);
}
