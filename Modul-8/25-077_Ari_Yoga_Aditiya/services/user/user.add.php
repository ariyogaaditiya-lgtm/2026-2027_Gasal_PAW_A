<?php

if (!method_is('POST')) {
    redirect('user');
}

wajibOwner();
csrf_verify();

$username = trim((string) ($_POST['username'] ?? ''));
$password = password_hash((string) ($_POST['password'] ?? ''), PASSWORD_DEFAULT);
$nama = trim((string) ($_POST['nama'] ?? ''));
$alamat = trim((string) ($_POST['alamat'] ?? ''));
$hp = trim((string) ($_POST['hp'] ?? ''));
$level = (int) ($_POST['level'] ?? 2);
$level = in_array($level, [1, 2], true) ? $level : 2;

try {
    $stmt = $conn->prepare('INSERT INTO user (username, password, nama, alamat, hp, level) VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->execute([$username, $password, $nama, $alamat, $hp, $level]);
} catch (PDOException $e) {
    redirect('user?error=duplicate');
}

redirect('user');
