CREATE DATABASE IF NOT EXISTS penjualan CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE penjualan;

CREATE TABLE IF NOT EXISTS user (
  id_user INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  nama VARCHAR(100) NOT NULL,
  alamat TEXT NULL,
  hp VARCHAR(20) NULL,
  level TINYINT NOT NULL DEFAULT 2 COMMENT '1=Owner, 2=Kasir'
);

CREATE TABLE IF NOT EXISTS supplier (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100) NOT NULL,
  telp VARCHAR(20),
  alamat TEXT
);

CREATE TABLE IF NOT EXISTS pelanggan (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100) NOT NULL,
  jenis_kelamin ENUM('L','P') NULL,
  telp VARCHAR(20),
  alamat TEXT
);

CREATE TABLE IF NOT EXISTS barang (
  id INT AUTO_INCREMENT PRIMARY KEY,
  kode_barang VARCHAR(30) NOT NULL UNIQUE,
  nama_barang VARCHAR(100) NOT NULL,
  harga DECIMAL(12,2) NOT NULL DEFAULT 0,
  stok INT NOT NULL DEFAULT 0,
  supplier_id INT NULL,
  CONSTRAINT fk_barang_supplier FOREIGN KEY (supplier_id) REFERENCES supplier(id)
    ON UPDATE CASCADE ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS transaksi (
  id INT AUTO_INCREMENT PRIMARY KEY,
  waktu_transaksi DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  keterangan TEXT,
  total DECIMAL(12,2) NOT NULL DEFAULT 0,
  pelanggan_id INT NULL,
  CONSTRAINT fk_transaksi_pelanggan FOREIGN KEY (pelanggan_id) REFERENCES pelanggan(id)
    ON UPDATE CASCADE ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS transaksi_detail (
  transaksi_id INT NOT NULL,
  barang_id INT NOT NULL,
  harga DECIMAL(12,2) NOT NULL,
  qty INT NOT NULL,
  PRIMARY KEY (transaksi_id, barang_id),
  CONSTRAINT fk_detail_transaksi FOREIGN KEY (transaksi_id) REFERENCES transaksi(id)
    ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT fk_detail_barang FOREIGN KEY (barang_id) REFERENCES barang(id)
    ON UPDATE CASCADE ON DELETE RESTRICT
);

CREATE TABLE IF NOT EXISTS pembayaran (
  id INT AUTO_INCREMENT PRIMARY KEY,
  waktu_bayar DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  total DECIMAL(12,2) NOT NULL,
  metode VARCHAR(30) NOT NULL DEFAULT 'Tunai',
  transaksi_id INT NOT NULL,
  CONSTRAINT fk_pembayaran_transaksi FOREIGN KEY (transaksi_id) REFERENCES transaksi(id)
    ON UPDATE CASCADE ON DELETE CASCADE
);

INSERT IGNORE INTO user (username, password, nama, alamat, hp, level)
VALUES
('owner', MD5('123'), 'Owner', '-', '-', 1),
('kasir', MD5('123'), 'Kasir', '-', '-', 2);
