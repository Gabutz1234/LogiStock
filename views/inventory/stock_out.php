<div class="header-actions">
    <div>
        <h1>Pengeluaran Barang: Stok Keluar</h1>
        <p class="subtitle">Catat kerusakan, kehilangan, atau pengambilan manual</p>
    </div>
</div>

<div class="card" style="max-width: 600px; margin: 0 auto;">
    <?php if (isset($error)): ?>
        <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="inventory.php?action=out">
        <input type="hidden" name="action" value="process_out">
        
        <div class="form-group">
            <label>Gudang Asal</label>
            <select name="warehouse_id" required>
                <option value="">Pilih Gudang...</option>
                <?php foreach ($warehouses as $w): ?>
                    <option value="<?= $w['id'] ?>"><?= htmlspecialchars($w['name']) ?> (<?= htmlspecialchars($w['location']) ?>)</option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Tanggal & Waktu</label>
            <input type="datetime-local" name="date" value="<?= date('Y-m-d\TH:i') ?>">
        </div>

        <div class="form-group">
            <label>Barang</label>
            <select name="item_id" required>
                <option value="">Pilih Barang...</option>
                <?php foreach ($items as $i): ?>
                    <option value="<?= $i['id'] ?>"><?= htmlspecialchars($i['name']) ?> (<?= htmlspecialchars($i['code']) ?>)</option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Jumlah</label>
            <input type="number" name="quantity" required min="1" placeholder="0">
        </div>

        <div class="form-group">
            <label>Alasan Pengeluaran</label>
            <select name="reason" required>
                <option value="DAMAGED">Barang Rusak</option>
                <option value="EXPIRED">Kedaluwarsa</option>
                <option value="LOST">Hilang</option>
                <option value="CORRECTION">Koreksi Inventaris</option>
            </select>
        </div>

        <button type="submit" class="btn btn-destructive" style="width: 100%; justify-content: center;">Simpan Stok Keluar</button>
    </form>
</div>
