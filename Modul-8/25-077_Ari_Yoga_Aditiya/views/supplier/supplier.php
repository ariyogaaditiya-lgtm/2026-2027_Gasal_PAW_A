<?php require_once __DIR__ . '/../partials/header.auth.php' ?>
<main class="container py-5">
  <div class="d-flex align-items-center justify-content-between mb-7">
    <h1 class="mb-0">Data Supplier</h1>
    <a class="btn btn-solid theme-primary" href="<?= e(url('supplier/add')) ?>">Tambah Supplier</a>
  </div>
  <div class="card">
    <div class="card-body">
      <?php
      $rows = $conn->query('SELECT id, nama, telp, alamat FROM supplier ORDER BY id DESC')->fetchAll();
      if (!$rows):
        ?>
        <div class="alert theme-warning mb-0" role="alert">Belum ada data supplier.</div>
      <?php else: ?>
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">No</th>
                <th scope="col">Nama Supplier</th>
                <th scope="col">Telepon</th>
                <th scope="col">Alamat</th>
                <th scope="col">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($rows as $i => $row): ?>
                <?php $id = (int) $row['id']; ?>
                <tr>
                  <td><?= e($i + 1) ?></td>
                  <td><?= e($row['nama'] ?? '') ?></td>
                  <td><?= e($row['telp'] ?? '') ?></td>
                  <td><?= e($row['alamat'] ?? '') ?></td>
                  <td>
                    <a class="btn btn-text theme-primary" href="<?= e(url('supplier/edit?id=' . $id)) ?>">Edit</a>
                    <form method="post" action="<?= e(url('api/supplier/delete')) ?>" class="d-inline"
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
