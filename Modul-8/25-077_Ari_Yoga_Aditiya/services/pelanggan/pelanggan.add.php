<?php

if (!method_is('POST')) {
    redirect('pelanggan');
}

wajibOwner();
csrf_verify();

$nama = trim((string) ($_POST['nama'] ?? ''));
$jenisKelamin = trim((string) ($_POST['jenis_kelamin'] ?? ''));
$jenisKelamin = $jenisKelamin === 'P' ? 'P' : 'L';
$telp = trim((string) ($_POST['telp'] ?? ''));
$alamat = trim((string) ($_POST['alamat'] ?? ''));

if ($nama !== '') {
    $stmt = $conn->prepare('INSERT INTO pelanggan (nama, jenis_kelamin, telp, alamat) VALUES (?, ?, ?, ?)');
    $stmt->execute([$nama, $jenisKelamin, $telp, $alamat]);
}

redirect('pelanggan');
