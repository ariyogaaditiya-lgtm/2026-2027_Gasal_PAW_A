<?php

if (!method_is('POST')) {
    redirect('login');
}

csrf_verify();

$username = trim((string) ($_POST['username'] ?? ''));
$password = (string) ($_POST['password'] ?? '');

$stmt = $conn->prepare("SELECT id_user, username, password, nama, level FROM user WHERE username = ?");
$stmt->execute([$username]);
$data = $stmt->fetch();

$valid = false;

if ($data) {
    if (strlen($data['password']) === 32 && ctype_xdigit($data['password'])) {
        $valid = hash_equals(strtolower($data['password']), md5($password));

        if ($valid) {
            $hashBaru = password_hash($password, PASSWORD_DEFAULT);
            $up = $conn->prepare("UPDATE user SET password = ? WHERE id_user = ?");
            $up->execute([$hashBaru, $data['id_user']]);
        }
    } else {
        $valid = password_verify($password, $data['password']);
    }
}

if (!$valid) {
    redirect('login?error=1');
}

session_regenerate_id(true);
unset($_SESSION['csrf_token']);
$_SESSION['user'] = [
    'id_user' => $data['id_user'],
    'username' => $data['username'],
    'nama' => $data['nama'],
    'level' => (int) $data['level'],
];

redirect('');
