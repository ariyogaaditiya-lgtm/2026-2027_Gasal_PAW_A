<?php

if (!method_is('POST')) {
    redirect('pelanggan');
}

wajibOwner();
csrf_verify();

$id = (int) ($_POST['id'] ?? 0);
$nama = trim((string) ($_POST['nama'] ?? ''));
$jenisKelamin = trim((string) ($_POST['jenis_kelamin'] ?? ''));
$jenisKelamin = $jenisKelamin === 'P' ? 'P' : 'L';
$telp = trim((string) ($_POST['telp'] ?? ''));
$alamat = trim((string) ($_POST['alamat'] ?? ''));

if ($id > 0 && $nama !== '') {
    build_update($conn, 'pelanggan', 'id', $id, [
        'nama' => $nama,
        'jenis_kelamin' => $jenisKelamin,
        'telp' => $telp,
        'alamat' => $alamat,
    ]);
}

redirect('pelanggan');
