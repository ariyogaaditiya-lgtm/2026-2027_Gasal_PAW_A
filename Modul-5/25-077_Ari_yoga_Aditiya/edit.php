<?php
/**
 * File: edit.php
 * Soal 5: Membuat halaman edit data yang ada saat ditekan tombol edit
 */

require_once 'koneksi.php';

$pesan_error = "";

// 1. Ambil data supplier berdasarkan ID dari parameter URL ($_GET['id'])
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = intval($_GET['id']);
$query_ambil = "SELECT * FROM supplier WHERE id = $id";
$result_ambil = mysqli_query($conn, $query_ambil);

if (mysqli_num_rows($result_ambil) === 0) {
    die("Data supplier dengan ID tersebut tidak ditemukan.");
}

$supplier = mysqli_fetch_assoc($result_ambil);

// 2. Proses update data saat tombol Update ditekan (metode POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama   = trim($_POST['nama']);
    $telp   = trim($_POST['telp']);
    $alamat = trim($_POST['alamat']);

    if (empty($nama) || empty($telp) || empty($alamat)) {
        $pesan_error = "Semua kolom (Nama, Telp, Alamat) wajib diisi!";
    } else {
        $nama   = mysqli_real_escape_string($conn, $nama);
        $telp   = mysqli_real_escape_string($conn, $telp);
        $alamat = mysqli_real_escape_string($conn, $alamat);

        $query_update = "UPDATE supplier SET nama = '$nama', telp = '$telp', alamat = '$alamat' WHERE id = $id";
        $result_update = mysqli_query($conn, $query_update);

        if ($result_update) {
            // Berhasil update, redirect kembali ke halaman utama
            header("Location: index.php");
            exit;
        } else {
            $pesan_error = "Gagal memperbarui data: " . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Master Supplier</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="form-card">
    <h2 class="form-title">Edit Data Master Supplier</h2>

    <?php if (!empty($pesan_error)): ?>
        <div class="alert alert-danger"><?= $pesan_error; ?></div>
    <?php endif; ?>

    <form action="edit.php?id=<?= $id; ?>" method="POST">
        <div class="form-group">
            <label for="nama">Nama</label>
            <input type="text" name="nama" id="nama" class="form-control" 
                   value="<?= htmlspecialchars($supplier['nama']); ?>" required autofocus>
        </div>

        <div class="form-group">
            <label for="telp">Telp</label>
            <input type="text" name="telp" id="telp" class="form-control" 
                   value="<?= htmlspecialchars($supplier['telp']); ?>" required>
        </div>

        <div class="form-group">
            <label for="alamat">Alamat</label>
            <input type="text" name="alamat" id="alamat" class="form-control" 
                   value="<?= htmlspecialchars($supplier['alamat']); ?>" required>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-update">Update</button>
            <a href="index.php" class="btn btn-batal">Batal</a>
        </div>
    </form>
</div>

</body>
</html>
