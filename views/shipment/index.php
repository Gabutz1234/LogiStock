<div class="header-actions">
    <div>
        <h1>Mutasi Antar Gudang</h1>
        <p class="subtitle">Pantau dan proses pemindahan stok antar hub</p>
    </div>
    <a href="transfers.php?action=create" class="btn btn-primary">
        <i data-lucide="plus"></i> Ajukan Mutasi Baru
    </a>
</div>

<?php if (isset($error)): ?>
    <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<div class="card">
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Ref ID</th>
                    <th>Gudang Asal</th>
                    <th>Gudang Tujuan</th>
                    <th>Armada</th>
                    <th>Pembuat</th>
                    <th>Detail Barang</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($shipments as $s): ?>
                <tr>
                    <td>#<?= $s['id'] ?></td>
                    <td><?= htmlspecialchars($s['origin_name']) ?></td>
                    <td><?= htmlspecialchars($s['destination_name']) ?></td>
                    <td><?= htmlspecialchars($s['fleet_name']) ?></td>
                    <td><?= htmlspecialchars($s['creator_name']) ?></td>
                    <td>
                        <?php foreach ($s['items'] as $item): ?>
                            <div style="margin-bottom: 0.25rem;">
                                <strong><?= htmlspecialchars($item['item_name']) ?></strong>
                                <span class="subtitle">
                                    <?= $item['quantity'] ?> <?= htmlspecialchars($item['unit']) ?>
                                </span>
                            </div>
                        <?php endforeach; ?>
                    </td>
                    <td>
                        <?php 
                            $statusClass = match($s['status']) {
                                'DRAFT' => 'badge-info',
                                'ON_DELIVERY' => 'badge-warning',
                                'RECEIVED' => 'badge-success',
                                default => ''
                            };
                            $statusLabel = match($s['status']) {
                                'DRAFT' => 'DRAF',
                                'ON_DELIVERY' => 'DIKIRIM',
                                'RECEIVED' => 'DITERIMA',
                                default => $s['status']
                            };
                        ?>
                        <span class="badge <?= $statusClass ?>"><?= $statusLabel ?></span>
                    </td>
                    <td>
                        <?php if ($isAdmin): ?>

                            <?php if ($s['status'] === 'DRAFT'): ?>
                                <form method="POST" action="transfers.php" style="display:inline;">
                                    <input type="hidden" name="action" value="dispatch">
                                    <input type="hidden" name="id" value="<?= $s['id'] ?>">
                                    <button type="submit" class="btn btn-primary" style="padding: 0.25rem 0.5rem; font-size: 0.75rem;">
                                        Kirim
                                    </button>
                                </form>

                            <?php elseif ($s['status'] === 'ON_DELIVERY'): ?>
                                <form method="POST" action="transfers.php" style="display:inline;">
                                    <input type="hidden" name="action" value="receive">
                                    <input type="hidden" name="id" value="<?= $s['id'] ?>">
                                    <button type="submit" class="btn btn-success" style="padding: 0.25rem 0.5rem; font-size: 0.75rem;">
                                        Terima
                                    </button>
                                </form>

                            <?php elseif ($s['status'] === 'RECEIVED'): ?>
                                <span class="subtitle">Diterima</span>
                            <?php endif; ?>

                        <?php else: ?>

                            <?php if ($s['status'] === 'DRAFT'): ?>
                                <span class="subtitle">Tunggu Admin</span>

                            <?php elseif ($s['status'] === 'ON_DELIVERY'): ?>
                                <span class="subtitle">Dalam Perjalanan</span>

                            <?php elseif ($s['status'] === 'RECEIVED'): ?>
                                <span class="subtitle">Telah Sampai Tujuan</span>
                            <?php endif; ?>

                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($shipments)): ?>
                    <tr><td colspan="7" style="text-align: center; opacity: 0.5; padding: 3rem;">Belum ada riwayat mutasi.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
