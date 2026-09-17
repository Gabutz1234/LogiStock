<link
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,400,0,0"
    rel="stylesheet"
/>

<style>
    /* REPORT HEADER */
    .report-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 2rem;
        margin-bottom: 1.5rem;
    }
    .report-title {
        flex: 1;
        min-width: 0;
    }
    .report-title h1 {
        margin: 0;
    }
    .report-title .subtitle {
        margin-top: 0.35rem;
    }

    /* REPORT CONTROLS */
    .report-controls {
        display: flex;
        flex-direction: column;
        align-items: stretch;
        gap: 0.6rem;
        width: 492px;
        flex-shrink: 0;
    }

    /* DATE FILTER */
    .date-filter {
        display: flex;
        align-items: center;
        width: 100%;
        gap: 0.6rem;
    }
    .date-filter input {
        box-sizing: border-box;
        height: 42px;
        width: 0;
        flex: 1;

        padding: 0 0.85rem;

        border: 1px solid var(--border);
        border-radius: 0.65rem;

        background: var(--card);
        color: var(--foreground);

        font-family: inherit;
        font-size: 0.875rem;

        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .date-filter input:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px hsl(221 83% 53% / 0.12);
    }
    .date-separator {
        flex-shrink: 0;

        color: var(--muted-foreground);
        font-size: 0.9rem;
        font-weight: 500;
    }

    /* BUTTON ROW */
    .report-buttons {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 0.6rem;
    }
    .report-button {
        box-sizing: border-box;

        height: 40px;
        padding: 0 0.95rem;

        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.45rem;

        border-radius: 0.65rem;

        font-family: inherit;
        font-size: 0.875rem;
        font-weight: 600;

        text-decoration: none;
        cursor: pointer;

        transition:
            background 0.2s,
            border-color 0.2s,
            opacity 0.2s,
            transform 0.1s;
    }
    .report-button:hover {
        transform: translateY(-1px);
    }
    .report-button:active {
        transform: translateY(0);
    }
    .material-symbols-rounded {
        font-size: 19px;
        line-height: 1;
    }

    /* FILTER BUTTON */
    .btn-filter {
        border: none;
        background: var(--primary);
        color: white;
    }
    .btn-filter:hover {
        opacity: 0.9;
    }

    /* PDF */
    .btn-pdf {
        border: 1px solid var(--border);
        background: transparent;
        color: var(--destructive);
    }
    .btn-pdf:hover {
        background: hsl(0 84% 60% / 0.08);
        border-color: var(--destructive);
    }

    /* EXCEL */
    .btn-excel {
        border: 1px solid var(--border);
        background: transparent;
        color: var(--success);
    }
    .btn-excel:hover {
        background: hsl(142 71% 45% / 0.08);
        border-color: var(--success);
    }

    /* RESPONSIVE */
    @media (max-width: 1000px) {
        .report-header {
            flex-direction: column;
        }
        .report-controls {
            width: 100%;
            max-width: 492px;
        }
    }
    @media (max-width: 600px) {
        .report-controls {
            width: 100%;
        }
        .date-filter {
            flex-wrap: wrap;
        }
        .date-filter input {
            min-width: 0;
        }
        .report-buttons {
            justify-content: stretch;
        }
        .report-button {
            flex: 1;
        }
    }
</style>

<div class="report-header">

    <!-- Judul -->
    <div class="report-title">
        <h1>Riwayat Stok Barang</h1>
        <p class="subtitle">
            Audit trail dan log transaksi pergerakan barang
        </p>
    </div>

    <!-- Filter + tombol -->
    <div class="report-controls">
        <!-- BARIS TANGGAL -->
        <form
            method="GET"
            action="reports.php"
            class="date-filter"
        >
            <input
                type="date"
                name="start_date"
                value="<?= htmlspecialchars($startDate) ?>"
                title="Tanggal mulai"
            >
            <span class="date-separator">
                s/d
            </span>
            <input
                type="date"
                name="end_date"
                value="<?= htmlspecialchars($endDate) ?>"
                title="Tanggal akhir"
            >

            <!-- Tombol submit tersembunyi secara visual -->
            <button
                type="submit"
                id="filterSubmit"
                style="display: none;"
            >
                Tampilkan
            </button>
        </form>

        <!-- BARIS TOMBOL -->
        <div class="report-buttons">
            <!-- Tampilkan -->
            <button
                type="button"
                class="report-button btn-filter"
                onclick="document.getElementById('filterSubmit').click();"
            >
                <span class="material-symbols-rounded">
                    filter_alt
                </span>
                Tampilkan
            </button>

            <!-- PDF -->
            <a
                href="exports/stock_pdf.php?start_date=<?= urlencode($startDate) ?>&end_date=<?= urlencode($endDate) ?>"
                class="report-button btn-pdf"
            >
                <span class="material-symbols-rounded">
                    picture_as_pdf
                </span>
                PDF
            </a>

            <!-- Excel -->
            <a
                href="exports/stock_excel.php?start_date=<?= urlencode($startDate) ?>&end_date=<?= urlencode($endDate) ?>"
                class="report-button btn-excel"
            >
                <span class="material-symbols-rounded">
                    table_view
                </span>
                Excel
            </a>
        </div>
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
