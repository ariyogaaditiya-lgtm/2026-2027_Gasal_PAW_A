<?php

if (!method_is('POST')) {
    redirect('barang');
}

wajibOwner();
csrf_verify();

$id = (int) ($_POST['id'] ?? 0);
$kodeBarang = trim((string) ($_POST['kode_barang'] ?? ''));
$namaBarang = trim((string) ($_POST['nama_barang'] ?? ''));
$harga = (float) ($_POST['harga'] ?? 0);
$stok = (int) ($_POST['stok'] ?? 0);
$supplierId = trim((string) ($_POST['supplier_id'] ?? ''));
$supplierId = $supplierId === '' ? null : (int) $supplierId;

try {
    build_update($conn, 'barang', 'id', $id, [
        'kode_barang' => $kodeBarang,
        'nama_barang' => $namaBarang,
        'harga' => $harga,
        'stok' => $stok,
        'supplier_id' => $supplierId,
    ]);
} catch (PDOException $e) {
    redirect('barang?error=duplicate');
}

redirect('barang');
