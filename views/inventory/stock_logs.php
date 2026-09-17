<div class="header-actions">
    <div>
        <h1>Riwayat Stok Barang</h1>
        <p class="subtitle">Audit trail dan log transaksi pergerakan barang</p>
    </div>

    <div style="display: flex; align-items: center; gap: 0.5rem;">

        <!-- Filter tanggal -->
        <form method="GET" action="reports.php"
              style="display: flex; align-items: center; gap: 0.5rem;">

            <input
                type="date"
                name="start_date"
                value="<?= htmlspecialchars($startDate) ?>"
                style="
                    height: 40px;
                    padding: 0 0.75rem;
                    border: 1px solid var(--border);
                    border-radius: 0.5rem;
                    background: var(--card);
                    color: var(--foreground);
                    font-size: 0.875rem;
                "
            >

            <span style="opacity: 0.5;">s/d</span>

            <input
                type="date"
                name="end_date"
                value="<?= htmlspecialchars($endDate) ?>"
                style="
                    height: 40px;
                    padding: 0 0.75rem;
                    border: 1px solid var(--border);
                    border-radius: 0.5rem;
                    background: var(--card);
                    color: var(--foreground);
                    font-size: 0.875rem;
                "
            >

            <button type="submit" class="btn-primary">
                Tampilkan
            </button>

        </form>

        <!-- Download -->
        <a
            href="exports/stock_pdf.php?start_date=<?= urlencode($startDate) ?>&end_date=<?= urlencode($endDate) ?>"
            class="btn-secondary"
        >
            PDF
        </a>

        <a
            href="exports/stock_excel.php?start_date=<?= urlencode($startDate) ?>&end_date=<?= urlencode($endDate) ?>"
            class="btn-secondary"
        >
            Excel
        </a>

    </div>
</div>

<div class="card">
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Waktu</th>
                    <th>Barang</th>
                    <th>Gudang</th>
                    <th>Perubahan</th>
                    <th>Tipe</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($logs as $log): ?>
                <tr>
                    <td>#<?= $log['id'] ?: '-' ?></td>
                    <td style="white-space: nowrap; font-size: 0.75rem; opacity: 0.8;">
                        <?= date('d M Y, H:i', strtotime($log['created_at'])) ?>
                    </td>
                    <td>
                        <div style="font-weight: 600;"><?= htmlspecialchars($log['item_name']) ?></div>
                        <div class="subtitle" style="font-size: 0.75rem;"><?= htmlspecialchars($log['item_code']) ?></div>
                    </td>
                    <td><?= htmlspecialchars($log['warehouse_name']) ?></td>
                    <td>
                        <span style="font-weight: 700; color: <?= $log['quantity_change'] > 0 ? 'var(--success)' : 'var(--destructive)' ?>;">
                            <?= ($log['quantity_change'] > 0 ? '+' : '') . number_format($log['quantity_change']) ?>
                        </span>
                    </td>
                    <td>
                        <?php 
                            $typeLabel = match($log['type']) {
                                'IN' => 'Masuk',
                                'OUT' => 'Keluar',
                                'TRANSFER' => 'Mutasi',
                                'ADJUSTMENT' => 'Penyesuaian',
                                default => $log['type']
                            };
                            $typeClass = match($log['type']) {
                                'IN' => 'badge-success',
                                'OUT' => 'badge-warning',
                                'TRANSFER' => 'badge-info',
                                default => ''
                            };
                        ?>
                        <span class="badge <?= $typeClass ?>"><?= $typeLabel ?></span>
                    </td>
                    
                    <td class="subtitle" style="font-size: 0.875rem;">
                        <?= htmlspecialchars($log['reason'] ?: '-') ?>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($logs)): ?>
                    <tr><td colspan="7" style="text-align: center; opacity: 0.5; padding: 3rem;">Belum ada riwayat pergerakan stok.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
