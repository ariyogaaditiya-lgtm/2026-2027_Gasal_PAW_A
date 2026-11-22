<?php

if (!method_is('POST')) {
    redirect('user');
}

wajibOwner();
csrf_verify();

$id = (int) ($_POST['id_user'] ?? 0);
$currentId = (int) ($_SESSION['user']['id_user'] ?? 0);

if ($id === $currentId) {
    redirect('user?error=self');
}

$stmt = $conn->prepare('DELETE FROM user WHERE id_user = ?');
$stmt->execute([$id]);

redirect('user');
