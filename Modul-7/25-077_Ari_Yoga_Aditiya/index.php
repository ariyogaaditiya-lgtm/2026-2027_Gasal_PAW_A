<?php
require_once __DIR__ . '/config/koneksi.php';
require_once __DIR__ . '/functions/laporan.php';

$tanggalHariIni = date('Y-m-d');
$tanggalMulai = $_GET['tanggal_mulai'] ?? date('Y-m-01');
$tanggalSelesai = $_GET['tanggal_selesai'] ?? $tanggalHariIni;

// Validasi format tanggal dan urutan rentang.
$validMulai = DateTime::createFromFormat('Y-m-d', $tanggalMulai);
$validSelesai = DateTime::createFromFormat('Y-m-d', $tanggalSelesai);
if (!$validMulai || $validMulai->format('Y-m-d') !== $tanggalMulai ||
    !$validSelesai || $validSelesai->format('Y-m-d') !== $tanggalSelesai ||
    $tanggalMulai > $tanggalSelesai) {
    $tanggalMulai = date('Y-m-01');
    $tanggalSelesai = $tanggalHariIni;
}

$laporan = ambilLaporan($pdo, $tanggalMulai, $tanggalSelesai);
$ringkasan = ambilRingkasan($pdo, $tanggalMulai, $tanggalSelesai);

$labelGrafik = [];
$dataGrafik = [];
foreach ($laporan as $baris) {
    $labelGrafik[] = date('d-m-Y', strtotime($baris['tanggal']));
    $dataGrafik[] = (int) $baris['pendapatan'];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporting Penjualan</title>
    <link rel="stylesheet" href="assets/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<main class="container">
    <header class="page-header">
        <div>
            <p class="eyebrow">SISTEM INFORMASI PENJUALAN</p>
            <h1>Laporan Penjualan</h1>
            <p class="subtitle">Rekap pendapatan berdasarkan rentang tanggal transaksi.</p>
        </div>
    </header>

    <section class="panel filter-panel">
        <h2>Filter Laporan</h2>
        <form method="GET" action="index.php" class="filter-form">
            <div class="form-group">
                <label for="tanggal_mulai">Tanggal Mulai</label>
                <input type="date" id="tanggal_mulai" name="tanggal_mulai"
                       value="<?= htmlspecialchars($tanggalMulai) ?>" required>
            </div>
            <div class="form-group">
                <label for="tanggal_selesai">Tanggal Selesai</label>
                <input type="date" id="tanggal_selesai" name="tanggal_selesai"
                       value="<?= htmlspecialchars($tanggalSelesai) ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Tampilkan</button>
        </form>
        <?php if ($tanggalMulai > $tanggalSelesai): ?>
            <p class="error">Tanggal mulai tidak boleh melebihi tanggal selesai.</p>
        <?php endif; ?>
    </section>

    <section class="summary-grid">
        <article class="summary-card">
            <span class="summary-label">Pelanggan Unik</span>
            <strong><?= number_format((int)$ringkasan['pelanggan_unik'], 0, ',', '.') ?></strong>
            <small>COUNT(DISTINCT pelanggan_id)</small>
        </article>
        <article class="summary-card">
            <span class="summary-label">Total Pendapatan</span>
            <strong><?= formatRupiah($ringkasan['total_pendapatan']) ?></strong>
            <small>Akumulasi SUM(total)</small>
        </article>
        <article class="summary-card">
            <span class="summary-label">Jumlah Transaksi</span>
            <strong><?= number_format((int)$ringkasan['jumlah_transaksi'], 0, ',', '.') ?></strong>
            <small>Dalam periode terpilih</small>
        </article>
    </section>

    <section class="panel">
        <div class="section-heading">
            <div>
                <h2>Grafik Pendapatan Harian</h2>
                <p><?= date('d/m/Y', strtotime($tanggalMulai)) ?> – <?= date('d/m/Y', strtotime($tanggalSelesai)) ?></p>
            </div>
        </div>
        <div class="chart-wrap">
            <canvas id="grafikPenjualan"></canvas>
        </div>
    </section>

    <section class="panel">
        <div class="section-heading">
            <div>
                <h2>Rekapitulasi Penjualan Harian</h2>
                <p>Data transaksi dikelompokkan berdasarkan tanggal.</p>
            </div>
            <div class="action-buttons no-print">
                <button type="button" class="btn btn-outline" onclick="window.print()">Cetak</button>
                <a class="btn btn-success"
                   href="export_excel.php?tanggal_mulai=<?= urlencode($tanggalMulai) ?>&tanggal_selesai=<?= urlencode($tanggalSelesai) ?>">
                    Ekspor Excel
                </a>
            </div>
        </div>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Tanggal Transaksi</th>
                        <th>Jumlah Transaksi</th>
                        <th>Total Pendapatan</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (count($laporan) > 0): ?>
                    <?php foreach ($laporan as $index => $baris): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= date('d-m-Y', strtotime($baris['tanggal'])) ?></td>
                            <td><?= number_format((int)$baris['jumlah_transaksi'], 0, ',', '.') ?></td>
                            <td><?= formatRupiah($baris['pendapatan']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="4" class="empty">Tidak ada transaksi pada rentang tanggal ini.</td></tr>
                <?php endif; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3">Total Keseluruhan</th>
                        <th><?= formatRupiah($ringkasan['total_pendapatan']) ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </section>

    <footer class="footer no-print">Reporting Penjualan</footer>
</main>

<script>
const labelTanggal = <?= json_encode($labelGrafik, JSON_UNESCAPED_UNICODE) ?>;
const dataPendapatan = <?= json_encode($dataGrafik) ?>;

new Chart(document.getElementById('grafikPenjualan'), {
    type: 'bar',
    data: {
        labels: labelTanggal,
        datasets: [{
            label: 'Total Pendapatan (Rp)',
            data: dataPendapatan,
            backgroundColor: 'rgba(49, 130, 206, 0.75)',
            borderColor: 'rgba(49, 130, 206, 1)',
            borderWidth: 1,
            borderRadius: 5
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: true },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return 'Rp ' + new Intl.NumberFormat('id-ID').format(context.raw);
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: value => 'Rp ' + new Intl.NumberFormat('id-ID').format(value)
                },
                title: { display: true, text: 'Nominal Pendapatan' }
            },
            x: {
                title: { display: true, text: 'Tanggal Transaksi' }
            }
        }
    }
});
</script>
</body>
</html>
