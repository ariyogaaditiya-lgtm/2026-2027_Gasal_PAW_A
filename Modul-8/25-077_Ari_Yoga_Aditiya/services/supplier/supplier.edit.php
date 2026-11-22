<?php

if (!method_is('POST')) {
    redirect('supplier');
}

wajibOwner();
csrf_verify();

$id = (int) ($_POST['id'] ?? 0);
$nama = trim((string) ($_POST['nama'] ?? ''));
$telp = trim((string) ($_POST['telp'] ?? ''));
$alamat = trim((string) ($_POST['alamat'] ?? ''));

if ($id > 0 && $nama !== '') {
    build_update($conn, 'supplier', 'id', $id, [
        'nama' => $nama,
        'telp' => $telp,
        'alamat' => $alamat,
    ]);
}

redirect('supplier');
