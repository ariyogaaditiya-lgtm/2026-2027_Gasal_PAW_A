<?php

if (!method_is('POST')) {
    redirect('barang');
}

wajibOwner();
csrf_verify();

$kodeBarang = trim((string) ($_POST['kode_barang'] ?? ''));
$namaBarang = trim((string) ($_POST['nama_barang'] ?? ''));
$harga = (float) ($_POST['harga'] ?? 0);
$stok = (int) ($_POST['stok'] ?? 0);
$supplierId = trim((string) ($_POST['supplier_id'] ?? ''));
$supplierId = $supplierId === '' ? null : (int) $supplierId;

try {
    $stmt = $conn->prepare('INSERT INTO barang (kode_barang, nama_barang, harga, stok, supplier_id) VALUES (?, ?, ?, ?, ?)');
    $stmt->execute([$kodeBarang, $namaBarang, $harga, $stok, $supplierId]);
} catch (PDOException $e) {
    redirect('barang?error=duplicate');
}

redirect('barang');
