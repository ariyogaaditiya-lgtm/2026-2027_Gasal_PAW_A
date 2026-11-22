<?php

require_once __DIR__ . '/config/app.php';
require_once __DIR__ . '/config/paths.php';
require_once __DIR__ . '/config/koneksi.php';
require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/csrf.php';

try {
    $path = $_SERVER['PATH_INFO'] ?? '/';
    $path = rtrim($path, '/');
    if ($path === '') {
        $path = '/';
    }

    $guestRoutes = ['/login', '/sign-in'];
    $ownerPrefixes = ['/barang', '/supplier', '/pelanggan', '/user'];

    if (in_array($path, $guestRoutes, true)) {
        sudahLoginJanganKeLogin();
    } else {
        wajibLogin();

        foreach ($ownerPrefixes as $prefix) {
            if (strpos($path, $prefix) === 0) {
                wajibOwner();
                break;
            }
        }
    }

    switch ($path) {
        case '/':
            $pageTitle = 'Home';
            require_once __DIR__ . '/views/index.php';
            break;

        case '/login':
            $pageTitle = 'Login';
            require_once __DIR__ . '/views/login.php';
            break;

        case '/sign-in':
            require_once __DIR__ . '/services/auth/login.php';
            break;

        case '/logout':
            require_once __DIR__ . '/services/auth/logout.php';
            break;

        case '/barang':
            $pageTitle = 'Data Barang';
            require_once __DIR__ . '/views/barang/barang.php';
            break;
        case '/barang/add':
            $pageTitle = 'Tambah Barang';
            require_once __DIR__ . '/views/barang/barang.form.php';
            break;
        case '/barang/edit':
            $pageTitle = 'Ubah Barang';
            require_once __DIR__ . '/views/barang/barang.edit.php';
            break;
        case '/api/barang/add':
            require_once __DIR__ . '/services/barang/barang.add.php';
            break;
        case '/api/barang/edit':
            require_once __DIR__ . '/services/barang/barang.edit.php';
            break;
        case '/api/barang/delete':
            require_once __DIR__ . '/services/barang/barang.delete.php';
            break;

        case '/supplier':
            $pageTitle = 'Data Supplier';
            require_once __DIR__ . '/views/supplier/supplier.php';
            break;
        case '/supplier/add':
            $pageTitle = 'Tambah Supplier';
            require_once __DIR__ . '/views/supplier/supplier.form.php';
            break;
        case '/supplier/edit':
            $pageTitle = 'Ubah Supplier';
            require_once __DIR__ . '/views/supplier/supplier.edit.php';
            break;
        case '/api/supplier/add':
            require_once __DIR__ . '/services/supplier/supplier.add.php';
            break;
        case '/api/supplier/edit':
            require_once __DIR__ . '/services/supplier/supplier.edit.php';
            break;
        case '/api/supplier/delete':
            require_once __DIR__ . '/services/supplier/supplier.delete.php';
            break;

        case '/pelanggan':
            $pageTitle = 'Data Pelanggan';
            require_once __DIR__ . '/views/pelanggan/pelanggan.php';
            break;
        case '/pelanggan/add':
            $pageTitle = 'Tambah Pelanggan';
            require_once __DIR__ . '/views/pelanggan/pelanggan.form.php';
            break;
        case '/pelanggan/edit':
            $pageTitle = 'Ubah Pelanggan';
            require_once __DIR__ . '/views/pelanggan/pelanggan.edit.php';
            break;
        case '/api/pelanggan/add':
            require_once __DIR__ . '/services/pelanggan/pelanggan.add.php';
            break;
        case '/api/pelanggan/edit':
            require_once __DIR__ . '/services/pelanggan/pelanggan.edit.php';
            break;
        case '/api/pelanggan/delete':
            require_once __DIR__ . '/services/pelanggan/pelanggan.delete.php';
            break;

        case '/user':
            $pageTitle = 'Data User';
            require_once __DIR__ . '/views/user/user.php';
            break;
        case '/user/add':
            $pageTitle = 'Tambah User';
            require_once __DIR__ . '/views/user/user.form.php';
            break;
        case '/user/edit':
            $pageTitle = 'Ubah User';
            require_once __DIR__ . '/views/user/user.edit.php';
            break;
        case '/api/user/add':
            require_once __DIR__ . '/services/user/user.add.php';
            break;
        case '/api/user/edit':
            require_once __DIR__ . '/services/user/user.edit.php';
            break;
        case '/api/user/delete':
            require_once __DIR__ . '/services/user/user.delete.php';
            break;

        case '/transaksi':
            $pageTitle = 'Transaksi';
            require_once __DIR__ . '/views/transaksi/transaksi.php';
            break;
        case '/transaksi/add':
            $pageTitle = 'Buat Transaksi';
            require_once __DIR__ . '/views/transaksi/transaksi.form.php';
            break;
        case '/api/transaksi/add':
            require_once __DIR__ . '/services/transaksi/transaksi.add.php';
            break;

        case '/laporan':
            $pageTitle = 'Laporan Transaksi';
            require_once __DIR__ . '/views/laporan/laporan.php';
            break;
        case '/api/laporan/export':
            require_once __DIR__ . '/services/laporan/laporan.export.php';
            break;

        default:
            $pageTitle = '404';
            http_response_code(404);
            require_once __DIR__ . '/views/404.php';
            break;
    }
} catch (Throwable $e) {
    error_log('Application error: ' . $e->getMessage());
    http_response_code(500);
    require_once __DIR__ . '/views/500.php';
}
