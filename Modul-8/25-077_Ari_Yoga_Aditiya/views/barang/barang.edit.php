<?php
$id = query_int('id');
$stmt = $conn->prepare('SELECT id, kode_barang, nama_barang, harga, stok, supplier_id FROM barang WHERE id = ?');
$stmt->execute([$id]);
$row = $stmt->fetch();

if (!$row) {
    http_response_code(404);
    require_once __DIR__ . '/../404.php';
    exit;
}

$suppliers = $conn->query('SELECT id, nama FROM supplier ORDER BY nama ASC')->fetchAll();
require_once __DIR__ . '/../partials/header.auth.php';
?>
<main class="container py-5">
  <h1 class="h3 mb-7">Ubah Barang</h1>
  <div class="card">
    <div class="card-body">
      <form method="post" action="<?= e(url('api/barang/edit')) ?>">
        <?= csrf_field() ?>
        <input type="hidden" name="id" value="<?= e($id) ?>">
        <div class="form-field mb-5">
          <label class="form-label" for="kode_barang">Kode Barang</label>
          <input class="form-control" type="text" id="kode_barang" name="kode_barang" value="<?= e($row['kode_barang']) ?>" maxlength="30" required autofocus>
        </div>
        <div class="form-field mb-5">
          <label class="form-label" for="nama_barang">Nama Barang</label>
          <input class="form-control" type="text" id="nama_barang" name="nama_barang" value="<?= e($row['nama_barang']) ?>" maxlength="100" required>
        </div>
        <div class="form-field mb-5">
          <label class="form-label" for="harga">Harga</label>
          <input class="form-control" type="number" id="harga" name="harga" value="<?= e(number_format((float) $row['harga'], 2, '.', '')) ?>" min="0" step="0.01" required>
        </div>
        <div class="form-field mb-5">
          <label class="form-label" for="stok">Stok</label>
          <input class="form-control" type="number" id="stok" name="stok" value="<?= e($row['stok']) ?>" min="0" step="1" required>
        </div>
        <div class="form-field mb-7">
          <label class="form-label" for="supplier_id">Supplier</label>
          <select class="form-select" id="supplier_id" name="supplier_id">
            <option value="">Tanpa supplier</option>
            <?php foreach ($suppliers as $supplier): ?>
              <option value="<?= e($supplier['id']) ?>"<?= (int) $row['supplier_id'] === (int) $supplier['id'] ? ' selected' : '' ?>><?= e($supplier['nama']) ?></option>
            <?php endforeach ?>
          </select>
        </div>
        <div class="d-flex flex-wrap gap-3">
          <button type="submit" class="btn btn-solid theme-primary">Perbarui</button>
          <a class="btn btn-outline theme-primary" href="<?= e(url('barang')) ?>">Kembali</a>
        </div>
      </form>
    </div>
  </div>
</main>
<?php require_once __DIR__ . '/../partials/footer.auth.php' ?>
