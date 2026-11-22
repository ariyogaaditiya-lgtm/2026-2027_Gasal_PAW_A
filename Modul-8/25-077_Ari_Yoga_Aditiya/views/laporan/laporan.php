<?php

require_once __DIR__ . '/../../services/laporan/laporan.query.php';

$mulaiInput = (string) ($_GET['mulai'] ?? date('Y-m-01'));
$selesaiInput = (string) ($_GET['selesai'] ?? date('Y-m-d'));
$mulai = parse_date($mulaiInput);
$selesai = parse_date($selesaiInput);
$rows = [];
$summary = ['total' => 0, 'pendapatan' => 0, 'pelanggan' => 0];

if ($mulai && $selesai) {
    if ($mulai > $selesai) {
        [$mulai, $selesai] = [$selesai, $mulai];
    }
    [$rows, $summary] = getSalesReport($conn, $mulai, $selesai);
}

$labels = array_column($rows, 'tgl');
$data = array_map('floatval', array_column($rows, 'pendapatan'));
$jsonFlags = JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT;
$exportUrl = $mulai && $selesai
    ? url('api/laporan/export') . '?mulai=' . rawurlencode($mulai) . '&selesai=' . rawurlencode($selesai)
    : '';

require_once __DIR__ . '/../partials/header.auth.php';
?>
<main class="container py-5">
  <h1 class="mb-7">
    Laporan Transaksi
    <?php if ($mulai && $selesai): ?>
      <small class="fs-lg"><?= e($mulai) ?> sampai <?= e($selesai) ?></small>
    <?php endif ?>
  </h1>

  <form class="d-print-none mb-7" method="get" action="<?= e(url('laporan')) ?>">
    <div class="row">
      <div class="md:col-4">
        <div class="form-field mb-5">
          <label class="form-label" for="mulai">Dari tanggal</label>
          <input class="form-control" type="date" id="mulai" name="mulai" value="<?= e($mulaiInput) ?>" required>
        </div>
      </div>
      <div class="md:col-4">
        <div class="form-field mb-5">
          <label class="form-label" for="selesai">Sampai tanggal</label>
          <input class="form-control" type="date" id="selesai" name="selesai" value="<?= e($selesaiInput) ?>" required>
        </div>
      </div>
    </div>
    <button type="submit" class="btn btn-solid theme-primary">Tampilkan</button>
    <?php if ($rows): ?>
      <button type="button" class="btn btn-outline theme-primary" id="btnPrint">Cetak</button>
      <a class="btn btn-outline theme-success" href="<?= e($exportUrl) ?>">Excel</a>
    <?php endif ?>
  </form>

  <?php if (!$mulai || !$selesai): ?>
    <div class="alert theme-info" role="alert">Pilih rentang tanggal yang valid untuk menampilkan laporan.</div>
  <?php elseif (!$rows): ?>
    <div class="alert theme-warning" role="alert">Tidak ada transaksi pada rentang tanggal tersebut.</div>
  <?php else: ?>
    <h2 class="fs-xl mb-5">Grafik pendapatan per hari</h2>
    <div class="card mb-7">
      <div class="card-body"><canvas id="chartSales"></canvas></div>
    </div>

    <h2 class="fs-xl mb-5">Rekapitulasi harian</h2>
    <div class="table-responsive mb-7">
      <table class="table">
        <thead>
          <tr>
            <th scope="col">No</th>
            <th scope="col">Tanggal</th>
            <th scope="col">Jumlah transaksi</th>
            <th scope="col">Pendapatan</th>
            <th scope="col">Pelanggan</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($rows as $i => $row): ?>
            <tr>
              <td><?= e($i + 1) ?></td>
              <td><?= e(tanggal($row['tgl'], false)) ?></td>
              <td><?= e($row['total']) ?></td>
              <td><?= e(rupiah($row['pendapatan'])) ?></td>
              <td><?= e($row['pelanggan']) ?></td>
            </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>

    <h2 class="fs-xl mb-5">Ringkasan periode</h2>
    <div class="table-responsive">
      <table class="table">
        <thead>
          <tr>
            <th scope="col">Jumlah transaksi</th>
            <th scope="col">Total pendapatan</th>
            <th scope="col">Pelanggan unik</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><?= e($summary['total']) ?> transaksi</td>
            <td><?= e(rupiah($summary['pendapatan'])) ?></td>
            <td><?= e($summary['pelanggan']) ?> orang</td>
          </tr>
        </tbody>
      </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
    <script>
      new Chart(document.getElementById('chartSales'), {
        type: 'bar',
        data: {
          labels: <?= json_encode($labels, $jsonFlags) ?>,
          datasets: [{ label: 'Pendapatan', data: <?= json_encode($data, $jsonFlags) ?> }]
        },
        options: { scales: { y: { beginAtZero: true, ticks: { precision: 0 } } } }
      });
      document.getElementById('btnPrint').addEventListener('click', () => window.print());
    </script>
  <?php endif ?>
</main>
<?php require_once __DIR__ . '/../partials/footer.auth.php' ?>
