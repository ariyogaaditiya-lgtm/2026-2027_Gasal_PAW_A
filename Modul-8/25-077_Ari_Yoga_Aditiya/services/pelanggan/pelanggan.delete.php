<?php

if (!method_is('POST')) {
    redirect('pelanggan');
}

wajibOwner();
csrf_verify();

$id = (int) ($_POST['id'] ?? 0);

if ($id > 0) {
    $stmt = $conn->prepare('DELETE FROM pelanggan WHERE id = ?');
    $stmt->execute([$id]);
}

redirect('pelanggan');
