<?php require_once __DIR__ . '/../partials/header.auth.php' ?>
<main class="container py-5">
  <h1 class="mb-7">Tambah Supplier</h1>
  <div class="card">
    <div class="card-body">
      <form method="post" action="<?= e(url('api/supplier/add')) ?>">
        <?= csrf_field() ?>
        <div class="form-field mb-5">
          <label class="form-label" for="nama">Nama Supplier</label>
          <input class="form-control" type="text" id="nama" name="nama" value="<?= old('nama') ?>" maxlength="100" required>
        </div>
        <div class="form-field mb-5">
          <label class="form-label" for="telp">Telepon</label>
          <input class="form-control" type="text" id="telp" name="telp" value="<?= old('telp') ?>" maxlength="20">
        </div>
        <div class="form-field mb-7">
          <label class="form-label" for="alamat">Alamat</label>
          <textarea class="form-control" id="alamat" name="alamat" rows="3"><?= old('alamat') ?></textarea>
        </div>
        <div class="d-flex gap-3">
          <button type="submit" class="btn btn-solid theme-primary">Simpan</button>
          <a class="btn btn-outline theme-primary" href="<?= e(url('supplier')) ?>">Kembali</a>
        </div>
      </form>
    </div>
  </div>
</main>
<?php require_once __DIR__ . '/../partials/footer.auth.php' ?>
