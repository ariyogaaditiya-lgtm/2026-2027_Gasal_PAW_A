<?php

require_once __DIR__ . '/partials/header.auth.php';
?>
<main class="container py-5">
  <div class="alert theme-danger" role="alert">
    <h1 class="h4">Akses ditolak</h1>
    <p class="mb-0">Halaman ini hanya untuk Owner.</p>
  </div>
  <a class="btn btn-outline theme-primary" href="<?= e(url('')) ?>">Kembali ke Home</a>
</main>
<?php require_once __DIR__ . '/partials/footer.auth.php'; ?>
