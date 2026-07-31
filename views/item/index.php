<div class="header-actions">
    <div>
        <h1>Katalog Barang</h1>
        <p class="subtitle">Definisi produk global</p>
    </div>
    <form method="POST" action="items.php" class="card" style="padding: 1rem; display: flex; gap: 1rem; align-items: flex-end; margin-bottom: 0;">
        <input type="hidden" name="action" value="create">
        <div class="form-group" style="margin-bottom: 0;">
            <label>Kode</label>
            <input type="text" name="code" required placeholder="BEV-001">
        </div>
        <div class="form-group" style="margin-bottom: 0;">
            <label>Nama</label>
            <input type="text" name="name" required placeholder="Kopi Dingin">
        </div>
        <div class="form-group" style="margin-bottom: 0;">
            <label>Satuan</label>
            <input type="text" name="unit" required placeholder="Kotak">
        </div>
        <div class="form-group" style="margin-bottom: 0;">
            <label>Suhu</label>
            <input type="text" name="storage_temp" placeholder="5-8°C">
        </div>
        <button type="submit" class="btn btn-primary">Tambah Barang</button>
    </form>
</div>

<div class="card">
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Satuan</th>
                    <th>Suhu Penyimpanan</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                <tr>
                    <td><span class="badge badge-info"><?= htmlspecialchars($item['code']) ?></span></td>
                    <td style="font-weight: 600;"><?= htmlspecialchars($item['name']) ?></td>
                    <td><?= htmlspecialchars($item['unit']) ?></td>
                    <td><?= htmlspecialchars($item['storage_temp']) ?: '-' ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
