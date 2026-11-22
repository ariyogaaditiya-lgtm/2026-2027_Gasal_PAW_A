<?php require_once __DIR__ . '/../partials/header.auth.php' ?>
<main class="container py-5">
  <div class="card">
    <div class="card-body">
      <h1 class="h3 mb-7">Tambah User</h1>
      <?php $level = old('level', '2') ?>
      <form method="post" action="<?= e(url('api/user/add')) ?>">
        <?= csrf_field() ?>
        <div class="form-field mb-5">
          <label class="form-label" for="username">Username</label>
          <input class="form-control" type="text" id="username" name="username" value="<?= old('username') ?>" maxlength="50" required autofocus>
        </div>
        <div class="form-field mb-5">
          <label class="form-label" for="password">Password</label>
          <input class="form-control" type="password" id="password" name="password" required>
        </div>
        <div class="form-field mb-5">
          <label class="form-label" for="nama">Nama</label>
          <input class="form-control" type="text" id="nama" name="nama" value="<?= old('nama') ?>" maxlength="100" required>
        </div>
        <div class="form-field mb-5">
          <label class="form-label" for="alamat">Alamat</label>
          <input class="form-control" type="text" id="alamat" name="alamat" value="<?= old('alamat') ?>">
        </div>
        <div class="form-field mb-5">
          <label class="form-label" for="hp">No. HP</label>
          <input class="form-control" type="text" id="hp" name="hp" value="<?= old('hp') ?>" maxlength="20">
        </div>
        <div class="form-field mb-7">
          <label class="form-label" for="level">Level</label>
          <select class="form-control" id="level" name="level" required>
            <option value="1" <?= $level === '1' ? 'selected' : '' ?>>1 - Owner</option>
            <option value="2" <?= $level === '2' ? 'selected' : '' ?>>2 - Kasir</option>
          </select>
        </div>
        <div class="d-flex flex-wrap gap-3">
          <button type="submit" class="btn btn-solid theme-primary">Simpan</button>
          <a class="btn btn-outline theme-primary" href="<?= e(url('user')) ?>">Kembali</a>
        </div>
      </form>
    </div>
  </div>
</main>
<?php require_once __DIR__ . '/../partials/footer.auth.php' ?>
