<?php

if (!method_is('POST')) {
    redirect('supplier');
}

wajibOwner();
csrf_verify();

$nama = trim((string) ($_POST['nama'] ?? ''));
$telp = trim((string) ($_POST['telp'] ?? ''));
$alamat = trim((string) ($_POST['alamat'] ?? ''));

if ($nama !== '') {
    $stmt = $conn->prepare('INSERT INTO supplier (nama, telp, alamat) VALUES (?, ?, ?)');
    $stmt->execute([$nama, $telp, $alamat]);
}

redirect('supplier');
