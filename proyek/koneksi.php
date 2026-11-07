<?php
// =====================================================
//  koneksi.php — Jembatan antara PHP dan database MySQL
//  File ini di-include di semua halaman yang butuh
//  akses ke database.
// =====================================================

$host = 'localhost';   // server database (XAMPP / Laragon)
$user = 'root';        // user default XAMPP / Laragon
$pass = '';            // password default XAMPP / Laragon (kosong)
$db   = 'db_login';    // nama database dari db.sql

// Buat koneksi
$koneksi = new mysqli($host, $user, $pass, $db);

// Kalau koneksi gagal, hentikan program dan kasih pesan jelas
if ($koneksi->connect_error) {
    die('Koneksi ke database gagal: ' . $koneksi->connect_error);
}

// Pakai UTF-8 supaya karakter Indonesia (é, dll) nggak aneh
$koneksi->set_charset('utf8mb4');
