<?php
require_once __DIR__ . '/config/koneksi.php';
require_once __DIR__ . '/functions/laporan.php';

$tanggalMulai = $_GET['tanggal_mulai'] ?? date('Y-m-01');
$tanggalSelesai = $_GET['tanggal_selesai'] ?? date('Y-m-d');

$validMulai = DateTime::createFromFormat('Y-m-d', $tanggalMulai);
$validSelesai = DateTime::createFromFormat('Y-m-d', $tanggalSelesai);
if (!$validMulai || $validMulai->format('Y-m-d') !== $tanggalMulai ||
    !$validSelesai || $validSelesai->format('Y-m-d') !== $tanggalSelesai ||
    $tanggalMulai > $tanggalSelesai) {
    http_response_code(400);
    exit('Rentang tanggal tidak valid.');
}

$laporan = ambilLaporan($pdo, $tanggalMulai, $tanggalSelesai);
$ringkasan = ambilRingkasan($pdo, $tanggalMulai, $tanggalSelesai);

$namaFile = 'laporan_penjualan_' . $tanggalMulai . '_sampai_' . $tanggalSelesai . '.xls';

header('Content-Type: application/vnd.ms-excel; charset=utf-8');
header('Content-Disposition: attachment; filename="' . $namaFile . '"');
header('Cache-Control: max-age=0');
echo "\xEF\xBB\xBF";
?>
<table border="1">
    <thead>
        <tr>
            <th colspan="4">LAPORAN PENJUALAN HARIAN</th>
        </tr>
        <tr>
            <th colspan="4">Periode <?= htmlspecialchars($tanggalMulai) ?> sampai <?= htmlspecialchars($tanggalSelesai) ?></th>
        </tr>
        <tr>
            <th>No.</th>
            <th>Tanggal Transaksi</th>
            <th>Jumlah Transaksi</th>
            <th>Total Pendapatan</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($laporan as $index => $baris): ?>
        <tr>
            <td><?= $index + 1 ?></td>
            <td><?= date('d-m-Y', strtotime($baris['tanggal'])) ?></td>
            <td><?= (int)$baris['jumlah_transaksi'] ?></td>
            <td><?= (int)$baris['pendapatan'] ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <th colspan="3">Total Pendapatan Keseluruhan</th>
            <th><?= (int)$ringkasan['total_pendapatan'] ?></th>
        </tr>
        <tr>
            <th colspan="3">Jumlah Pelanggan Unik</th>
            <th><?= (int)$ringkasan['pelanggan_unik'] ?></th>
        </tr>
    </tfoot>
</table>
