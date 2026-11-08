<?php
// Konfigurasi Database
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_tp6";

// Membuat koneksi menggunakan MySQLi (Object-Oriented)
$conn = new mysqli($host, $user, $pass, $db);

// Mengecek koneksi
if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}

?>