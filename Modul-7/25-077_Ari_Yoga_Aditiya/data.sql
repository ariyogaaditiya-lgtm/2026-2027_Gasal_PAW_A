-- 1. Data Supplier
INSERT INTO `supplier` (`id`, `nama`, `telp`, `alamat`) VALUES
(1, 'PT Sumber Elektronik Jaya', '081234567890', 'Jl. Raya Darmo No. 45, Surabaya'),
(2, 'CV Maju Bersama Komputer', '085678901234', 'Jl. Tunjungan No. 12, Surabaya'),
(3, 'UD Berkah Aksesoris', '087890123456', 'Jl. Trunojoyo No. 88, Bangkalan');

-- 2. Data Barang
INSERT INTO `barang` (`id`, `kode_barang`, `nama_barang`, `harga`, `stok`, `supplier_id`) VALUES
(1, 'BRG001', 'Keyboard Mechanical RGB', 350000, 25, 1),
(2, 'BRG002', 'Mouse Gaming Wireless', 175000, 40, 1),
(3, 'BRG003', 'Monitor LED 24 Inch', 1850000, 10, 2),
(4, 'BRG004', 'Headset Gaming Surround', 275000, 30, 2),
(5, 'BRG005', 'Flashdisk 64GB USB 3.0', 95000, 60, 3);

-- 3. Data Pelanggan
INSERT INTO `pelanggan` (`id`, `nama`, `jenis_kelamin`, `telp`, `alamat`) VALUES
('PLG001', 'Ahmad Fauzi', 'L', '081112223344', 'Jl. Telang Indah, Bangkalan'),
('PLG002', 'Siti Aminah', 'P', '082233445566', 'Perumahan Griya Abadi, Madura'),
('PLG003', 'Budi Santoso', 'L', '083344556677', 'Jl. Raya Kamal, Bangkalan'),
('PLG004', 'Dewi Lestari', 'P', '084455667788', 'Jl. Panglima Sudirman, Surabaya');

-- 4. Data Transaksi (Rentang Tanggal November 2026)
INSERT INTO `transaksi` (`id`, `waktu_transaksi`, `keterangan`, `total`, `pelanggan_id`) VALUES
(1, '2026-11-02', 'Penjualan aksesoris komputer', 795000, 'PLG001'),
(2, '2026-11-05', 'Pembelian monitor dan mouse', 2025000, 'PLG002'),
(3, '2026-11-10', 'Paket gaming lengkap', 2475000, 'PLG003'),
(4, '2026-11-12', 'Grosir flashdisk', 570000, 'PLG004'),
(5, '2026-11-15', 'Pembelian satuan', 350000, 'PLG001');

-- 5. Data Transaksi Detail
INSERT INTO `transaksi_detail` (`transaksi_id`, `barang_id`, `harga`, `qty`) VALUES
(1, 1, 350000, 1), -- Keyboard
(1, 2, 175000, 1), -- Mouse
(1, 5, 95000, 3),  -- Flashdisk (3 pcs)
(2, 3, 1850000, 1),-- Monitor
(2, 2, 175000, 1), -- Mouse
(3, 1, 350000, 1), -- Keyboard
(3, 3, 1850000, 1),-- Monitor
(3, 4, 275000, 1), -- Headset
(4, 5, 95000, 6),  -- Flashdisk (6 pcs)
(5, 1, 350000, 1); -- Keyboard

-- 6. Data Pembayaran
INSERT INTO `pembayaran` (`id`, `waktu_bayar`, `total`, `metode`, `transaksi_id`) VALUES
(1, '2026-11-02 10:30:00', 795000, 'TUNAI', 1),
(2, '2026-11-05 14:15:00', 2025000, 'TRANSFER', 2),
(3, '2026-11-10 09:45:00', 2475000, 'EDC', 3),
(4, '2026-11-12 16:20:00', 570000, 'TUNAI', 4),
(5, '2026-11-15 11:00:00', 350000, 'TRANSFER', 5);

-- 7. Data User / Administrator
INSERT INTO `user` (`id_user`, `username`, `password`, `nama`, `alamat`, `hp`, `level`) VALUES
(1, 'admin', MD5('admin123'), 'Administrator', 'Bangkalan', '08123456789', 1),
(2, 'kasir', MD5('kasir123'), 'Kasir Toko', 'Surabaya', '08987654321', 2);