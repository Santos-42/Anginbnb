<?php
// ping.php - Warm-up script

error_reporting(E_ALL);
ini_set('display_errors', 0); // Pastikan diset 0 saat di production

// Memuat koneksi database yang sudah menggunakan SSL
require_once 'config/database.php';

header('Content-Type: application/json');

$response = [
    'status' => 'error',
    'message' => 'Gagal melakukan ping.',
    'timestamp' => date('Y-m-d H:i:s')
];

try {
    // Mengecek koneksi yang diinisialisasi di database.php
    if (isset($connect) && $connect) {
        // Menjalankan query sangat ringan untuk membangunkan Aiven MySQL
        $ping_query = mysqli_query($connect, "SELECT 1");
        
        if ($ping_query) {
            $response['status'] = 'success';
            $response['message'] = 'Render web service dan Aiven database berstatus aktif (Awake).';
        } else {
            $response['message'] = 'Koneksi database berhasil, tetapi ping query gagal.';
        }
    } else {
        $response['message'] = 'Koneksi ke database Aiven gagal.';
    }
} catch (Exception $e) {
    $response['message'] = 'Terjadi kesalahan: ' . $e->getMessage();
}

if (isset($connect) && $connect) {
    mysqli_close($connect);
}

echo json_encode($response);
?>
