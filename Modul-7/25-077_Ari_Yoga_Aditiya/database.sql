CREATE DATABASE IF NOT EXISTS `databasetp7`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_general_ci;

USE `databasetp7`;

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS `pembayaran`;
DROP TABLE IF EXISTS `transaksi_detail`;
DROP TABLE IF EXISTS `transaksi`;
DROP TABLE IF EXISTS `barang`;
DROP TABLE IF EXISTS `pelanggan`;
DROP TABLE IF EXISTS `supplier`;
DROP TABLE IF EXISTS `user`;
SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE `supplier` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `nama` VARCHAR(100),
    `telp` VARCHAR(12),
    `alamat` TEXT,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

CREATE TABLE `barang` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `kode_barang` VARCHAR(10) NOT NULL,    

    `nama_barang` VARCHAR(100),
    `harga` INT,
    `stok` INT,
    `supplier_id` INT,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uq_barang_kode` (`kode_barang`),
    KEY `idx_barang_supplier` (`supplier_id`),
    CONSTRAINT `fk_barang_supplier`
        FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`id`)
        ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE `pelanggan` (
    `id` VARCHAR(20) NOT NULL,
    `nama` VARCHAR(100),
    `jenis_kelamin` ENUM('L','P'),
    `telp` VARCHAR(12),
    `alamat` TEXT,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

CREATE TABLE `transaksi` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `waktu_transaksi` DATE,
    `keterangan` TEXT,
    `total` INT,
    `pelanggan_id` VARCHAR(20),
    PRIMARY KEY (`id`),
    KEY `idx_transaksi_pelanggan` (`pelanggan_id`),
    CONSTRAINT `fk_transaksi_pelanggan`
        FOREIGN KEY (`pelanggan_id`) REFERENCES `pelanggan` (`id`)
        ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE `transaksi_detail` (
    `transaksi_id` INT NOT NULL,
    `barang_id` INT NOT NULL,
    `harga` INT,
    `qty` INT,
    PRIMARY KEY (`transaksi_id`, `barang_id`),
    KEY `idx_detail_barang` (`barang_id`),
    CONSTRAINT `fk_detail_transaksi`
        FOREIGN KEY (`transaksi_id`) REFERENCES `transaksi` (`id`)
        ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT `fk_detail_barang`
        FOREIGN KEY (`barang_id`) REFERENCES `barang` (`id`)
        ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE `pembayaran` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `waktu_bayar` DATETIME,
    `total` INT,
    `metode` ENUM('TUNAI','TRANSFER','EDC'),
    `transaksi_id` INT,
    PRIMARY KEY (`id`),
    KEY `idx_pembayaran_transaksi` (`transaksi_id`),
    CONSTRAINT `fk_pembayaran_transaksi`
        FOREIGN KEY (`transaksi_id`) REFERENCES `transaksi` (`id`)
        ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE `user` (
    `id_user` TINYINT NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(30) NOT NULL,
    `password` VARCHAR(35),
    `nama` VARCHAR(50),
    `alamat` VARCHAR(150),
    `hp` VARCHAR(20),
    `level` TINYINT(1),
    PRIMARY KEY (`id_user`),
    UNIQUE KEY `uq_user_username` (`username`)
) ENGINE=InnoDB;
