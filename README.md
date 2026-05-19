# SIMBEKA - Sistem Informasi Bimbingan Konseling
### 🏫 Khusus SMP Negeri 6 Palu

SIMBEKA adalah platform manajemen bimbingan konseling modern yang dirancang untuk memudahkan interaksi antara siswa dan Guru BK (Bimbingan Konseling) secara aman, transparan, dan efisien.

![Laravel](https://img.shields.io/badge/laravel-%23FF2D20.svg?style=for-the-badge&logo=laravel&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/tailwindcss-%2338B2AC.svg?style=for-the-badge&logo=tailwind-css&logoColor=white)
![Alpine.js](https://img.shields.io/badge/alpinejs-%238BC0D0.svg?style=for-the-badge&logo=alpine.js&logoColor=black)

---

## ✨ Fitur Utama & Aturan Bisnis

### 👮 Portal Guru BK
- **Dashboard Holistik**: Pantau antrean kasus masuk, status pelaporan aktif, sesi konseling, dan statistik kelas.
- **Batasan Beban Kerja (Batas Kasus Aktif)**: Guru BK dibatasi maksimal menangani **5 kasus aktif** (gabungan laporan & konsultasi) sekaligus. Jika kuota penuh, tombol ambil kasus akan dinonaktifkan dengan peringatan visual demi menjaga kualitas layanan dan kesehatan mental Guru BK.
- **Manajemen Siswa**: CRUD data siswa lengkap (nama, username, kelas, wali, nomor telepon, dll).
- **Arsip & Dokumen**: Akses riwayat kasus siswa yang terselesaikan, cetak dokumen SP1/SP2/Skorsing secara instan dalam format PDF.

### 🎓 Portal Siswa & Publik
- **Live Chat Konsultasi**: Fitur chat real-time premium (mirip Messenger/WhatsApp) antara siswa dengan Guru BK pendamping.
- **Sistem Pelaporan Mandiri (Guest/Siswa)**: Siswa atau publik dapat melaporkan kejadian (seperti bullying, keluhan, dsb.) secara tertutup (anonim) atau menggunakan akun terdaftar.
- **Lupa Password**: Alur pemulihan akun yang aman menggunakan pertanyaan keamanan.

### 🔒 Keamanan & Privasi
- **Mode Self-Destruct**: Ketika kasus dinyatakan **Selesai (Resolved)** oleh Guru BK, seluruh riwayat chat konsultasi akan dihapus secara otomatis dan permanen dari database untuk menjamin kerahasiaan siswa.

---

## 🛠️ Spesifikasi Teknologi
- **Backend**: Laravel 11.x (PHP 8.2 / 8.3 / 8.4)
- **Database**: MySQL / MariaDB (Direkomendasikan via Laragon)
- **Frontend**: Tailwind CSS v4 & Alpine.js (via Vite)
- **Pustaka Tambahan**: Barryvdh DomPDF (Cetak Surat Keputusan)

---

## 🚀 Panduan Instalasi di Laptop Lain (Localhost)

Ikuti langkah-langkah di bawah ini untuk menjalankan aplikasi SIMBEKA dari awal pada laptop Windows (menggunakan **Laragon**):

### 1. Persiapan Software Pendukung
Pastikan laptop tujuan sudah memiliki:
- **Laragon Full** (berisi Apache, MySQL, PHP 8.2/8.3, dan Git)
- **Composer** (biasanya sudah include di Laragon)
- **Node.js & NPM** (untuk compile aset Tailwind)

### 2. Langkah-Langkah Clone dan Setup
1. **Buka Terminal/Command Prompt** di folder root server lokal Laragon Anda (biasanya di `C:\laragon\www\`).
2. **Clone Repository** SIMBEKA:
   ```bash
   git clone https://github.com/ForLimm/SIMBEKA.git
   cd SIMBEKA
   ```
3. **Instal Package PHP (Composer)**:
   ```bash
   composer install
   ```
4. **Instal Package Frontend (Node.js)**:
   ```bash
   npm install
   ```
5. **Salin Konfigurasi Environment**:
   ```bash
   cp .env.example .env
   ```
6. **Generate Application Key**:
   ```bash
   php artisan key:generate
   ```

### 3. Konfigurasi Database (MySQL)
1. Jalankan aplikasi **Laragon**, lalu klik tombol **Start All**.
2. Klik tombol **Database** (atau gunakan HeidiSQL/phpMyAdmin) dan buat database baru bernama:
   ```sql
   simbeka_db
   ```
3. Buka file `.env` di text editor Anda, lalu sesuaikan bagian koneksi database:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=simbeka_db
   DB_USERNAME=root
   DB_PASSWORD=
   ```
   *(Kosongkan password jika Anda menggunakan pengaturan standar Laragon)*.

### 4. Migrasi Database dan Seed
Jalankan perintah ini di terminal proyek untuk membuat tabel dan akun admin default:
```bash
php artisan migrate --seed
```

### 5. Kompilasi Aset Frontend (Vite)
Jalankan perintah ini untuk membangun aset tampilan CSS dan JS:
```bash
npm run build
```
*(Catatan: Gunakan `npm run dev` jika ingin melakukan modifikasi visual secara langsung).*

### 6. Menjalankan Aplikasi
Aplikasi dapat diakses dengan 2 cara:
- **Opsi A (Rekomendasi Laragon)**: Cukup restart Laragon. Aplikasi otomatis dapat diakses melalui browser pada alamat `http://simbeka.test/`.
- **Opsi B (Laravel Serve)**: Jalankan `php artisan serve` di terminal, lalu buka browser pada alamat `http://127.0.0.1:8000/`.

---

## 🔑 Kredensial Akun Default
Setelah database berhasil di-seed, Anda dapat login menggunakan akun administrator utama berikut:

| Role | Username | Password | Deskripsi |
| :--- | :--- | :--- | :--- |
| **Super Admin** | `admin` | `password` | Digunakan untuk mengelola data Guru BK dan memantau sistem. |

### 💡 Cara Menambah Akun Guru BK & Siswa:
1. Masuk ke panel **Super Admin** menggunakan kredensial di atas.
2. Pilih menu **Guru BK**, lalu tambahkan Guru BK baru. Akun Guru BK tersebut otomatis dibuat oleh sistem.
3. Logout, lalu Login sebagai **Guru BK** yang baru saja didaftarkan.
4. Dari dashboard Guru BK, Anda dapat mendaftarkan/mengelola data **Siswa** yang memiliki hak akses untuk melakukan konsultasi.

---

**© 2026 SIMBEKA Team - Dedicated to SMP Negeri 6 Palu**
