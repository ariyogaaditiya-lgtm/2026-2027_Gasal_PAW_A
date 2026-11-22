<?php
$sql = <<<SQL
  SELECT
    t.id,
    t.waktu_transaksi,
    t.total,
    p.nama AS pelanggan,
    b.nama_barang,
    d.qty,
    py.metode
  FROM transaksi AS t
  LEFT JOIN pelanggan AS p ON p.id = t.pelanggan_id
  LEFT JOIN transaksi_detail AS d ON d.transaksi_id = t.id
  LEFT JOIN barang AS b ON b.id = d.barang_id
  LEFT JOIN pembayaran AS py ON py.transaksi_id = t.id
  ORDER BY t.id DESC;
SQL;

$rows = $conn->query($sql)->fetchAll();
require_once __DIR__ . '/../partials/header.auth.php';
?>
<main class="container py-5">
  <div class="d-flex flex-wrap gap-3 align-items-center justify-content-between mb-7">
    <h1 class="h3 mb-0">Transaksi</h1>
    <a class="btn btn-solid theme-primary" href="<?= e(url('transaksi/add')) ?>">Buat Transaksi</a>
  </div>
  <div class="card">
    <div class="card-body">
      <?php if (!$rows): ?>
        <div class="alert theme-warning mb-0" role="alert">Belum ada transaksi.</div>
      <?php else: ?>
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">ID</th>
                <th scope="col">Waktu</th>
                <th scope="col">Pelanggan</th>
                <th scope="col">Barang</th>
                <th scope="col">Qty</th>
                <th scope="col">Total</th>
                <th scope="col">Metode</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($rows as $row): ?>
                <tr>
                  <td>#<?= e($row['id']) ?></td>
                  <td><?= e(tanggal($row['waktu_transaksi'])) ?></td>
                  <td><?= e($row['pelanggan'] ?? 'Umum') ?></td>
                  <td><?= e($row['nama_barang'] ?? '-') ?></td>
                  <td><?= e($row['qty'] ?? '-') ?></td>
                  <td><?= e(rupiah($row['total'])) ?></td>
                  <td><?= e($row['metode'] ?? '-') ?></td>
                </tr>
              <?php endforeach ?>
            </tbody>
          </table>
        </div>
      <?php endif ?>
    </div>
  </div>
</main>
<?php require_once __DIR__ . '/../partials/footer.auth.php' ?>
