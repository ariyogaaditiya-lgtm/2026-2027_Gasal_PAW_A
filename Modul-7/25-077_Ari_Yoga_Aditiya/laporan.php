<?php
/**
 * Mengambil rekap penjualan harian berdasarkan rentang tanggal.
 * Tabel yang digunakan: transaksi (waktu_transaksi, total, pelanggan_id).
 */
function ambilLaporan(PDO $pdo, string $tanggalMulai, string $tanggalSelesai): array
{
    $sql = "SELECT DATE(waktu_transaksi) AS tanggal,
                   COUNT(*) AS jumlah_transaksi,
                   SUM(total) AS pendapatan
            FROM transaksi
            WHERE waktu_transaksi >= :mulai
              AND waktu_transaksi < DATE_ADD(:selesai, INTERVAL 1 DAY)
            GROUP BY DATE(waktu_transaksi)
            ORDER BY DATE(waktu_transaksi) ASC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':mulai' => $tanggalMulai,
        ':selesai' => $tanggalSelesai
    ]);

    return $stmt->fetchAll();
}

function ambilRingkasan(PDO $pdo, string $tanggalMulai, string $tanggalSelesai): array
{
    $sql = "SELECT COUNT(DISTINCT pelanggan_id) AS pelanggan_unik,
                   COALESCE(SUM(total), 0) AS total_pendapatan,
                   COUNT(*) AS jumlah_transaksi
            FROM transaksi
            WHERE waktu_transaksi >= :mulai
              AND waktu_transaksi < DATE_ADD(:selesai, INTERVAL 1 DAY)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':mulai' => $tanggalMulai,
        ':selesai' => $tanggalSelesai
    ]);

    return $stmt->fetch() ?: [
        'pelanggan_unik' => 0,
        'total_pendapatan' => 0,
        'jumlah_transaksi' => 0
    ];
}

function formatRupiah($angka): string
{
    return 'Rp ' . number_format((float) $angka, 0, ',', '.');
}
