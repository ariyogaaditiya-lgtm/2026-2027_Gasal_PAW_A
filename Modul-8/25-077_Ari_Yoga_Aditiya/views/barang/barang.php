<?php
$sql = <<<SQL
  SELECT
    b.id,
    b.kode_barang,
    b.nama_barang,
    b.harga,
    b.stok,
    s.nama AS supplier
  FROM barang AS b
  LEFT JOIN supplier AS s ON b.supplier_id = s.id
  ORDER BY b.id DESC;
SQL;

$rows = $conn->query($sql)->fetchAll();
require_once __DIR__ . '/../partials/header.auth.php';
?>
<main class="container py-5">
  <div class="d-flex flex-wrap gap-3 align-items-center justify-content-between mb-7">
    <h1 class="h3 mb-0">Data Barang</h1>
    <a class="btn btn-solid theme-primary" href="<?= e(url('barang/add')) ?>">Tambah Barang</a>
  </div>
  <?php if (($_GET['error'] ?? '') === 'duplicate'): ?>
    <div class="alert theme-danger mb-7" role="alert">Kode barang sudah digunakan atau supplier tidak valid.</div>
  <?php endif ?>
  <?php if (($_GET['error'] ?? '') === 'in_use'): ?>
    <div class="alert theme-warning mb-7" role="alert">Barang tidak bisa dihapus karena masih dipakai transaksi.</div>
  <?php endif ?>
  <div class="card">
    <div class="card-body">
      <?php if (!$rows): ?>
        <div class="alert theme-warning mb-0" role="alert">Belum ada data barang.</div>
      <?php else: ?>
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">Kode</th>
                <th scope="col">Nama Barang</th>
                <th scope="col">Harga</th>
                <th scope="col">Stok</th>
                <th scope="col">Supplier</th>
                <th scope="col">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($rows as $row): ?>
                <?php $id = (int) $row['id']; ?>
                <tr>
                  <td><?= e($row['kode_barang']) ?></td>
                  <td><?= e($row['nama_barang']) ?></td>
                  <td><?= e(rupiah($row['harga'])) ?></td>
                  <td><?= e($row['stok']) ?></td>
                  <td><?= e($row['supplier'] ?? '-') ?></td>
                  <td class="table-actions">
                    <a class="btn btn-text theme-primary" href="<?= e(url('barang/edit?id=' . $id)) ?>">Ubah</a>
                    <form method="post" action="<?= e(url('api/barang/delete')) ?>" class="d-inline"
                      onsubmit="return confirm('Hapus data ini?')">
                      <?= csrf_field() ?>
                      <input type="hidden" name="id" value="<?= e($id) ?>">
                      <button type="submit" class="btn btn-text theme-danger">Hapus</button>
                    </form>
                  </td>
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
