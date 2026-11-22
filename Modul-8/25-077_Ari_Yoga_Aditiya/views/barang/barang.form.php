<?php
$suppliers = $conn->query('SELECT id, nama FROM supplier ORDER BY nama ASC')->fetchAll();
require_once __DIR__ . '/../partials/header.auth.php';
?>
<main class="container py-5">
  <h1 class="h3 mb-7">Tambah Barang</h1>
  <div class="card">
    <div class="card-body">
      <form method="post" action="<?= e(url('api/barang/add')) ?>">
        <?= csrf_field() ?>
        <div class="form-field mb-5">
          <label class="form-label" for="kode_barang">Kode Barang</label>
          <input class="form-control" type="text" id="kode_barang" name="kode_barang" value="<?= old('kode_barang') ?>" maxlength="30" required autofocus>
        </div>
        <div class="form-field mb-5">
          <label class="form-label" for="nama_barang">Nama Barang</label>
          <input class="form-control" type="text" id="nama_barang" name="nama_barang" value="<?= old('nama_barang') ?>" maxlength="100" required>
        </div>
        <div class="form-field mb-5">
          <label class="form-label" for="harga">Harga</label>
          <input class="form-control" type="number" id="harga" name="harga" value="<?= old('harga', '0') ?>" min="0" step="0.01" required>
        </div>
        <div class="form-field mb-5">
          <label class="form-label" for="stok">Stok</label>
          <input class="form-control" type="number" id="stok" name="stok" value="<?= old('stok', '0') ?>" min="0" step="1" required>
        </div>
        <div class="form-field mb-7">
          <label class="form-label" for="supplier_id">Supplier</label>
          <select class="form-select" id="supplier_id" name="supplier_id">
            <option value="">Tanpa supplier</option>
            <?php foreach ($suppliers as $supplier): ?>
              <option value="<?= e($supplier['id']) ?>"><?= e($supplier['nama']) ?></option>
            <?php endforeach ?>
          </select>
        </div>
        <div class="d-flex flex-wrap gap-3">
          <button type="submit" class="btn btn-solid theme-primary">Simpan</button>
          <a class="btn btn-outline theme-primary" href="<?= e(url('barang')) ?>">Kembali</a>
        </div>
      </form>
    </div>
  </div>
</main>
<?php require_once __DIR__ . '/../partials/footer.auth.php' ?>
