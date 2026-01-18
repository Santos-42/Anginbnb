<?php
$server = "localhost";
$username = "root";
$password = "";       
$db_name = "anginbnb";

// Koneksi dengan database
$connect = mysqli_connect($server, $username, $password, $db_name);

// Kalau error
if (!$connect) {
    die("KONEKSI GAGAL");
}

?>