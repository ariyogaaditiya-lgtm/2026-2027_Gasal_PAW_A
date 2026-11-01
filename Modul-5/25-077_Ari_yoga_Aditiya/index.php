<?php
/**
 * File: index.php
 * Soal 3: Membuat tampilan dan mengambil data dari database (Data Master Supplier)
 * Soal 6: Menghubungkan tombol hapus dengan konfirmasi popup dialog
 */

require_once 'koneksi.php';

// Mengambil seluruh data dari tabel supplier diurutkan berdasarkan id ASC
$query = "SELECT * FROM supplier ORDER BY id ASC";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query error: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Master Supplier</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <!-- Header: Judul dan Tombol Tambah Data -->
    <div class="header-area">
        <h2 class="title-primary">Data Master Supplier</h2>
        <a href="tambah.php" class="btn btn-tambah">Tambah Data</a>
    </div>

    <!-- Tabel Data Master Supplier -->
    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 50px;" class="text-center">No</th>
                    <th>Nama</th>
                    <th style="width: 140px;">Telp</th>
                    <th>Alamat</th>
                    <th style="width: 150px;" class="text-center">Tindakan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <tr>
                    <td class="text-center"><?= $no++; ?></td>
                    <td><?= htmlspecialchars($row['nama']); ?></td>
                    <td><?= htmlspecialchars($row['telp']); ?></td>
                    <td><?= htmlspecialchars($row['alamat']); ?></td>
                    <td class="text-center">
                        <!-- Tombol Edit (Soal 5) -->
                        <a href="edit.php?id=<?= $row['id']; ?>" class="btn btn-edit">Edit</a>
                        
                        <!-- Tombol Hapus dengan Popup JavaScript Confirm (Soal 6) -->
                        <a href="hapus.php?id=<?= $row['id']; ?>" 
                           onclick="return confirm('Anda yakin akan menghapus supplier ini?');" 
                           class="btn btn-hapus">Hapus</a>
                    </td>
                </tr>
                <?php
                    }
                } else {
                ?>
                <tr>
                    <td colspan="5" class="text-center" style="padding: 20px; color: #888;">
                        Belum ada data supplier. Silakan klik tombol <strong>Tambah Data</strong>.
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
