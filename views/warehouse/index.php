<?php if (isset($_GET['success']) && $_GET['success'] == '1'): ?>

<div id="successPopup" class="success-popup">
    <div class="success-icon">✓</div>
    <div>
        <h3>Berhasil!</h3>
        <p>Gudang berhasil ditambahkan.</p>
    </div>
    <button onclick="closeSuccessPopup()">×</button>
</div>

<style>
.success-popup {
    position: fixed;
    top: 30px;
    right: 30px;
    z-index: 9999;

    display: flex;
    align-items: center;
    gap: 15px;

    background: #ffffff;
    padding: 18px 20px;
    border-radius: 12px;

    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);

    animation: popupIn 0.4s ease;
}

.success-icon {
    width: 42px;
    height: 42px;

    display: flex;
    align-items: center;
    justify-content: center;

    background: #22c55e;
    color: white;

    border-radius: 50%;
    font-size: 24px;
    font-weight: bold;
}

.success-popup h3 {
    margin: 0;
    font-size: 16px;
}

.success-popup p {
    margin: 4px 0 0;
    color: #666;
    font-size: 14px;
}

.success-popup button {
    border: none;
    background: none;
    font-size: 22px;
    cursor: pointer;
    color: #888;
}

@keyframes popupIn {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>

<script>
setTimeout(function () {
    closeSuccessPopup();
}, 3000);

function closeSuccessPopup() {
    const popup = document.getElementById('successPopup');

    if (popup) {
        popup.style.opacity = '0';
        popup.style.transform = 'translateY(-20px)';

        setTimeout(function () {
            popup.remove();
        }, 300);
    }
}
</script>

<?php endif; ?>

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
