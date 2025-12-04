# Perpustakaan IDN 📚

Aplikasi Manajemen Perpustakaan Modern berbasis web yang dibangun menggunakan Laravel dan Livewire. Aplikasi ini memudahkan pengelolaan peminjaman buku, pengembalian, serta pembayaran denda secara online.

## 🌟 Fitur Utama

### 👥 Member Area
1.  **Dashboard Member**: Ringkasan aktivitas, buku dipinjam, dan status denda.
2.  **Katalog Buku**: Pencarian buku canggih dengan filter kategori dan status ketersediaan.
3.  **Detail Buku**: Informasi mendalam tentang buku termasuk stok dan lokasi rak.
4.  **Wishlist**: Simpan buku yang ingin dipinjam di masa depan.
5.  **Scan QR Peminjaman**: Fitur scan QR Code untuk meminjam buku secara mandiri di perpustakaan.
6.  **Pembayaran Denda (Midtrans)**: Integrasi pembayaran denda otomatis dengan QRIS, E-Wallet, dan Virtual Account.
7.  **Riwayat Peminjaman**: Log lengkap buku yang pernah dipinjam dan status pengembaliannya.
8.  **Profil Member**: Manajemen data diri dan pengaturan akun.

### 👮 Admin Area
9.  **Dashboard Admin**: Statistik real-time perpustakaan (Total Buku, Member, Peminjaman, Denda).
10. **Manajemen Buku**: CRUD (Create, Read, Update, Delete) data buku lengkap dengan upload cover.
11. **Manajemen Kategori**: Pengelompokan buku berdasarkan kategori/genre.
12. **Manajemen Member**: Kelola data anggota perpustakaan.
13. **Manajemen Peminjaman**: Pantau dan kelola status peminjaman aktif.
14. **Manajemen Denda**: Monitor denda yang belum dan sudah dibayar.
15. **Laporan & Log**: Riwayat aktivitas perpustakaan.

### 🔐 Keamanan & Sistem
16. **Otentikasi Multi-Role**: Sistem login aman memisahkan akses Member dan Admin.
17. **Sistem Denda Otomatis**: Kalkulasi denda harian otomatis saat buku terlambat dikembalikan.
18. **Validasi Stok**: Sistem otomatis mencegah peminjaman jika stok buku habis.

## 🛠️ Teknologi yang Digunakan

- **Backend**: [Laravel 12](https://laravel.com) (PHP Framework)
- **Frontend**: [Livewire 3](https://livewire.laravel.com) & [Blade](https://laravel.com/docs/blade)
- **Styling**: [TailwindCSS 4](https://tailwindcss.com)
- **Database**: MySQL
- **Payment Gateway**: [Midtrans](https://midtrans.com)
- **QR Code**: `simplesoftwareio/simple-qrcode` & `endroid/qr-code`

## ⚙️ Cara Instalasi

Ikuti langkah-langkah berikut untuk menjalankan project di komputer lokal Anda:

1.  **Clone Repository**
    ```bash
    git clone https://github.com/username/repo-name.git
    cd repo-name
    ```

2.  **Install Dependencies**
    ```bash
    composer install
    npm install
    ```

3.  **Konfigurasi Environment**
    Duplikasi file `.env.example` menjadi `.env`:
    ```bash
    cp .env.example .env
    ```
    Sesuaikan konfigurasi database dan Midtrans di file `.env`:
    ```env
    DB_DATABASE=nama_database
    
    MIDTRANS_SERVER_KEY=your-server-key
    MIDTRANS_CLIENT_KEY=your-client-key
    MIDTRANS_IS_PRODUCTION=false
    ```

4.  **Generate App Key**
    ```bash
    php artisan key:generate
    ```

5.  **Migrasi Database**
    ```bash
    php artisan migrate --seed
    ```

6.  **Build Assets**
    ```bash
    npm run build
    ```

## 🚀 Cara Menjalankan Project

Untuk menjalankan aplikasi dalam mode development:

1.  Jalankan server Laravel:
    ```bash
    php artisan serve
    ```

2.  Jalankan Vite (untuk hot-reload frontend):
    ```bash
    npm run dev
    ```

3.  Akses aplikasi di browser: `http://127.0.0.1:8000`

## 📝 Catatan Tambahan

- Pastikan koneksi internet aktif saat menjalankan `composer install` dan `npm install`.
- Untuk fitur pembayaran, gunakan kredensial **Sandbox Midtrans** saat testing.

---
Dibuat dengan ❤️ oleh Muhammad Daffa Najib Fikri
