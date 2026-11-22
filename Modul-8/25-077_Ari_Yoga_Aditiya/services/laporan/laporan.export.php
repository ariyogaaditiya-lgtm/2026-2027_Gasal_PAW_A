<?php

require_once __DIR__ . '/laporan.query.php';

$mulai = parse_date($_GET['mulai'] ?? '');
$selesai = parse_date($_GET['selesai'] ?? '');

if (!$mulai || !$selesai) {
    redirect('laporan');
}

if ($mulai > $selesai) {
    [$mulai, $selesai] = [$selesai, $mulai];
}

[$rows, $summary] = getSalesReport($conn, $mulai, $selesai);

header('Content-Type: application/vnd.ms-excel; charset=utf-8');
header('Content-Disposition: attachment; filename=laporan_transaksi_' . $mulai . '_sampai_' . $selesai . '.xls');
header('Pragma: no-cache');
header('Expires: 0');

?>
<html>

<head>
  <meta charset="utf-8">
</head>

<body>
  <h3>Rekap Laporan Transaksi</h3>
  <p>Periode: <?= e($mulai) ?> sampai <?= e($selesai) ?></p>
  <table border="1">
    <tr>
      <th>No</th>
      <th>Tanggal</th>
      <th>Jumlah transaksi</th>
      <th>Pendapatan</th>
      <th>Pelanggan</th>
    </tr>
    <?php foreach ($rows as $i => $row): ?>
      <tr>
        <td><?= e($i + 1) ?></td>
        <td><?= e($row['tgl']) ?></td>
        <td><?= e($row['total']) ?></td>
        <td><?= e(number_format((float) $row['pendapatan'], 2, ',', '.')) ?></td>
        <td><?= e($row['pelanggan']) ?></td>
      </tr>
    <?php endforeach ?>
  </table>
  <br>
  <table border="1">
    <tr>
      <th>Jumlah transaksi</th>
      <th>Total pendapatan</th>
      <th>Pelanggan unik</th>
    </tr>
    <tr>
      <td><?= e($summary['total']) ?> transaksi</td>
      <td><?= e(number_format((float) $summary['pendapatan'], 2, ',', '.')) ?></td>
      <td><?= e($summary['pelanggan']) ?> orang</td>
    </tr>
  </table>
</body>

</html>
