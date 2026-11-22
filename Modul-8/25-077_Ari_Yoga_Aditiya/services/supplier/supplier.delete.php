<?php

if (!method_is('POST')) {
    redirect('supplier');
}

wajibOwner();
csrf_verify();

$id = (int) ($_POST['id'] ?? 0);

if ($id > 0) {
    $stmt = $conn->prepare('DELETE FROM supplier WHERE id = ?');
    $stmt->execute([$id]);
}

redirect('supplier');
