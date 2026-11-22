<?php

if (!method_is('POST')) {
    redirect('barang');
}

wajibOwner();
csrf_verify();

$id = (int) ($_POST['id'] ?? 0);

try {
    $stmt = $conn->prepare('DELETE FROM barang WHERE id = ?');
    $stmt->execute([$id]);
} catch (PDOException $e) {
    redirect('barang?error=in_use');
}

redirect('barang');
