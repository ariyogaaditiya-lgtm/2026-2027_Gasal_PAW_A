<?php require_once __DIR__ . '/partials/header.guest.php' ?>
<main class="container py-9">
  <div class="card login-card mx-auto">
    <div class="card-body">
      <h1 class="h3 mb-5">Login Sistem Penjualan</h1>
      <?php if (isset($_GET['error'])): ?>
        <div class="alert theme-danger mb-5" role="alert">Username atau password salah.</div>
      <?php endif ?>
      <form method="post" action="<?= e(url('sign-in')) ?>">
        <?= csrf_field() ?>
        <div class="form-field mb-5">
          <label class="form-label" for="username">Username</label>
          <input class="form-control" type="text" id="username" name="username" required autofocus>
        </div>
        <div class="form-field mb-7">
          <label class="form-label" for="password">Password</label>
          <input class="form-control" type="password" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-solid theme-primary w-100">Login</button>
      </form>
    </div>
  </div>
</main>
<?php require_once __DIR__ . '/partials/footer.guest.php' ?>
