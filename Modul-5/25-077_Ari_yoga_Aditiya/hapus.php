<?php
/**
 * File: hapus.php
 * Soal 6: Proses hapus data supplier yang dipilih dari database
 */

require_once 'koneksi.php';

// Cek apakah ada parameter ID yang dikirimkan melalui URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = intval($_GET['id']);

    // Jalankan query penghapusan data
    $query = "DELETE FROM supplier WHERE id = $id";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Gagal menghapus data supplier: " . mysqli_error($conn));
    }
}

// Redirect kembali ke halaman utama tabel master supplier
header("Location: index.php");
exit;
?>
