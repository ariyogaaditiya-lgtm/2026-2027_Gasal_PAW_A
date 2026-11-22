<?php

if (!method_is('POST')) {
    redirect('user');
}

wajibOwner();
csrf_verify();

$id = (int) ($_POST['id_user'] ?? 0);
$username = trim((string) ($_POST['username'] ?? ''));
$nama = trim((string) ($_POST['nama'] ?? ''));
$alamat = trim((string) ($_POST['alamat'] ?? ''));
$hp = trim((string) ($_POST['hp'] ?? ''));
$level = (int) ($_POST['level'] ?? 2);
$level = in_array($level, [1, 2], true) ? $level : 2;

$values = [
    'username' => $username,
    'nama' => $nama,
    'alamat' => $alamat,
    'hp' => $hp,
    'level' => $level,
];

$password = (string) ($_POST['password'] ?? '');
if (trim($password) !== '') {
    $values['password'] = password_hash($password, PASSWORD_DEFAULT);
}

try {
    build_update($conn, 'user', 'id_user', $id, $values);
} catch (PDOException $e) {
    redirect('user?error=duplicate');
}

redirect('user');
