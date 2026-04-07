# Voyago - Premium Travel Booking Platform ✈️🚂🏨

**Voyago** adalah platform pemesanan tiket perjalanan modern yang dirancang untuk memberikan pengalaman "One-Stop Solution" bagi para penjelajah. Aplikasi ini mengintegrasikan layanan transportasi (Pesawat, Kereta, Bus), akomodasi (Hotel), hingga destinasi wisata dalam satu antarmuka yang elegan dan responsif.

## ✨ Fitur Utama
- **Multi-Category Booking:** Pesan tiket Pesawat, Kereta, Bus, Hotel, dan Wisata dalam satu aplikasi.
- **Modern Dashboard:** Interface Dashboard khusus untuk Admin dan Mitra dengan statistik real-time.
- **Secure Payment:** Integrasi simulator pembayaran yang aman.
- **Google OAuth:** Fitur login satu klik menggunakan akun Google.
- **Booking Management:** Sistem riwayat pesanan yang mendetail dengan status (Pending, Confirmed, Completed, Cancelled).
- **Complaint System:** Fitur pengaduan untuk menjaga transparansi antara Pengguna, Mitra, dan Admin.

## 🛠️ Tech Stack
- **Framework:** Laravel 12
- **Styling:** Tailwind CSS & Vanilla CSS (Custom Design)
- **Database:** MySQL
- **Icons:** Font Awesome 6
- **Integrations:** Laravel Socialite (Google Login), Midtrans API (Payment Gateway Support)

---

## 🔑 Akun Demonstrasi (Testing)

Silakan gunakan kredensial berikut untuk menguji berbagai role dalam aplikasi:

### 1. Akun User (Pelanggan)
Akses: Portal Utama User
- **Email:** `test@example.com`
- **Password:** `password`

### 2. Akun Admin (Super-Admin)
Akses: `/admin/login`
- **Email:** `admin@voyago.com`
- **Password:** `admin123`

### 3. Akun Mitra (Partner/Bisnis)
Akses: `/partner/auth` (Voyago Business)
- **Password:** `mitra123` (Berlaku untuk semua mitra di bawah ini)

**Daftar Akun Mitra:**
1.  **Transportasi Udara:** `garuda@voyago.com`
2.  **Transportasi Darat (Kereta):** `kai@voyago.com`
3.  **Transportasi Darat (Bus):** `damri@voyago.com`
4.  **Akomodasi:** `mitra@voyago.com`
5.  **Wisata & Rekreasi:** `bali_tours@voyago.com`

---

## 🚀 Cara Menjalankan Project
1.  Pastikan Server Lokal (Laragon/XAMPP) aktif.
2.  Jalankan perintah `php artisan serve` di terminal.
3.  Akses project melalui `http://localhost:8000` atau melalui link ngrok yang tersedia.

---
**Tugas Akhir Sekolah - Dikembangkan oleh Frinzka Desfrilia**
