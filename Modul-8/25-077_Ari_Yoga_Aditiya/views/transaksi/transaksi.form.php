<?php
$pelanggan = $conn->query('SELECT id, nama FROM pelanggan ORDER BY nama ASC')->fetchAll();
$barang = $conn->query('SELECT id, kode_barang, nama_barang, harga, stok FROM barang WHERE stok > 0 ORDER BY nama_barang ASC')->fetchAll();

$errors = [
    'qty' => 'Jumlah barang tidak valid.',
    'stok' => 'Barang tidak ditemukan atau stok tidak cukup.',
    'gagal' => 'Transaksi gagal. Silakan coba lagi.',
];
$error = (string) ($_GET['error'] ?? '');

require_once __DIR__ . '/../partials/header.auth.php';
?>
<main class="container py-5">
  <h1 class="h3 mb-7">Buat Transaksi</h1>
  <?php if (isset($errors[$error])): ?>
    <div class="alert theme-danger mb-7" role="alert"><?= e($errors[$error]) ?></div>
  <?php endif ?>
  <div class="card">
    <div class="card-body">
      <?php if (!$barang): ?>
        <div class="alert theme-warning mb-0" role="alert">
          Belum ada barang dengan stok tersedia.
          <a href="<?= e(url('barang/add')) ?>">Tambah barang</a> terlebih dahulu.
        </div>
      <?php else: ?>
        <form method="post" action="<?= e(url('api/transaksi/add')) ?>">
          <?= csrf_field() ?>
          <div class="form-field mb-5">
            <label class="form-label" for="pelanggan_id">Pelanggan</label>
            <select class="form-select" id="pelanggan_id" name="pelanggan_id">
              <option value="">Umum</option>
              <?php foreach ($pelanggan as $p): ?>
                <option value="<?= e($p['id']) ?>"><?= e($p['nama']) ?></option>
              <?php endforeach ?>
            </select>
          </div>
          <div class="form-field mb-5">
            <label class="form-label" for="barang_id">Barang</label>
            <select class="form-select" id="barang_id" name="barang_id" required autofocus>
              <?php foreach ($barang as $b): ?>
                <option value="<?= e($b['id']) ?>"><?= e($b['kode_barang'] . ' - ' . $b['nama_barang'] . ' (' . rupiah($b['harga']) . ', stok ' . $b['stok'] . ')') ?></option>
              <?php endforeach ?>
            </select>
          </div>
          <div class="form-field mb-5">
            <label class="form-label" for="qty">Jumlah</label>
            <input class="form-control" type="number" id="qty" name="qty" value="<?= old('qty', '1') ?>" min="1" step="1" required>
          </div>
          <div class="form-field mb-7">
            <label class="form-label" for="metode">Metode Pembayaran</label>
            <select class="form-select" id="metode" name="metode">
              <option value="Tunai">Tunai</option>
              <option value="Transfer">Transfer</option>
              <option value="QRIS">QRIS</option>
            </select>
          </div>
          <div class="d-flex flex-wrap gap-3">
            <button type="submit" class="btn btn-solid theme-primary">Simpan Transaksi</button>
            <a class="btn btn-outline theme-primary" href="<?= e(url('transaksi')) ?>">Kembali</a>
          </div>
        </form>
      <?php endif ?>
    </div>
  </div>
</main>
<?php require_once __DIR__ . '/../partials/footer.auth.php' ?>
