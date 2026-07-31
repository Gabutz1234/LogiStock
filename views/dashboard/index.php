<div class="header-actions">
    <div>
        <h1>Ringkasan Dashboard</h1>
        <p class="subtitle">Tingkat stok global dan kinerja gudang</p>
    </div>
</div>

<div class="grid">
    <div class="card">
        <h3 style="margin-bottom: 0.5rem; font-size: 0.875rem; opacity: 0.7;">Total Gudang Aktif</h3>
        <p style="font-size: 2rem; font-weight: 700;"><?= count(array_unique(array_column($overview, 'warehouse_name'))) ?></p>
    </div>
    <div class="card">
        <h3 style="margin-bottom: 0.5rem; font-size: 0.875rem; opacity: 0.7;">Total Barang Terdaftar</h3>
        <p style="font-size: 2rem; font-weight: 700;"><?= count(array_unique(array_column($overview, 'item_name'))) ?></p>
    </div>
</div>

<div class="card" style="margin-top: 2rem;">
    <h2>Distribusi Stok</h2>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Barang</th>
                    <th>Gudang</th>
                    <th>Stok Saat Ini</th>
                    <th>Satuan</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($overview as $row): ?>
                <tr>
                    <td>
                        <div style="font-weight: 600;"><?= htmlspecialchars($row['item_name']) ?></div>
                        <div class="subtitle"><?= htmlspecialchars($row['item_code']) ?></div>
                    </td>
                    <td><?= htmlspecialchars($row['warehouse_name']) ?></td>
                    <td>
                        <span class="badge <?= $row['quantity'] > 10 ? 'badge-success' : 'badge-warning' ?>">
                            <?= number_format($row['quantity']) ?>
                        </span>
                    </td>
                    <td><?= htmlspecialchars($row['unit']) ?></td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($overview)): ?>
                <tr><td colspan="4" style="text-align: center; opacity: 0.5; padding: 3rem;">Tidak ada data stok tersedia.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
