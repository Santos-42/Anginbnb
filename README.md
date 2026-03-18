# Anginbnb 🌬️🏨

Anginbnb adalah platform persewaan properti sederhana yang didesain untuk memudahkan pengguna mencari dan memesan akomodasi (Hotel, Apartemen, Villa, Resort). Proyek ini sekarang berjalan menggunakan infrastruktur berbasis kontainer dan database cloud.

## 🚀 Fitur Utama

- **Pencarian Properti**: Cari properti berdasarkan nama atau lokasi.
- **Kategori**: Filter properti berdasarkan kategori (Hotel, Apartment, Villa, Resort).
- **Booking**: Sistem pemesanan properti untuk pengguna terdaftar.
- **Manajemen Admin**: Panel khusus untuk mengelola user, properti, kategori, dan jenis pembayaran.

## 🛠️ Tech Stack

- **Backend**: PHP 8.2 (Apache base)
- **Database**: MySQL (Aiven Cloud) dengan koneksi SSL Mandatory.
- **Containerization**: Docker & Docker Compose.
- **Frontend**: Vanilla CSS & Semantic HTML.

## ⚙️ Konfigurasi & Setup

### 1. Prasyarat

- Docker & Docker Desktop terinstal.
- Koneksi internet (untuk akses database cloud).

### 2. Konfigurasi Database (Kredensial)

Proyek ini menggunakan dua metode pemuatan kredensial database:

- **Lokal (Development)**: Buat file `config/kredensial.php` (sudah diabaikan oleh `.gitignore`).
- **Production/Docker**: Gunakan Environment Variables.

**Struktur `config/kredensial.php`:**

```php
<?php
$env_host = 'host';
$env_port = port;
$env_db   = 'anginbnb';
$env_user = 'user';
$env_pass = 'YOUR_PASSWORD';
?>
```

**Environment Variables Required:**

- `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER`, `DB_PASS`
- `DB_SSL_CERT`: Konten sertifikat `ca.pem` (dalam format string dengan newline `\n`).

### 3. Docker Setup

Bangun dan jalankan aplikasi menggunakan Docker:

```bash
docker build -t anginbnb .
docker run -p 8000:80 -e DB_HOST=... -e DB_USER=... [dst] anginbnb
```

## 🔐 Login Admin

Untuk mengakses panel manajemen, silakan login melalui halaman `login.php` menggunakan akun default berikut (setelah import `Anginbnb.sql` jika diperlukan):

| Role       | Email                | Password     |
| :--------- | :------------------- | :----------- |
| **Admin**  | `admin@anginbnb.com` | `Admin123!`  |
| **Member** | `rio@gmail.com`      | `Member123!` |

**Dashboard Admin**: Terletak di direktori `/admin/`. Pastikan Anda memiliki role `Admin` untuk mengakses fitur manajemen properti dan user.

---

© 2026 Anginbnb - Advanced Agentic Coding Project.
