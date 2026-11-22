<?php
$users = $conn->query('SELECT id_user, username, nama, alamat, hp, level FROM user ORDER BY id_user DESC')->fetchAll();
require_once __DIR__ . '/../partials/header.auth.php';
?>
<main class="container py-5">
  <div class="d-flex flex-wrap gap-3 align-items-center justify-content-between mb-7">
    <h1 class="h3 mb-0">Data User</h1>
    <a class="btn btn-outline theme-primary" href="<?= e(url('user/add')) ?>">Tambah User</a>
  </div>
  <?php if (($_GET['error'] ?? '') === 'duplicate'): ?>
    <div class="alert theme-danger mb-7" role="alert">Username sudah digunakan.</div>
  <?php endif ?>
  <?php if (($_GET['error'] ?? '') === 'self'): ?>
    <div class="alert theme-warning mb-7" role="alert">Akun sendiri tidak bisa dihapus.</div>
  <?php endif ?>
  <div class="card">
    <div class="card-body">
      <?php if (!$users): ?>
        <div class="alert theme-warning mb-0" role="alert">Belum ada data user.</div>
      <?php else: ?>
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">No</th>
                <th scope="col">Username</th>
                <th scope="col">Nama</th>
                <th scope="col">Alamat</th>
                <th scope="col">No. HP</th>
                <th scope="col">Level</th>
                <th scope="col">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1; foreach ($users as $row): ?>
                <?php $id = (int) $row['id_user']; ?>
                <tr>
                  <td><?= e($no++) ?></td>
                  <td><?= e($row['username']) ?></td>
                  <td><?= e($row['nama']) ?></td>
                  <td><?= e($row['alamat']) ?></td>
                  <td><?= e($row['hp']) ?></td>
                  <td><?= e(level_label($row['level'])) ?></td>
                  <td class="table-actions">
                    <a class="btn btn-text theme-primary" href="<?= e(url('user/edit?id=' . $id)) ?>">Ubah</a>
                    <form method="post" action="<?= e(url('api/user/delete')) ?>" class="d-inline" onsubmit="return confirm('Hapus data ini?')">
                      <?= csrf_field() ?>
                      <input type="hidden" name="id_user" value="<?= e($id) ?>">
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
