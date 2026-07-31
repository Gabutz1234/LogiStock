<div class="header-actions">
    <div>
        <h1>Ajukan Mutasi Baru</h1>
        <p class="subtitle">Pindahkan stok antar gudang menggunakan armada kendaraan</p>
    </div>
</div>

<div class="card" style="max-width: 800px; margin: 0 auto;">
    <?php if (isset($error)): ?>
        <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="transfers.php?action=create">
        <input type="hidden" name="action" value="process_create">
        
        <div class="grid" style="grid-template-columns: 1fr 1fr; margin-bottom: 2rem;">
            <div class="form-group">
                <label>Gudang Asal</label>
                <select name="origin_warehouse_id" required>
                    <option value="">Pilih Asal...</option>
                    <?php foreach ($warehouses as $w): ?>
                        <option value="<?= $w['id'] ?>"><?= htmlspecialchars($w['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Gudang Tujuan</label>
                <select name="destination_warehouse_id" required>
                    <option value="">Pilih Tujuan...</option>
                    <?php foreach ($warehouses as $w): ?>
                        <option value="<?= $w['id'] ?>"><?= htmlspecialchars($w['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label>Armada Pengiriman</label>
            <select name="fleet_id" required>
                <option value="">Pilih Armada...</option>
                <?php foreach ($fleets as $f): ?>
                    <option value="<?= $f['id'] ?>"><?= htmlspecialchars($f['name']) ?> (<?= htmlspecialchars($f['license_plate']) ?>)</option>
                <?php endforeach; ?>
            </select>
        </div>

        <h3 style="margin: 2rem 0 1rem; border-bottom: 1px solid var(--border); padding-bottom: 0.5rem;">Daftar Barang yang Dipindah</h3>
        
        <div id="item-list">
            <div class="grid" style="grid-template-columns: 2fr 1fr; align-items: flex-end; margin-bottom: 1rem;">
                <div class="form-group" style="margin-bottom: 0;">
                    <label>Barang</label>
                    <select name="item_ids[]" required>
                        <option value="">Pilih Barang...</option>
                        <?php foreach ($items as $i): ?>
                            <option value="<?= $i['id'] ?>"><?= htmlspecialchars($i['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group" style="margin-bottom: 0;">
                    <label>Jumlah</label>
                    <input type="number" name="quantities[]" min="1" placeholder="0">
                </div>
            </div>
        </div>

        <button type="button" class="btn" onclick="addItemRow()" style="margin-bottom: 2rem;">+ Tambah Barang Lagi</button>

        <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">Kirim Permintaan Mutasi</button>
    </form>
</div>

<script>
    function addItemRow() {
        const list = document.getElementById('item-list');
        const firstRow = list.children[0];
        const newRow = firstRow.cloneNode(true);
        newRow.querySelector('input').value = '';
        list.appendChild(newRow);
    }
</script>
