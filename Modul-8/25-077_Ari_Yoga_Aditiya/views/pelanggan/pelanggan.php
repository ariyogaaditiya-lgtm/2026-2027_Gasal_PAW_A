<?php
$data = $conn->query('SELECT id, nama, jenis_kelamin, telp, alamat FROM pelanggan ORDER BY id DESC')->fetchAll();
require_once __DIR__ . '/../partials/header.auth.php';
?>
<main class="container py-5">
  <div class="d-flex flex-wrap gap-3 align-items-center justify-content-between mb-7">
    <h1 class="h3 mb-0">Data Pelanggan</h1>
    <a class="btn btn-solid theme-primary" href="<?= e(url('pelanggan/add')) ?>">Tambah Pelanggan</a>
  </div>
  <div class="card">
    <div class="card-body">
      <?php if (!$data): ?>
        <div class="alert theme-warning mb-0" role="alert">Belum ada data pelanggan.</div>
      <?php else: ?>
        <div class="table-responsive">
          <table class="table align-middle">
            <thead>
              <tr>
                <th scope="col">No</th>
                <th scope="col">Nama Pelanggan</th>
                <th scope="col">Jenis Kelamin</th>
                <th scope="col">Telepon</th>
                <th scope="col">Alamat</th>
                <th scope="col">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1; foreach ($data as $row): ?>
                <tr>
                  <td><?= e($no++) ?></td>
                  <td><?= e($row['nama'] ?? '') ?></td>
                  <td><?= e(($row['jenis_kelamin'] ?? '') === 'P' ? 'Perempuan' : 'Laki-laki') ?></td>
                  <td><?= e($row['telp'] ?? '') ?></td>
                  <td><?= e($row['alamat'] ?? '') ?></td>
                  <td class="table-actions">
                    <a class="btn btn-text theme-primary" href="<?= e(url('pelanggan/edit?id=' . (int) $row['id'])) ?>">Ubah</a>
                    <form method="post" action="<?= e(url('api/pelanggan/delete')) ?>" class="d-inline" onsubmit="return confirm('Hapus data ini?')">
                      <?= csrf_field() ?>
                      <input type="hidden" name="id" value="<?= e((int) $row['id']) ?>">
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
