<?php if ($editUser): ?>

<div class="card" style="margin-bottom: 1.5rem;">

    <h3 style="margin-bottom: 1rem;">Edit User</h3>

    <form method="POST" action="users.php">

        <input type="hidden" name="action" value="update">

        <input
            type="hidden"
            name="id"
            value="<?= $editUser['id'] ?>">

        <div class="grid">

            <div class="form-group">

                <label>Username</label>

                <input
                    type="text"
                    name="username"
                    required
                    maxlength="50"
                    value="<?= htmlspecialchars($editUser['username']) ?>">

            </div>

            <div class="form-group">

                <label>Password Baru</label>

                <input
                    type="password"
                    name="password"
                    placeholder="Kosongkan jika tidak diubah">

            </div>

            <div class="form-group">

                <label>Role</label>

                <select name="role" required>

                    <option
                        value="user"
                        <?= $editUser['role'] === 'user' ? 'selected' : '' ?>>
                        User
                    </option>

                    <option
                        value="admin"
                        <?= $editUser['role'] === 'admin' ? 'selected' : '' ?>>
                        Admin
                    </option>

                </select>

            </div>

        </div>

        <button
            type="submit"
            class="btn btn-primary">
            Simpan Perubahan
        </button>

        <a
            href="users.php"
            class="btn"
            style="background: #64748b; color: white;">
            Batal
        </a>

    </form>

</div>

<?php endif; ?>

<div class="header-actions">
    <div>
        <h1>Kelola User</h1>
        <p class="subtitle">Kelola akun pengguna LogiStock</p>
    </div>
</div>

<!-- FORM TAMBAH USER -->
<div class="card" style="margin-bottom: 1.5rem;">
    <h3 style="margin-bottom: 1rem;">Tambah User</h3>

    <form method="POST" action="users.php"
          style="display: flex; gap: 1rem; align-items: flex-end; flex-wrap: wrap;">

        <input type="hidden" name="action" value="create">

        <div class="form-group" style="margin-bottom: 0;">
            <label>Username</label>
            <input
                type="text"
                name="username"
                required
                maxlength="50"
                placeholder="Username">
        </div>

        <div class="form-group" style="margin-bottom: 0;">
            <label>Password</label>
            <input
                type="password"
                name="password"
                required
                placeholder="Password">
        </div>

        <div class="form-group" style="margin-bottom: 0;">
            <label>Role</label>
            <select name="role" required>
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">
            Tambah User
        </button>

    </form>
</div>


<!-- TABEL USER -->
<div class="card">

    <div class="table-container">

        <table>

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Dibuat</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

                <?php foreach ($users as $user): ?>

                    <tr>

                        <td>
                            #<?= $user['id'] ?>
                        </td>

                        <td style="font-weight: 600;">
                            <?= htmlspecialchars($user['username']) ?>
                        </td>

                        <td>
                            <span class="badge">
                                <?= htmlspecialchars($user['role']) ?>
                            </span>
                        </td>

                        <td>
                            <?= date(
                                'd M Y, H:i',
                                strtotime($user['created_at'])
                            ) ?>
                        </td>

                        <td>
                    
                            <a
                                href="users.php?action=edit&id=<?= $user['id'] ?>"
                                class="btn"
                                style="background: #64748b; color: white;">
                                Edit
                            </a>

                            <a
                                href="users.php?action=delete&id=<?= $user['id'] ?>"
                                class="btn"
                                style="background: #dc2626; color: white;"
                                onclick="return confirm('Yakin ingin menghapus user ini?');">
                                Hapus
                            </a>

                        </td>

                    </tr>

                <?php endforeach; ?>


                <?php if (empty($users)): ?>

                    <tr>
                        <td
                            colspan="5"
                            style="text-align: center; opacity: 0.5; padding: 3rem;">
                            Belum ada user.
                        </td>
                    </tr>

                <?php endif; ?>

            </tbody>

        </table>

    </div>

</div>