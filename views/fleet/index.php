<div class="header-actions">
    <div>
        <h1>Armada Pengiriman</h1>
        <p class="subtitle">Manajemen kendaraan untuk mutasi antar gudang</p>
    </div>
    <form method="POST" action="fleets.php" class="card" style="padding: 1rem; display: flex; gap: 1rem; align-items: flex-end; margin-bottom: 0;">
        <input type="hidden" name="action" value="create">
        <div class="form-group" style="margin-bottom: 0;">
            <label>Nama</label>
            <input type="text" name="name" required placeholder="Truk Alpha">
        </div>
        <div class="form-group" style="margin-bottom: 0;">
            <label>Tipe</label>
            <input type="text" name="type" required placeholder="Truk Pendingin">
        </div>
        <div class="form-group" style="margin-bottom: 0;">
            <label>Plat Nomor</label>
            <input type="text" name="license_plate" required placeholder="B 1234 XYZ">
        </div>
        <button type="submit" class="btn btn-primary">Tambah Armada</button>
    </form>
</div>

<div class="card">
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Nama Kendaraan</th>
                    <th>Tipe</th>
                    <th>Plat Nomor</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($fleets as $fleet): ?>
                <tr>
                    <td style="font-weight: 600;"><?= htmlspecialchars($fleet['name']) ?></td>
                    <td><?= htmlspecialchars($fleet['type']) ?></td>
                    <td><span class="badge badge-info"><?= htmlspecialchars($fleet['license_plate']) ?></span></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
