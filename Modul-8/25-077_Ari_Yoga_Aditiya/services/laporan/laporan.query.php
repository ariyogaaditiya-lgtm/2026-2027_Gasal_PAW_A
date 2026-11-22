<?php

function getSalesReport(PDO $conn, string $mulai, string $selesai): array
{
    $rekapSQL = <<<SQL
      SELECT
        DATE(waktu_transaksi) AS tgl,
        COUNT(*) AS total,
        COALESCE(SUM(total), 0) AS pendapatan,
        COUNT(DISTINCT pelanggan_id) AS pelanggan
      FROM transaksi
      WHERE DATE(waktu_transaksi) BETWEEN ? AND ?
      GROUP BY DATE(waktu_transaksi)
      ORDER BY tgl ASC;
    SQL;

    $summarySQL = <<<SQL
      SELECT
        COUNT(*) AS total,
        COALESCE(SUM(total), 0) AS pendapatan,
        COUNT(DISTINCT pelanggan_id) AS pelanggan
      FROM transaksi
      WHERE DATE(waktu_transaksi) BETWEEN ? AND ?;
    SQL;

    $rekap = $conn->prepare($rekapSQL);
    $rekap->execute([$mulai, $selesai]);

    $summary = $conn->prepare($summarySQL);
    $summary->execute([$mulai, $selesai]);

    return [$rekap->fetchAll(), $summary->fetch()];
}
