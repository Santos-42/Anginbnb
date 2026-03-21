<?php
$ca_path = __DIR__ . '/ca.pem';

if (!file_exists($ca_path)) {
    $cert_content = getenv('DB_SSL_CERT');
    if ($cert_content) {
        file_put_contents($ca_path, str_replace('\n', "\n", $cert_content));
    } else {
        die("KEGAGALAN INFRASTRUKTUR: Sertifikat SSL tidak ditemukan di lokal dan ENV gagal dimuat.");
    }
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

// SOLUSI 3: Persistent Connection
// Menambahkan 'p:' agar PHP menggunakan kembali koneksi yang sama, memangkas overhead SSL
$persistent_host = (strpos($host, 'p:') === 0) ? $host : 'p:' . $host;

$connect = mysqli_init();
mysqli_ssl_set($connect, NULL, NULL, $ca_path, NULL, NULL);

// SOLUSI 2: Retry Logic untuk mengatasi Cold Start Aiven
$max_retries = 3;
$retry_count = 0;
$connected = false;

while ($retry_count < $max_retries && !$connected) {
    // Kita suppress warning PHP dengan '@' agar user tidak melihat error saat retry
    if (@mysqli_real_connect($connect, $persistent_host, $user, $pass, $db, $port)) {
        $connected = true;
    } else {
        $retry_count++;
        if ($retry_count < $max_retries) {
            // Beri waktu 2 detik bagi database server untuk bangun dari tidur sebelum mencoba lagi
            sleep(2);
        }
    }
}

if (!$connected) {
    die("KEGAGALAN KONEKSI FATAL SETELAH {$max_retries} PERCOBAAN: " . mysqli_connect_error());
}
?>