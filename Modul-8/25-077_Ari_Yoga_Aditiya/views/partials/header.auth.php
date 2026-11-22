<?php
$activePath = $path ?? '/';
$pageTitle = $pageTitle ?? 'Aplikasi Penjualan';
?>
<!doctype html>
<html lang="id" data-bs-theme="light">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($pageTitle) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@6.0.0-alpha.1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?= e(asset_url('app.css')) ?>" rel="stylesheet">
</head>

<body>
  <nav class="navbar md:navbar-expand bg-1">
    <div class="container">
      <a class="navbar-brand" href="<?= e(url('')) ?>">Sistem Penjualan</a>
      <button class="btn-icon navbar-toggler" type="button" data-bs-toggle="drawer" data-bs-target="#menu"
        aria-controls="menu" aria-expanded="false" aria-label="Buka menu"><span class="navbar-toggler-icon"
          aria-hidden="true"></span></button>
      <dialog class="drawer drawer-end" tabindex="-1" id="menu" aria-labelledby="menuLabel">
        <div class="drawer-header">
          <h5 class="drawer-title" id="menuLabel">Menu</h5>
          <button type="button" class="btn-close" data-bs-dismiss="drawer" aria-label="Tutup"></button>
        </div>
        <div class="drawer-body">
          <ul class="nav navbar-nav ms-auto">
            <li class="nav-item"><a class="nav-link<?= is_active('/', $activePath) ?>" href="<?= e(url('')) ?>">Home</a></li>
            <?php if (user_level() === 1): ?>
              <li class="nav-item"><a class="nav-link<?= is_active('/barang', $activePath) ?>" href="<?= e(url('barang')) ?>">Data Barang</a></li>
              <li class="nav-item"><a class="nav-link<?= is_active('/supplier', $activePath) ?>" href="<?= e(url('supplier')) ?>">Data Supplier</a></li>
              <li class="nav-item"><a class="nav-link<?= is_active('/pelanggan', $activePath) ?>" href="<?= e(url('pelanggan')) ?>">Data Pelanggan</a></li>
              <li class="nav-item"><a class="nav-link<?= is_active('/user', $activePath) ?>" href="<?= e(url('user')) ?>">Data User</a></li>
            <?php endif ?>
            <li class="nav-item"><a class="nav-link<?= is_active('/transaksi', $activePath) ?>" href="<?= e(url('transaksi')) ?>">Transaksi</a></li>
            <li class="nav-item"><a class="nav-link<?= is_active('/laporan', $activePath) ?>" href="<?= e(url('laporan')) ?>">Laporan</a></li>
            <li class="nav-item">
              <form method="post" action="<?= e(url('logout')) ?>" class="d-inline">
                <?= csrf_field() ?>
                <button type="submit" class="nav-link btn btn-text theme-danger">Keluar</button>
              </form>
            </li>
          </ul>
        </div>
      </dialog>
      <span class="ms-auto d-none md:d-inline">Halo, <?= e(user_nama()) ?> (<?= e(level_label(user_level())) ?>)</span>
    </div>
  </nav>
