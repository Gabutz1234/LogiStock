<?php

require_once '../includes/db.php';
require_once '../includes/auth_check.php';
require_once '../models/inventory.php';
require_once '../vendor/autoload.php';

require_login();

$startDate = $_GET['start_date'] ?? date('Y-m-01');
$endDate   = $_GET['end_date'] ?? date('Y-m-d');

$logs = inventory_get_logs($pdo, $startDate, $endDate);

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Font;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$sheet->setTitle('Riwayat Stok');

// Judul
$sheet->setCellValue('A1', 'LAPORAN RIWAYAT STOK BARANG');
$sheet->mergeCells('A1:G1');

$sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
$sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

// Periode
$sheet->setCellValue(
    'A2',
    'Periode: ' . date('d-m-Y', strtotime($startDate)) .
    ' s/d ' .
    date('d-m-Y', strtotime($endDate))
);

$sheet->mergeCells('A2:G2');

$sheet->getStyle('A2')->getAlignment()
    ->setHorizontal(Alignment::HORIZONTAL_CENTER);

// Header tabel
$headers = [
    'ID',
    'Waktu',
    'Barang',
    'Kode Barang',
    'Gudang',
    'Perubahan',
    'Tipe'
];

$column = 'A';

foreach ($headers as $header) {
    $sheet->setCellValue($column . '4', $header);
    $column++;
}

$sheet->getStyle('A4:G4')->getFont()->setBold(true);
$sheet->getStyle('A4:G4')->getAlignment()
    ->setHorizontal(Alignment::HORIZONTAL_CENTER);

// Data
$row = 5;

foreach ($logs as $log) {

    $typeLabel = match ($log['type']) {
        'IN' => 'Masuk',
        'OUT' => 'Keluar',
        'TRANSFER' => 'Mutasi',
        'ADJUSTMENT' => 'Penyesuaian',
        default => $log['type']
    };

    $sheet->setCellValue('A' . $row, $log['id']);
    $sheet->setCellValue(
        'B' . $row,
        date('d-m-Y H:i', strtotime($log['created_at']))
    );
    $sheet->setCellValue('C' . $row, $log['item_name']);
    $sheet->setCellValue('D' . $row, $log['item_code']);
    $sheet->setCellValue('E' . $row, $log['warehouse_name']);
    $sheet->setCellValue('F' . $row, $log['quantity_change']);
    $sheet->setCellValue('G' . $row, $typeLabel);

    $row++;
}

// Lebar kolom
foreach (range('A', 'G') as $column) {
    $sheet->getColumnDimension($column)->setAutoSize(true);
}

// Download
$filename = 'laporan-stok-' . $startDate . '-sampai-' . $endDate . '.xlsx';

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

exit;