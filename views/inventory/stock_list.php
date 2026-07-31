<div class="header-actions">
    <div>
        <h1>Laporan Stok Barang</h1>
        <p class="subtitle">Lihat ketersediaan barang di seluruh gudang</p>
    </div>
    <form method="GET" action="stock.php" class="card" style="padding: 1rem; display: flex; gap: 1rem; align-items: flex-end; margin-bottom: 0;">
        <div class="form-group" style="margin-bottom: 0;">
            <label>Filter Berdasarkan Gudang</label>
            <select name="warehouse_id" onchange="this.form.submit()">
                <option value="">Semua Gudang</option>
                <?php foreach ($warehouses as $w): ?>
                    <option value="<?= $w['id'] ?>" <?= (isset($_GET['warehouse_id']) && $_GET['warehouse_id'] == $w['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($w['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <noscript><button type="submit" class="btn btn-primary">Filter</button></noscript>
    </form>
</div>

<div class="card">
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama Barang</th>
                    <th>Gudang</th>
                    <th>Jumlah Stok</th>
                    <th>Satuan</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($stockItems as $item): ?>
                <tr>
                    <td><span class="badge badge-info"><?= htmlspecialchars($item['item_code']) ?></span></td>
                    <td style="font-weight: 600;"><?= htmlspecialchars($item['item_name']) ?></td>
                    <td><?= htmlspecialchars($item['warehouse_name'] ?? 'N/A') ?></td>
                    <td>
                        <?php 
                            $qty = $item['quantity'];
                            $statusClass = $qty > 20 ? 'badge-success' : ($qty > 0 ? 'badge-warning' : 'badge-destructive');
                        ?>
                        <span class="badge <?= $statusClass ?>"><?= number_format($qty) ?></span>
                    </td>
                    <td><?= htmlspecialchars($item['unit']) ?></td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($stockItems)): ?>
                <tr>
                    <td colspan="5" style="text-align: center; opacity: 0.5; padding: 3rem;">
                        Belum ada data stok untuk kriteria ini.
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
