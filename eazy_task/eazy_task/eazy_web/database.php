<?php
$host = 'localhost'; // Nama host
$db_user = 'root'; // Username database
$db_pass = ''; // Password database (kosong jika tidak ada password)
$db_name = 'eazyweb'; // Nama database Anda

// Membuat koneksi ke database
$conn = new mysqli($host, $db_user, $db_pass, $db_name);

// Cek koneksi
if ($conn->connect_error) {
    die('Koneksi gagal: ' . $conn->connect_error);
}

// Menyiapkan karakter set agar mendukung UTF-8
$conn->set_charset("utf8");
?>
