<?php
/**
 * File: koneksi.php
 * Deskripsi: Menghubungkan aplikasi web PHP ke database MySQL (db_praktikum_modul5)
 * Dilengkapi fallback otomatis untuk berbagai konfigurasi password MySQL (Laragon / MySQL Server)
 */

$host     = "localhost";
$username = "root";
$database = "db_praktikum_modul5";

// Daftar password yang umum digunakan (kosong, root, Ariyoga1234, admin, dll.)
$candidate_passwords = ['', 'root', 'Ariyoga1234', 'admin', '12345678', '12345', '123456'];

$conn = null;
$connected_password = null;

// Matikan pelemparan exception bawaan PHP 8.1 agar kita bisa mencoba beberapa kemungkinan
mysqli_report(MYSQLI_REPORT_OFF);

foreach ($candidate_passwords as $pwd) {
    // Coba koneksi ke server MySQL
    $temp_conn = @mysqli_connect($host, $username, $pwd);
    if ($temp_conn) {
        $conn = $temp_conn;
        $connected_password = $pwd;
        break;
    }
}

// Jika semua password di atas gagal
if (!$conn) {
    die("<div style='font-family: sans-serif; padding: 20px; background: #ffebee; border: 1px solid #ef9a9a; border-radius: 8px; margin: 20px auto; max-width: 650px; color: #c62828;'>" .
        "<h3 style='margin-top:0;'>❌ Gagal Terhubung ke MySQL!</h3>" .
        "<p>Penyebab: User <strong>'root'</strong> pada MySQL Anda menggunakan password yang belum cocok.</p>" .
        "<p><strong>Solusi:</strong> Buka file <code>koneksi.php</code> lalu sesuaikan baris password dengan password MySQL yang pernah Anda buat saat instalasi MySQL:</p>" .
        "<pre style='background: #fff; padding: 10px; border: 1px solid #ddd;'>\$password = \"masukkan_password_mysql_anda_disini\";</pre>" .
        "</div>");
}

// Cek apakah database db_praktikum_modul5 sudah ada atau belum
$db_selected = @mysqli_select_db($conn, $database);
if (!$db_selected) {
    // Otomatis buat database jika belum ada
    @mysqli_query($conn, "CREATE DATABASE IF NOT EXISTS `$database`");
    @mysqli_select_db($conn, $database);

    // Cek apakah tabel supplier sudah ada
    $check_table = @mysqli_query($conn, "SHOW TABLES LIKE 'supplier'");
    if (@mysqli_num_rows($check_table) == 0) {
        // Jika belum ada tabel, baca dan jalankan isi database.sql
        $sql_file = __DIR__ . '/database.sql';
        if (file_exists($sql_file)) {
            $sql_content = file_get_contents($sql_file);
            @mysqli_multi_query($conn, $sql_content);
            // Bersihkan hasil multi query
            while (@mysqli_next_result($conn)) {
                if (!@mysqli_more_results($conn)) break;
            }
        }
    }
}

// Pastikan koneksi menggunakan charset utf8mb4
@mysqli_set_charset($conn, "utf8mb4");
?>
