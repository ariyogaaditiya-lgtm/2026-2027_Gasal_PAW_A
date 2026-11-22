<?php
$id = query_int('id');
$stmt = $conn->prepare('SELECT id_user, username, nama, alamat, hp, level FROM user WHERE id_user = ?');
$stmt->execute([$id]);
$row = $stmt->fetch();

if (!$row) {
    http_response_code(404);
    require_once __DIR__ . '/../404.php';
    exit;
}

$level = old('level', (string) $row['level']);
require_once __DIR__ . '/../partials/header.auth.php';
?>
<main class="container py-5">
  <div class="card">
    <div class="card-body">
      <h1 class="h3 mb-7">Ubah User</h1>
      <form method="post" action="<?= e(url('api/user/edit')) ?>">
        <?= csrf_field() ?>
        <input type="hidden" name="id_user" value="<?= e($id) ?>">
        <div class="form-field mb-5">
          <label class="form-label" for="username">Username</label>
          <input class="form-control" type="text" id="username" name="username" value="<?= old('username', (string) $row['username']) ?>" maxlength="50" required autofocus>
        </div>
        <div class="form-field mb-5">
          <label class="form-label" for="password">Password (kosongkan jika tidak diganti)</label>
          <input class="form-control" type="password" id="password" name="password">
        </div>
        <div class="form-field mb-5">
          <label class="form-label" for="nama">Nama</label>
          <input class="form-control" type="text" id="nama" name="nama" value="<?= old('nama', (string) $row['nama']) ?>" maxlength="100" required>
        </div>
        <div class="form-field mb-5">
          <label class="form-label" for="alamat">Alamat</label>
          <input class="form-control" type="text" id="alamat" name="alamat" value="<?= old('alamat', (string) $row['alamat']) ?>">
        </div>
        <div class="form-field mb-5">
          <label class="form-label" for="hp">No. HP</label>
          <input class="form-control" type="text" id="hp" name="hp" value="<?= old('hp', (string) $row['hp']) ?>" maxlength="20">
        </div>
        <div class="form-field mb-7">
          <label class="form-label" for="level">Level</label>
          <select class="form-control" id="level" name="level" required>
            <option value="1" <?= $level === '1' ? 'selected' : '' ?>>1 - Owner</option>
            <option value="2" <?= $level === '2' ? 'selected' : '' ?>>2 - Kasir</option>
          </select>
        </div>
        <div class="d-flex flex-wrap gap-3">
          <button type="submit" class="btn btn-solid theme-primary">Perbarui</button>
          <a class="btn btn-outline theme-primary" href="<?= e(url('user')) ?>">Kembali</a>
        </div>
      </form>
    </div>
  </div>
</main>
<?php require_once __DIR__ . '/../partials/footer.auth.php' ?>
