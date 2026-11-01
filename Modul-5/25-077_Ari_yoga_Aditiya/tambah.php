<?php
/**
 * File: tambah.php
 * Soal 4: Membuat halaman tambah data baru saat ditekan tombol tambah data
 */

require_once 'koneksi.php';

$pesan_error = "";

// Cek apakah tombol Simpan ditekan (metode POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama   = trim($_POST['nama']);
    $telp   = trim($_POST['telp']);
    $alamat = trim($_POST['alamat']);

    // Validasi sederhana
    if (empty($nama) || empty($telp) || empty($alamat)) {
        $pesan_error = "Semua kolom (Nama, Telp, Alamat) wajib diisi!";
    } else {
        // Mencegah SQL Injection dengan mysqli_real_escape_string
        $nama   = mysqli_real_escape_string($conn, $nama);
        $telp   = mysqli_real_escape_string($conn, $telp);
        $alamat = mysqli_real_escape_string($conn, $alamat);

        $query = "INSERT INTO supplier (nama, telp, alamat) VALUES ('$nama', '$telp', '$alamat')";
        $result = mysqli_query($conn, $query);

        if ($result) {
            // Berhasil simpan, redirect kembali ke halaman utama
            header("Location: index.php");
            exit;
        } else {
            $pesan_error = "Gagal menyimpan data: " . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Master Supplier Baru</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="form-card">
    <h2 class="form-title">Tambah Data Master Supplier Baru</h2>

    <?php if (!empty($pesan_error)): ?>
        <div class="alert alert-danger"><?= $pesan_error; ?></div>
    <?php endif; ?>

    <form action="tambah.php" method="POST">
        <div class="form-group">
            <label for="nama">Nama</label>
            <input type="text" name="nama" id="nama" class="form-control" placeholder="Nama" required autofocus>
        </div>

        <div class="form-group">
            <label for="telp">Telp</label>
            <input type="text" name="telp" id="telp" class="form-control" placeholder="Telp" required>
        </div>

        <div class="form-group">
            <label for="alamat">Alamat</label>
            <input type="text" name="alamat" id="alamat" class="form-control" placeholder="Alamat" required>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-simpan">Simpan</button>
            <a href="index.php" class="btn btn-batal">Batal</a>
        </div>
    </form>
</div>

</body>
</html>
