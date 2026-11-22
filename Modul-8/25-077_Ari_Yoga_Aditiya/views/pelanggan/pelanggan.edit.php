<?php
$id = query_int('id');
$stmt = $conn->prepare('SELECT id, nama, jenis_kelamin, telp, alamat FROM pelanggan WHERE id = ?');
$stmt->execute([$id]);
$row = $stmt->fetch();

if (!$row) {
    http_response_code(404);
    require_once __DIR__ . '/../404.php';
    exit;
}

require_once __DIR__ . '/../partials/header.auth.php';
?>
<main class="container py-5">
  <h1 class="h3 mb-7">Ubah Pelanggan</h1>
  <div class="card">
    <div class="card-body">
      <form method="post" action="<?= e(url('api/pelanggan/edit')) ?>">
        <?= csrf_field() ?>
        <input type="hidden" name="id" value="<?= e($id) ?>">
        <div class="form-field mb-5">
          <label class="form-label" for="nama">Nama Pelanggan</label>
          <input class="form-control" type="text" id="nama" name="nama" value="<?= e($row['nama'] ?? '') ?>" maxlength="100" required autofocus>
        </div>
        <div class="form-field mb-5">
          <label class="form-label" for="jenis_kelamin">Jenis Kelamin</label>
          <select class="form-select" id="jenis_kelamin" name="jenis_kelamin">
            <option value="L"<?= ($row['jenis_kelamin'] ?? 'L') === 'L' ? ' selected' : '' ?>>Laki-laki</option>
            <option value="P"<?= ($row['jenis_kelamin'] ?? 'L') === 'P' ? ' selected' : '' ?>>Perempuan</option>
          </select>
        </div>
        <div class="form-field mb-5">
          <label class="form-label" for="telp">Telepon</label>
          <input class="form-control" type="text" id="telp" name="telp" value="<?= e($row['telp'] ?? '') ?>" maxlength="20">
        </div>
        <div class="form-field mb-7">
          <label class="form-label" for="alamat">Alamat</label>
          <textarea class="form-control" id="alamat" name="alamat" rows="3"><?= e($row['alamat'] ?? '') ?></textarea>
        </div>
        <div class="d-flex flex-wrap gap-3">
          <button type="submit" class="btn btn-solid theme-primary">Perbarui</button>
          <a class="btn btn-outline theme-primary" href="<?= e(url('pelanggan')) ?>">Kembali</a>
        </div>
      </form>
    </div>
  </div>
</main>
<?php require_once __DIR__ . '/../partials/footer.auth.php' ?>
