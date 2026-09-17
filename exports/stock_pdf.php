<?php

require_once '../includes/db.php';
require_once '../includes/auth_check.php';
require_once '../models/inventory.php';
require_once '../vendor/autoload.php';

require_login();

$startDate = $_GET['start_date'] ?? date('Y-m-01');
$endDate   = $_GET['end_date'] ?? date('Y-m-d');

$logs = inventory_get_logs($pdo, $startDate, $endDate);

use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);

$html = '
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
        }

        h1 {
            text-align: center;
            margin-bottom: 5px;
        }

        .periode {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 7px;
        }

        th {
            background: #f2f2f2;
            text-align: center;
        }

        .center {
            text-align: center;
        }

        .positive {
            color: green;
            font-weight: bold;
        }

        .negative {
            color: red;
            font-weight: bold;
        }
    </style>
</head>

<body>

<h1>Laporan Riwayat Stok Barang</h1>

<div class="periode">
    Periode: ' .
    date('d-m-Y', strtotime($startDate)) .
    ' s/d ' .
    date('d-m-Y', strtotime($endDate)) .
'</div>

<table>

<thead>
<tr>
    <th>ID</th>
    <th>Waktu</th>
    <th>Barang</th>
    <th>Kode</th>
    <th>Gudang</th>
    <th>Perubahan</th>
    <th>Tipe</th>
</tr>
</thead>

<tbody>
';

foreach ($logs as $log) {

    $typeLabel = match ($log['type']) {
        'IN' => 'Masuk',
        'OUT' => 'Keluar',
        'TRANSFER' => 'Mutasi',
        'ADJUSTMENT' => 'Penyesuaian',
        default => $log['type']
    };

    $quantity = (int) $log['quantity_change'];

    $quantityDisplay =
        ($quantity > 0 ? '+' : '') . number_format($quantity);

    $quantityClass =
        $quantity > 0 ? 'positive' : 'negative';

    $html .= '
    <tr>
        <td class="center">' . htmlspecialchars($log['id']) . '</td>

        <td class="center">' .
            date('d-m-Y H:i', strtotime($log['created_at'])) .
        '</td>

        <td>' .
            htmlspecialchars($log['item_name']) .
        '</td>

        <td>' .
            htmlspecialchars($log['item_code']) .
        '</td>

        <td>' .
            htmlspecialchars($log['warehouse_name']) .
        '</td>

        <td class="' . $quantityClass . '" style="text-align:center;">
            ' . $quantityDisplay . '
        </td>

        <td class="center">' .
            htmlspecialchars($typeLabel) .
        '</td>
    </tr>
    ';
}

if (empty($logs)) {
    $html .= '
    <tr>
        <td colspan="7" style="text-align:center;">
            Tidak ada data transaksi pada periode ini.
        </td>
    </tr>
    ';
}

$html .= '
</tbody>
</table>

</body>
</html>
';

$dompdf->loadHtml($html);

$dompdf->setPaper('A4', 'landscape');

$dompdf->render();

$filename =
    'laporan-stok-' .
    $startDate .
    '-sampai-' .
    $endDate .
    '.pdf';

$dompdf->stream($filename, [
    'Attachment' => true
]);

exit;