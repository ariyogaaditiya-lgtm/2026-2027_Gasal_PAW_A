<?php
$pageTitle = $pageTitle ?? 'Login';
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
  <nav class="navbar bg-1">
    <div class="container">
      <a class="navbar-brand" href="<?= e(url('login')) ?>">Sistem Penjualan</a>
    </div>
  </nav>
