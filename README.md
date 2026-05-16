# SIMBEKA - Sistem Informasi Bimbingan Konseling
### 🏫 Khusus SMP Negeri 6 Palu

SIMBEKA adalah platform manajemen bimbingan konseling modern yang dirancang untuk memudahkan interaksi antara siswa dan Guru BK (Bimbingan Konseling) secara aman, transparan, dan efisien.

![Laravel](https://img.shields.io/badge/laravel-%23FF2D20.svg?style=for-the-badge&logo=laravel&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/tailwindcss-%2338B2AC.svg?style=for-the-badge&logo=tailwind-css&logoColor=white)
![Alpine.js](https://img.shields.io/badge/alpinejs-%238BC0D0.svg?style=for-the-badge&logo=alpine.js&logoColor=black)

---

## ✨ Fitur Utama

### 👮 Portal Guru BK
- **Dashboard Holistik**: Pantau jumlah pelaporan aktif, konsultasi yang sedang berjalan, dan statistik kasus.
- **Manajemen Siswa**: CRUD (Create, Read, Update, Delete) data siswa lengkap dengan informasi orang tua, kelas (standar SMPN 6 Palu), dan status tinggal.
- **Sistem Penanganan Kasus**: Claim laporan siswa, lakukan interaksi, dan selesaikan kasus dengan catatan penanganan.
- **Database Arsip**: Pencarian arsip yang dikategorikan berdasarkan Konsultasi, Pelaporan, dan Surat.

### 🎓 Portal Siswa
- **Live Chat Konsultasi**: Fitur chat real-time dengan Guru BK dengan antarmuka premium (mirip Messenger/WhatsApp).
- **History Pelaporan**: Pantau status laporan yang dikirim (Pending, In Progress, Resolved).
- **Privasi Terjamin**: Dukungan pengiriman laporan anonim (opsional) untuk kenyamanan siswa.

### 🏠 Portal Publik (Guest)
- **Pelaporan Mandiri**: Siapapun dapat mengirimkan laporan (bullying, keluhan fasilitas, dll) tanpa harus login.
- **Tracking ID**: Dapatkan ID unik untuk memantau progres laporan yang dikirim.

---

## 🔒 Keamanan & Privasi
- **Mode Self-Destruct**: Seluruh riwayat chat konsultasi akan dihapus secara otomatis dan permanen dari database begitu kasus dinyatakan **Selesai** untuk menjaga kerahasiaan siswa.
- **End-to-End Visual Security**: Notifikasi keamanan visual untuk meyakinkan pengguna bahwa data mereka aman.

---

## 🛠️ Teknologi yang Digunakan
- **Backend**: Laravel 11.x (PHP 8.4)
- **Database**: MySQL / MariaDB
- **Frontend**: Tailwind CSS & Alpine.js
- **Typography**: Plus Jakarta Sans (Google Fonts)
- **Icons**: Heroicons & Lucide Icons

---

## 🚀 Instalasi Lokal

1. **Clone Repository**
   ```bash
   git clone https://github.com/ForLimm/SIMBEKA.git
   cd simbeka
   ```

2. **Instal Dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Konfigurasi Environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   *Sesuaikan konfigurasi database di file `.env`.*

4. **Migrasi Database**
   ```bash
   php artisan migrate --seed
   ```

5. **Jalankan Aplikasi**
   ```bash
   php artisan serve
   npm run dev
   ```

---

## 📸 Antarmuka (Preview)
- **Premium Design System**: Menggunakan skema warna *Slate & Blue* dengan efek *glassmorphism* dan *soft shadows*.
- **Responsive Layout**: Optimal untuk desktop maupun perangkat mobile.
- **Full-Screen Chat**: Layout chat imersif untuk pengalaman konseling yang lebih fokus.

---

## 📝 Kontribusi
Proyek ini dikembangkan untuk meningkatkan kualitas pelayanan bimbingan konseling di **SMP Negeri 6 Palu**. Kritik dan saran sangat terbuka melalui *Issue* atau *Pull Request*.

---

**© 2026 SIMBEKA Team - Dedicated to SMP Negeri 6 Palu**
