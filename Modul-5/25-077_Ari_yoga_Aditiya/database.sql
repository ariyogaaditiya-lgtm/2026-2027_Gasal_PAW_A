-- =====================================================================
-- MODUL 5 : DATABASE - TUGAS PRAKTIKUM
-- =====================================================================

-- Membuat Database
CREATE DATABASE IF NOT EXISTS `db_praktikum_modul5`;
USE `db_praktikum_modul5`;

-- =====================================================================
-- SOAL 1: MEMBUAT SKEMA DATABASE (DDL - DATA DEFINITION LANGUAGE)
-- =====================================================================

-- 1. Tabel Pelanggan
DROP TABLE IF EXISTS `pembayaran`;
DROP TABLE IF EXISTS `transaksi_detail`;
DROP TABLE IF EXISTS `transaksi`;
DROP TABLE IF EXISTS `barang`;
DROP TABLE IF EXISTS `supplier`;
DROP TABLE IF EXISTS `pelanggan`;
DROP TABLE IF EXISTS `user`;

CREATE TABLE `pelanggan` (
  `id` VARCHAR(20) NOT NULL,
  `nama` VARCHAR(100) NOT NULL,
  `jenis_kelamin` ENUM('L', 'P') NOT NULL,
  `telp` VARCHAR(12) NOT NULL,
  `alamat` TEXT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 2. Tabel Supplier
CREATE TABLE `supplier` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nama` VARCHAR(100) NOT NULL,
  `telp` VARCHAR(12) NOT NULL,
  `alamat` TEXT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 3. Tabel Barang
CREATE TABLE `barang` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `kode_barang` VARCHAR(10) NOT NULL,
  `nama_barang` VARCHAR(100) NOT NULL,
  `harga` INT(11) NOT NULL,
  `stok` INT(11) NOT NULL,
  `supplier_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_barang_supplier` FOREIGN KEY (`supplier_id`) 
    REFERENCES `supplier` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 4. Tabel User
CREATE TABLE `user` (
  `id_user` TINYINT(2) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(30) NOT NULL,
  `password` VARCHAR(35) NOT NULL,
  `nama` VARCHAR(50) NOT NULL,
  `alamat` VARCHAR(150) NOT NULL,
  `hp` VARCHAR(20) NOT NULL,
  `level` TINYINT(1) NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 5. Tabel Transaksi
CREATE TABLE `transaksi` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `waktu_transaksi` DATE NOT NULL,
  `keterangan` TEXT,
  `total` INT(11) NOT NULL,
  `pelanggan_id` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_transaksi_pelanggan` FOREIGN KEY (`pelanggan_id`) 
    REFERENCES `pelanggan` (`id`) ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 6. Tabel Transaksi Detail (Composite Primary Key: transaksi_id + barang_id)
CREATE TABLE `transaksi_detail` (
  `transaksi_id` INT(11) NOT NULL,
  `barang_id` INT(11) NOT NULL,
  `harga` INT(11) NOT NULL,
  `qty` INT(11) NOT NULL,
  PRIMARY KEY (`transaksi_id`, `barang_id`),
  CONSTRAINT `fk_detail_transaksi` FOREIGN KEY (`transaksi_id`) 
    REFERENCES `transaksi` (`id`) ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT `fk_detail_barang` FOREIGN KEY (`barang_id`) 
    REFERENCES `barang` (`id`) ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 7. Tabel Pembayaran
CREATE TABLE `pembayaran` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `waktu_bayar` DATETIME NOT NULL,
  `total` INT(11) NOT NULL,
  `metode` ENUM('TUNAI', 'TRANSFER', 'EDC') NOT NULL,
  `transaksi_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_pembayaran_transaksi` FOREIGN KEY (`transaksi_id`) 
    REFERENCES `transaksi` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- =====================================================================
-- SOAL 2: MENGISI DATA MASTER DAN DATA TRANSAKSI (MINIMAL 10 DATA/TABEL)
-- =====================================================================

-- 1. Insert Data Tabel `pelanggan` (10 Data)
INSERT INTO `pelanggan` (`id`, `nama`, `jenis_kelamin`, `telp`, `alamat`) VALUES
('PLG001', 'Budi Santoso', 'L', '081234567890', 'Jl. Merdeka No. 10, Surabaya'),
('PLG002', 'Siti Rahma', 'P', '081234567891', 'Jl. Kenanga No. 5, Sidoarjo'),
('PLG003', 'Ahmad Dani', 'L', '081234567892', 'Jl. Mawar No. 12, Malang'),
('PLG004', 'Dewi Lestari', 'P', '081234567893', 'Jl. Diponegoro No. 8, Gresik'),
('PLG005', 'Eko Prasetyo', 'L', '081234567894', 'Jl. Pemuda No. 15, Mojokerto'),
('PLG006', 'Rina Marlina', 'P', '081234567895', 'Jl. Pahlawan No. 20, Bangkalan'),
('PLG007', 'Fajar Ramadhan', 'L', '081234567896', 'Jl. Kartini No. 3, Pasuruan'),
('PLG008', 'Gita Gutawa', 'P', '081234567897', 'Jl. Sudirman No. 7, Jombang'),
('PLG009', 'Hendra Gunawan', 'L', '081234567898', 'Jl. Melati No. 4, Kediri'),
('PLG010', 'Indah Permata', 'P', '081234567899', 'Jl. Anggrek No. 11, Surabaya');

-- 2. Insert Data Tabel `supplier` (10 Data - sesuai screenshot soal)
INSERT INTO `supplier` (`id`, `nama`, `telp`, `alamat`) VALUES
(1, 'PT Maju Bersama', '08123456', 'Surabaya'),
(2, 'PT Senang Sekali', '081515563', 'Bangkalan'),
(3, 'PT Seger Seger', '0845454663', 'Surabaya'),
(4, 'CV Berkah Abadi', '08561234', 'Sidoarjo'),
(5, 'PT Makmur Sentosa', '08781234', 'Malang'),
(6, 'UD Sumber Rejeki', '08991234', 'Mojokerto'),
(7, 'CV Jaya Mandiri', '08211234', 'Gresik'),
(8, 'PT Harapan Bangsa', '08381234', 'Pasuruan'),
(9, 'CV Prima Utama', '08191234', 'Kediri'),
(10, 'PT Gemilang Sejahtera', '08521234', 'Jombang');

-- 3. Insert Data Tabel `user` (10 Data)
INSERT INTO `user` (`id_user`, `username`, `password`, `nama`, `alamat`, `hp`, `level`) VALUES
(1, 'admin1', MD5('admin123'), 'Ari Yoga Aditiya', 'Kamal, Bangkalan', '081234567801', 1),
(2, 'kasir1', MD5('kasir123'), 'Siti Nurhaliza', 'Jl. Telang Indah, Bangkalan', '081234567802', 2),
(3, 'kasir2', MD5('kasir456'), 'Bambang Tri', 'Jl. Raya Kamal No. 12', '081234567803', 2),
(4, 'gudang1', MD5('gudang123'), 'Dodi Pratama', 'Jl. Mayjen Sungkono, Surabaya', '081234567804', 3),
(5, 'gudang2', MD5('gudang456'), 'Eko Wahyudi', 'Jl. Basuki Rahmat, Surabaya', '081234567805', 3),
(6, 'manager1', MD5('manager123'), 'Farhan Maulana', 'Perum Nilam, Surabaya', '081234567806', 1),
(7, 'kasir3', MD5('kasir789'), 'Gina Agustin', 'Jl. Veteran No. 4, Bangkalan', '081234567807', 2),
(8, 'admin2', MD5('admin456'), 'Hadi Firmansyah', 'Jl. Kusuma Bangsa, Sidoarjo', '081234567808', 1),
(9, 'spv1', MD5('spv123'), 'Irwan Saputra', 'Jl. Ahmad Yani No. 8, Gresik', '081234567809', 2),
(10, 'owner', MD5('owner123'), 'Joko Widodo', 'Jl. Diponegoro No. 1, Surabaya', '081234567810', 1);

-- 4. Insert Data Tabel `barang` (10 Data)
INSERT INTO `barang` (`id`, `kode_barang`, `nama_barang`, `harga`, `stok`, `supplier_id`) VALUES
(1, 'BRG001', 'Kertas HVS A4 70gr', 45000, 100, 1),
(2, 'BRG002', 'Pulpen Gel Hitam 0.5', 3500, 250, 2),
(3, 'BRG003', 'Pensil 2B Faber Castell', 2500, 180, 3),
(4, 'BRG004', 'Penghapus Joyko Putih', 1500, 120, 4),
(5, 'BRG005', 'Penggaris Besi 30cm', 7000, 85, 5),
(6, 'BRG006', 'Spidol Whiteboard Hitam', 8000, 90, 6),
(7, 'BRG007', 'Buku Tulis Sinar Dunia 38', 4000, 300, 7),
(8, 'BRG008', 'Map Dokumen Folio Plastik', 3000, 150, 8),
(9, 'BRG009', 'Stapler Kangaro HD-10', 12000, 60, 9),
(10, 'BRG010', 'Gunting Kertas Sedang', 6500, 75, 10);

-- 5. Insert Data Tabel `transaksi` (10 Data)
INSERT INTO `transaksi` (`id`, `waktu_transaksi`, `keterangan`, `total`, `pelanggan_id`) VALUES
(1, '2026-10-01', 'Pembelian ATK Sekolah', 90000, 'PLG001'),
(2, '2026-10-02', 'Pembelian Perlengkapan Kantor', 14000, 'PLG002'),
(3, '2026-10-03', 'Kebutuhan Ujian Siswa', 25000, 'PLG003'),
(4, '2026-10-04', 'Pengadaan ATK Bulanan', 45000, 'PLG004'),
(5, '2026-10-05', 'Pembelian Spidol dan Kertas', 61000, 'PLG005'),
(6, '2026-10-06', 'Perlengkapan Kasir Kantor', 36000, 'PLG006'),
(7, '2026-10-07', 'Pembelian Buku dan Pulpen', 20000, 'PLG007'),
(8, '2026-10-08', 'Pengadaan Map Dokumen', 15000, 'PLG008'),
(9, '2026-10-09', 'Pembelian Gunting dan Stapler', 30500, 'PLG009'),
(10, '2026-10-10', 'Pembelian Paket Lengkap ATK', 105000, 'PLG010');

-- 6. Insert Data Tabel `transaksi_detail` (10 Data)
INSERT INTO `transaksi_detail` (`transaksi_id`, `barang_id`, `harga`, `qty`) VALUES
(1, 1, 45000, 2),
(2, 2, 3500, 4),
(3, 3, 2500, 10),
(4, 1, 45000, 1),
(5, 6, 8000, 2),
(6, 9, 12000, 3),
(7, 7, 4000, 5),
(8, 8, 3000, 5),
(9, 10, 6500, 2),
(10, 1, 45000, 1);

-- 7. Insert Data Tabel `pembayaran` (10 Data)
INSERT INTO `pembayaran` (`id`, `waktu_bayar`, `total`, `metode`, `transaksi_id`) VALUES
(1, '2026-10-01 10:15:00', 90000, 'TUNAI', 1),
(2, '2026-10-02 11:20:00', 14000, 'TRANSFER', 2),
(3, '2026-10-03 14:05:00', 25000, 'EDC', 3),
(4, '2026-10-04 09:30:00', 45000, 'TUNAI', 4),
(5, '2026-10-05 16:45:00', 61000, 'TRANSFER', 5),
(6, '2026-10-06 13:10:00', 36000, 'EDC', 6),
(7, '2026-10-07 15:25:00', 20000, 'TUNAI', 7),
(8, '2026-10-08 10:50:00', 15000, 'TRANSFER', 8),
(9, '2026-10-09 12:40:00', 30500, 'EDC', 9),
(10, '2026-10-10 17:00:00', 105000, 'TUNAI', 10);
