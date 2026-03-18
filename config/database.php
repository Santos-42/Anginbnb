<?php
$ca_path = __DIR__ . '/ca.pem';
if (!file_exists($ca_path)) {
    die("KEGAGALAN KEAMANAN: Sertifikat SSL (ca.pem) tidak ditemukan di server.");
}

$kredensial_path = __DIR__ . '/kredensial.php';
if (file_exists($kredensial_path)) {
    require_once $kredensial_path;
    $host = $env_host;
    $port = $env_port;
    $db   = $env_db;
    $user = $env_user;
    $pass = $env_pass;
} else {
    $host = getenv('DB_HOST');
    $port = getenv('DB_PORT');
    $db   = getenv('DB_NAME');
    $user = getenv('DB_USER');
    $pass = getenv('DB_PASS');
}

$connect = mysqli_init();
mysqli_ssl_set($connect, NULL, NULL, $ca_path, NULL, NULL); 

if (!mysqli_real_connect($connect, $host, $user, $pass, $db, $port)) {
    die("KEGAGALAN INFRASTRUKTUR KONEKSI: " . mysqli_connect_error());
}
?>