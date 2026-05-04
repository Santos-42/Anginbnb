<?php
// config/database.php

$kredensial_path = __DIR__ . '/kredensial.php';

// Cek apakah file kredensial eksis untuk mencegah fatal error yang mengekspos path server
if (!file_exists($kredensial_path)) {
    die("Konfigurasi kredensial tidak ditemukan.");
}

require_once $kredensial_path;

// Eksekusi koneksi standar
$connect = mysqli_connect($host, $user, $pass, $db);

if (!$connect) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>