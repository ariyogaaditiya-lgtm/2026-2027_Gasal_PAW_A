<?php require_once __DIR__ . '/partials/header.auth.php' ?>
<main class="container py-5">
  <h1 class="mb-7">Home</h1>
  <div class="card mb-7">
    <div class="card-body">
      <p class="fs-lg mb-3">Selamat datang di aplikasi penjualan.</p>
      <p class="mb-0">Anda login sebagai <strong><?= e(user_nama()) ?></strong> (<?= e(level_label(user_level())) ?>)</p>
    </div>
  </div>
  <div class="card">
    <div class="card-body">
      <h2 class="h5 mb-5">Hak akses</h2>
      <?php if (user_level() === 1): ?>
        <p class="mb-0">Owner: Home, Data Master, Transaksi, dan Laporan.</p>
      <?php else: ?>
        <p class="mb-0">Kasir: Home, Transaksi, dan Laporan.</p>
      <?php endif ?>
    </div>
  </div>
</main>
<?php require_once __DIR__ . '/partials/footer.auth.php' ?>
