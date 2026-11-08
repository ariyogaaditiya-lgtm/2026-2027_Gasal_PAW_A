<?php
include 'koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Transaksi Master-Detail</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 20px; 
            background-color: #f4f7f6; 
        }
        .container { 
            max-width: 800px; 
            margin: auto; 
            background: #fff; 
            padding: 20px; 
            border-radius: 8px; 
            box-shadow: 0 2px 10px rgba(0,0,0,0.1); 
        }
        h2 { 
            text-align: center; 
            color: #333; 
        }
        fieldset { 
            border: 1px solid #ddd; 
            padding: 15px; 
            border-radius: 5px; 
            margin-bottom: 20px; 
        }
        legend { 
            font-weight: bold; 
            padding: 0 10px; 
            color: #555; 
        }
        .form-group { 
            margin-bottom: 15px; 
        }
        label { 
            display: block; 
            margin-bottom: 5px; 
            font-weight: bold; 
            font-size: 14px; 
            color: #333; 
        }
        input, select { 
            padding: 10px; 
            width: 100%; 
            box-sizing: border-box; 
            border: 1px solid #ccc; 
            border-radius: 4px; 
        }
        button { 
            padding: 10px 15px; 
            cursor: pointer; 
            background: #007BFF; 
            color: white; 
            border: none; 
            border-radius: 4px; 
        }
        button:hover { 
            background: #0056b3; 
        }
        .btn-danger { 
            background: #dc3545; 
        }
        .btn-danger:hover { 
            background: #c82333; 
        }
        .btn-success { 
            background: #28a745; 
            width: 100%; 
            font-size: 16px; 
            padding: 15px; 
        }
        .btn-success:hover { 
            background: #218838; 
        }
        .row { 
            display: flex; 
            gap: 15px; 
        }
        .col { 
            flex: 1; 
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 15px; 
        }
        table, th, td { 
            border: 1px solid #ddd; 
        }
        th, td { 
            padding: 12px; 
            text-align: left; 
        }
        th { 
            background-color: #f8f9fa; 
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Form Input Transaksi (Master-Detail)</h2>
        
        <!-- Karena ini hanya UI HTML di dalam PHP, action form dikosongkan/diarahkan ke file handler nantinya -->
        <form action="" method="POST" id="formTransaksi">
            
            <!-- MASTER: Data Transaksi -->
            <fieldset>
                <legend>Data Master Transaksi</legend>
                <div class="row">
                    <div class="form-group col">
                        <label for="waktu_transaksi">Waktu Transaksi:</label>
                        <input type="date" id="waktu_transaksi" name="waktu_transaksi" required>
                    </div>
                    <div class="form-group col">
                        <label for="pelanggan_id">Pelanggan:</label>
                        <select name="pelanggan_id" id="pelanggan_id" required>
                            <option value="">-- Pilih Pelanggan --</option>
                            <option value="PEL-001">Budi Santoso</option>
                            <option value="PEL-002">Siti Aminah</option>
                            <option value="PEL-003">Andi Wijaya</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="keterangan">Keterangan:</label>
                    <input type="text" id="keterangan" name="keterangan" placeholder="Masukkan keterangan (opsional)">
                </div>
            </fieldset>

            <!-- DETAIL: Data Transaksi Detail -->
            <fieldset>
                <legend>Data Detail Transaksi (Barang)</legend>
                <div class="row align-items-end">
                    <div class="form-group col">
                        <label for="pilih_barang">Pilih Barang:</label>
                        <select id="pilih_barang">
                            <option value="">-- Pilih Barang --</option>
                            <!-- Data barang ini disimulasikan sebagai hasil query select dari tabel barang -->
                            <option value="1" data-nama="Laptop Asus VivoBook" data-harga="8500000">BRG-001 - Laptop Asus VivoBook</option>
                            <option value="2" data-nama="Mouse Wireless Logitech" data-harga="150000">BRG-002 - Mouse Wireless Logitech</option>
                            <option value="3" data-nama="Keyboard Mechanical" data-harga="450000">BRG-003 - Keyboard Mechanical</option>
                            <option value="4" data-nama="Monitor Samsung 24 Inch" data-harga="2100000">BRG-004 - Monitor Samsung 24 Inch</option>
                            <option value="5" data-nama="Flashdisk SanDisk 64GB" data-harga="120000">BRG-005 - Flashdisk SanDisk 64GB</option>
                        </select>
                    </div>
                    <div class="form-group col" style="max-width: 120px;">
                        <label for="qty_barang">Qty:</label>
                        <input type="number" id="qty_barang" min="1" value="1">
                    </div>
                    <div class="form-group col" style="max-width: 150px; padding-bottom: 5px;">
                        <button type="button" onclick="tambahKeKeranjang()" style="width: 100%;">Tambah Item</button>
                    </div>
                </div>
                
                <!-- Tabel untuk menampilkan keranjang belanja sementara sebelum di-submit -->
                <table id="tabel_detail">
                    <thead>
                        <tr>
                            <th>Nama Barang</th>
                            <th>Harga</th>
                            <th>Qty</th>
                            <th>Subtotal</th>
                            <th style="text-align:center; width: 80px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Baris detail barang akan ditambahkan di sini via JavaScript -->
                    </tbody>
                </table>
                
                <!-- Div tersembunyi ini akan menampung input array untuk diproses PHP di backend -->
                <div id="hidden_inputs_area"></div>
            </fieldset>

            <button type="submit" class="btn-success">Simpan Semua Transaksi</button>
        </form>
    </div>

    <script>
        // Array untuk menyimpan ID barang yang sudah dipilih agar tidak bisa dipilih dua kali
        let barangTerpilih = [];

        function tambahKeKeranjang() {
            const selectBarang = document.getElementById('pilih_barang');
            const qtyInput = document.getElementById('qty_barang');
            
            const barangId = selectBarang.value;
            const qty = parseInt(qtyInput.value);

            // Validasi input
            if (!barangId) {
                alert('Silakan pilih barang terlebih dahulu!');
                return;
            }
            if (qty < 1 || isNaN(qty)) {
                alert('Quantity minimal 1!');
                return;
            }

            // Ambil data atribut dari option yang dipilih
            const option = selectBarang.options[selectBarang.selectedIndex];
            const namaBarang = option.getAttribute('data-nama');
            const harga = parseInt(option.getAttribute('data-harga'));
            const subtotal = harga * qty;

            // 1. Tampilkan baris baru di tabel visual
            const tbody = document.querySelector('#tabel_detail tbody');
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${namaBarang}</td>
                <td>Rp ${harga.toLocaleString('id-ID')}</td>
                <td>${qty}</td>
                <td>Rp ${subtotal.toLocaleString('id-ID')}</td>
                <td style="text-align:center;">
                    <button type="button" class="btn-danger" onclick="hapusDariKeranjang('${barangId}', this)">Hapus</button>
                </td>
            `;
            tbody.appendChild(tr);

            // 2. Buat input hidden berupa array (name="barang_id[]" dll) untuk disubmit ke PHP
            const hiddenArea = document.getElementById('hidden_inputs_area');
            const hiddenDiv = document.createElement('div');
            hiddenDiv.id = `hidden_data_${barangId}`;
            hiddenDiv.innerHTML = `
                <input type="hidden" name="barang_id[]" value="${barangId}">
                <input type="hidden" name="harga[]" value="${harga}">
                <input type="hidden" name="qty[]" value="${qty}">
            `;
            hiddenArea.appendChild(hiddenDiv);

            // 3. Masukkan ID barang ke array state dan perbarui dropdown
            barangTerpilih.push(barangId);
            updateDropdownBarang();
            
            // Reset form input detail
            selectBarang.value = '';
            qtyInput.value = '1';
        }

        function hapusDariKeranjang(barangId, buttonElement) {
            // Hapus baris dari tabel UI
            const tr = buttonElement.closest('tr');
            tr.remove();

            // Hapus data hidden inputs dari form
            const hiddenDiv = document.getElementById(`hidden_data_${barangId}`);
            if (hiddenDiv) hiddenDiv.remove();

            // Hapus dari array state barangTerpilih
            barangTerpilih = barangTerpilih.filter(id => id !== barangId);
            
            // Perbarui dropdown agar barang yang dihapus bisa dipilih kembali
            updateDropdownBarang();
        }

        function updateDropdownBarang() {
            // Ini menjawab Instruksi No 2: 
            // Menonaktifkan (disabled) opsi barang yang sudah ada di keranjang/transaksi_detail.
            const selectBarang = document.getElementById('pilih_barang');
            const options = selectBarang.options;

            for (let i = 0; i < options.length; i++) {
                const opt = options[i];
                if (opt.value !== "") {
                    if (barangTerpilih.includes(opt.value)) {
                        opt.disabled = true;
                        opt.style.backgroundColor = '#e9ecef'; // Opsional: Beri warna abu-abu
                        opt.text = opt.text.replace(' (Sudah dipilih)', '') + ' (Sudah dipilih)';
                    } else {
                        opt.disabled = false;
                        opt.style.backgroundColor = '#fff';
                        opt.text = opt.text.replace(' (Sudah dipilih)', '');
                    }
                }
            }
        }
    </script>
</body>
</html>