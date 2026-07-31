<div class="header-actions">
    <div>
        <h1>Manajemen Gudang</h1>
        <p class="subtitle">Kelola lokasi penyimpanan fisik</p>
    </div>
    <form method="POST" action="warehouses.php" class="card" style="padding: 1rem; display: flex; gap: 1rem; align-items: flex-end; margin-bottom: 0;">
        <input type="hidden" name="action" value="create">
        <div class="form-group" style="margin-bottom: 0;">
            <label>Nama</label>
            <input type="text" name="name" required placeholder="Gudang Utama">
        </div>
        <div class="form-group" style="margin-bottom: 0;">
            <label>Lokasi</label>
            <input type="text" name="location" required placeholder="Jakarta">
        </div>
        <button type="submit" class="btn btn-primary">Tambah Gudang</button>
    </form>
</div>

<div class="card">
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Lokasi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($warehouses as $w): ?>
                <tr>
                    <td>#<?= $w['id'] ?></td>
                    <td style="font-weight: 600;"><?= htmlspecialchars($w['name']) ?></td>
                    <td><?= htmlspecialchars($w['location']) ?></td>
                    <td><button class="btn" style="opacity: 0.5;">Ubah</button></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
