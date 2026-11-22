<?php

if (!method_is('POST')) {
    redirect('transaksi');
}

wajibLogin();
csrf_verify();

$barangId = (int) ($_POST['barang_id'] ?? 0);
$qty = (int) ($_POST['qty'] ?? 0);
$pelangganId = (string) ($_POST['pelanggan_id'] ?? '') === '' ? null : (int) $_POST['pelanggan_id'];
$metode = (string) ($_POST['metode'] ?? 'Tunai');
$metode = in_array($metode, ['Tunai', 'Transfer', 'QRIS'], true) ? $metode : 'Tunai';

if ($barangId <= 0 || $qty <= 0) {
    redirect('transaksi/add?error=qty');
}

try {
    $conn->beginTransaction();

    $stmt = $conn->prepare('SELECT id, harga, stok FROM barang WHERE id = ? FOR UPDATE');
    $stmt->execute([$barangId]);
    $barang = $stmt->fetch();

    if (!$barang || (int) $barang['stok'] < $qty) {
        throw new Exception('stok');
    }

    $total = (float) $barang['harga'] * $qty;

    $stmt = $conn->prepare('INSERT INTO transaksi (waktu_transaksi, keterangan, total, pelanggan_id) VALUES (NOW(), ?, ?, ?)');
    $stmt->execute(['Transaksi kasir', $total, $pelangganId]);
    $transaksiId = (int) $conn->lastInsertId();

    $stmt = $conn->prepare('INSERT INTO transaksi_detail (transaksi_id, barang_id, harga, qty) VALUES (?, ?, ?, ?)');
    $stmt->execute([$transaksiId, $barangId, $barang['harga'], $qty]);

    $stmt = $conn->prepare('UPDATE barang SET stok = stok - ? WHERE id = ?');
    $stmt->execute([$qty, $barangId]);

    $stmt = $conn->prepare('INSERT INTO pembayaran (waktu_bayar, total, metode, transaksi_id) VALUES (NOW(), ?, ?, ?)');
    $stmt->execute([$total, $metode, $transaksiId]);

    $conn->commit();
} catch (Throwable $e) {
    if ($conn->inTransaction()) {
        $conn->rollBack();
    }
    error_log('Transaction failed: ' . $e->getMessage());
    redirect('transaksi/add?error=gagal');
}

redirect('transaksi');
