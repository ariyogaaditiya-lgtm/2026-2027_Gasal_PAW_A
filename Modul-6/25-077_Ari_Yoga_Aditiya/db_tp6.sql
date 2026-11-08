-- Pembuatan Database
CREATE DATABASE IF NOT EXISTS db_tp6;
USE db_tp6;

-- 1. Tabel Supplier (Master)
CREATE TABLE supplier (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    telp VARCHAR(15),
    alamat TEXT
);

-- 2. Tabel Pelanggan (Master)
CREATE TABLE pelanggan (
    id VARCHAR(20) PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    jenis_kelamin ENUM('L', 'P'),
    telp VARCHAR(15),
    alamat TEXT
);

-- 3. Tabel User (Master)
CREATE TABLE user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    nama VARCHAR(50),
    alamat VARCHAR(150),
    hp VARCHAR(20),
    level TINYINT(1)
);

-- 4. Tabel Barang (Master)
CREATE TABLE barang (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kode_barang VARCHAR(10) NOT NULL,
    nama_barang VARCHAR(100) NOT NULL,
    harga INT NOT NULL,
    stok INT NOT NULL,
    supplier_id INT,
    -- Relasi FK, DEFAULT MySQL adalah RESTRICT. 
    -- Ini menjawab Soal No. 3 (Barang tidak bisa dihapus jika terkait dengan detail transaksi/supplier)
    FOREIGN KEY (supplier_id) REFERENCES supplier(id) ON DELETE RESTRICT ON UPDATE CASCADE
);

-- 5. Tabel Transaksi (Transaksi)
CREATE TABLE transaksi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    waktu_transaksi DATE NOT NULL,
    keterangan TEXT,
    total INT DEFAULT 0,
    pelanggan_id VARCHAR(20),
    FOREIGN KEY (pelanggan_id) REFERENCES pelanggan(id) ON DELETE RESTRICT ON UPDATE CASCADE
);

-- 6. Tabel Transaksi Detail (Transaksi)
CREATE TABLE transaksi_detail (
    id INT AUTO_INCREMENT PRIMARY KEY,
    transaksi_id INT,
    barang_id INT,
    harga INT NOT NULL,
    qty INT NOT NULL,
    FOREIGN KEY (transaksi_id) REFERENCES transaksi(id) ON DELETE CASCADE ON UPDATE CASCADE,
    -- Ini menjawab Soal No. 3, RESTRICT mencegah barang dihapus jika ada di transaksi_detail
    FOREIGN KEY (barang_id) REFERENCES barang(id) ON DELETE RESTRICT ON UPDATE CASCADE
);

-- 7. Tabel Pembayaran (Transaksi)
CREATE TABLE pembayaran (
    id INT AUTO_INCREMENT PRIMARY KEY,
    waktu_bayar DATETIME NOT NULL,
    total INT NOT NULL,
    metode ENUM('TUNAI', 'TRANSFER', 'EDC'),
    transaksi_id INT,
    FOREIGN KEY (transaksi_id) REFERENCES transaksi(id) ON DELETE RESTRICT ON UPDATE CASCADE
);

-- ===================================================================================
-- JAWABAN SOAL NO 4: Trigger untuk update otomatis kolom total pada tabel transaksi
-- ===================================================================================
DELIMITER $$

CREATE TRIGGER trg_after_insert_detail
AFTER INSERT ON transaksi_detail
FOR EACH ROW
BEGIN
    UPDATE transaksi 
    SET total = (SELECT IFNULL(SUM(harga * qty), 0) FROM transaksi_detail WHERE transaksi_id = NEW.transaksi_id)
    WHERE id = NEW.transaksi_id;
END$$

CREATE TRIGGER trg_after_update_detail
AFTER UPDATE ON transaksi_detail
FOR EACH ROW
BEGIN
    UPDATE transaksi 
    SET total = (SELECT IFNULL(SUM(harga * qty), 0) FROM transaksi_detail WHERE transaksi_id = NEW.transaksi_id)
    WHERE id = NEW.transaksi_id;
END$$

CREATE TRIGGER trg_after_delete_detail
AFTER DELETE ON transaksi_detail
FOR EACH ROW
BEGIN
    UPDATE transaksi 
    SET total = (SELECT IFNULL(SUM(harga * qty), 0) FROM transaksi_detail WHERE transaksi_id = OLD.transaksi_id)
    WHERE id = OLD.transaksi_id;
END$$

DELIMITER ;

-- ===================================================================================
-- INPUT DATA MASTER (Minimal 5 Data Sesuai Soal)
-- ===================================================================================
INSERT INTO supplier (nama, telp, alamat) VALUES
('PT Sumber Makmur', '081234567890', 'Jl. Merdeka No. 1, Jakarta'),
('CV Maju Bersama', '081298765432', 'Jl. Sudirman No. 2, Bandung'),
('Toko Sinar Jaya', '081311223344', 'Jl. Pahlawan No. 3, Surabaya'),
('UD Tiga Roda', '081455667788', 'Jl. Diponegoro No. 4, Semarang'),
('PT Global Solusi', '081599887766', 'Jl. Gatot Subroto No. 5, Medan');

INSERT INTO pelanggan (id, nama, jenis_kelamin, telp, alamat) VALUES
('PEL-001', 'Budi Santoso', 'L', '085611112222', 'Jl. Mawar No. 10, Jakarta'),
('PEL-002', 'Siti Aminah', 'P', '085733334444', 'Jl. Melati No. 20, Bandung'),
('PEL-003', 'Andi Wijaya', 'L', '085855556666', 'Jl. Anggrek No. 30, Surabaya'),
('PEL-004', 'Rina Marlina', 'P', '085977778888', 'Jl. Kamboja No. 40, Semarang'),
('PEL-005', 'Joko Susanto', 'L', '081199990000', 'Jl. Kenanga No. 50, Medan');

INSERT INTO user (username, password, nama, alamat, hp, level) VALUES
('admin', 'admin123', 'Administrator', 'Kantor Pusat', '081100001111', 1),
('kasir1', 'kasir123', 'Kasir Satu', 'Cabang A', '081100002222', 2),
('kasir2', 'kasir123', 'Kasir Dua', 'Cabang B', '081100003333', 2),
('gudang1', 'gudang123', 'Staf Gudang', 'Gudang Utama', '081100004444', 3),
('manager', 'manager123', 'Manager Toko', 'Kantor Pusat', '081100005555', 1);

INSERT INTO barang (kode_barang, nama_barang, harga, stok, supplier_id) VALUES
('BRG-001', 'Laptop Asus VivoBook', 8500000, 20, 1),
('BRG-002', 'Mouse Wireless Logitech', 150000, 50, 2),
('BRG-003', 'Keyboard Mechanical', 450000, 30, 3),
('BRG-004', 'Monitor Samsung 24 Inch', 2100000, 15, 4),
('BRG-005', 'Flashdisk SanDisk 64GB', 120000, 100, 5);

-- ===================================================================================
-- INPUT DATA TRANSAKSI (Minimal 10 Data Transaksi Sesuai Soal)
-- ===================================================================================
-- Insert 10 Header Transaksi (Total dibiarkan 0, nanti di-update oleh trigger saat detail masuk)
INSERT INTO transaksi (waktu_transaksi, keterangan, total, pelanggan_id) VALUES
('2026-11-01', 'Pembelian Laptop', 0, 'PEL-001'),
('2026-11-02', 'Aksesoris Komputer', 0, 'PEL-002'),
('2026-11-03', 'Perlengkapan Kantor', 0, 'PEL-003'),
('2026-11-04', 'Pembelian Flashdisk Banyak', 0, 'PEL-004'),
('2026-11-05', 'Upgrade Setup', 0, 'PEL-005'),
('2026-11-06', 'Pengadaan Kantor', 0, 'PEL-001'),
('2026-11-07', 'Mice and Keyboard', 0, 'PEL-002'),
('2026-11-08', 'Cadangan Penyimpanan', 0, 'PEL-003'),
('2026-11-09', 'Monitor Tambahan', 0, 'PEL-004'),
('2026-11-10', 'Set PC Lengkap', 0, 'PEL-005');

-- Insert Transaksi Detail (Trigger akan otomatis mengkalkulasi kolom total di tabel transaksi)
INSERT INTO transaksi_detail (transaksi_id, barang_id, harga, qty) VALUES
(1, 1, 8500000, 1),                 -- Transaksi 1
(2, 2, 150000, 1),                  -- Transaksi 2
(2, 3, 450000, 1),                  -- Transaksi 2
(3, 4, 2100000, 1),                 -- Transaksi 3
(4, 5, 120000, 10),                 -- Transaksi 4
(5, 1, 8500000, 1),                 -- Transaksi 5
(5, 4, 2100000, 1),                 -- Transaksi 5
(6, 1, 8500000, 2),                 -- Transaksi 6
(7, 2, 150000, 1),                  -- Transaksi 7
(7, 3, 450000, 1),                  -- Transaksi 7
(8, 5, 120000, 2),                  -- Transaksi 8
(9, 4, 2100000, 2),                 -- Transaksi 9
(10, 1, 8500000, 1),                -- Transaksi 10
(10, 2, 150000, 1),                 -- Transaksi 10
(10, 3, 450000, 1),                 -- Transaksi 10
(10, 4, 2100000, 1);                -- Transaksi 10