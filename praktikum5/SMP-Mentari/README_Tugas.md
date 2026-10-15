# Tugas 4
Laporan Praktikum Pertemuan Ke - 5

# Website SMP Mentari Ceria
Aplikasi website sekolah berbasis Laravel yang menampilkan informasi kegiatan sekolah dan fitur buku tamu digital untuk SMP Mentari Ceria.

## Instalasi

### 1. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node dependencies
npm install
```

### 2. Setup Environment

```bash
# Copy file .env
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 2. Setup Database

```bash
# Jalankan migrasi
php artisan migrate
```

### 4. Build Assets

```bash
# Development
npm run dev

# Production
npm run build
```

### 5. Jalankan Aplikasi

```bash
# Menggunakan built-in server
php artisan serve --port=80

# Atau menggunakan composer script (recommended)
composer dev
```

Aplikasi akan berjalan di: `http://smp-mentari-jevrene.local`

## Tentang Aplikasi

Website SMP Mentari Ceria adalah aplikasi web sederhana yang dibangun dengan Laravel 12 untuk menampilkan informasi dan kegiatan sekolah. Aplikasi ini dilengkapi dengan fitur buku tamu digital yang memungkinkan pengunjung meninggalkan pesan dan kesan mereka.

### Fitur Halaman:

1. **Halaman Home** - Menampilkan kegiatan-kegiatan terbaru sekolah
2. **Buku Tamu** - Formulir interaktif untuk pengunjung meninggalkan pesan

## Fitur Utama

- ✅ **Tampilan Kegiatan Sekolah** - Showcase kegiatan terbaru dengan card design
- ✅ **Buku Tamu Digital** - Pengunjung dapat meninggalkan pesan
- ✅ **Form Validasi** - Validasi input untuk nama, email, dan pesan
- ✅ **Real-time Feedback** - Notifikasi sukses/error setelah submit
- ✅ **Responsive Design** - Tampilan optimal di semua device
- ✅ **Timestamp Relatif** - Menampilkan waktu pesan (e.g., "2 jam yang lalu")
- ✅ **Modern UI/UX** - Desain clean dengan Tailwind CSS

## Tech Stack

### Backend
- **Laravel** 12.x - PHP Framework
- **PHP** ^8.2 - Programming Language
- **MySql** - Database
- **Eloquent ORM** - Database Management

### Frontend
- **Blade Templates** - Template Engine33
- **Tailwind CSS** 4.0 - CSS Framework
- **Vite** 7.0 - Asset Bundler & HMR
- **Axios** - HTTP Client

### Development Tools
- **Laravel Sail** - Docker Development Environment
- **Pest PHP** - Testing Framework
- **Laravel Pint** - Code Style Fixer
- **Concurrently** - Multi-command Runner

## Tampilan Website SMP Mentari

### Halaman Home
<img width="1917" height="972" alt="image" src="https://github.com/user-attachments/assets/b20266e3-80ce-4161-a8c7-fb9dc68bad92" />

### Halaman Buku Tamu
<img width="1917" height="907" alt="image" src="https://github.com/user-attachments/assets/6690bbf1-f55f-46ce-8047-732b817446db" />
<img width="1913" height="338" alt="image" src="https://github.com/user-attachments/assets/76f694f1-c1fb-4db5-8672-ad3e3527acce" />

### Halaman Register
<img width="1917" height="965" alt="image" src="https://github.com/user-attachments/assets/f628b6fc-3c53-4bd3-8ba7-cac5e2762a67" />

### Halaman Login
<img width="1917" height="963" alt="image" src="https://github.com/user-attachments/assets/fb188f56-fe74-4c98-80ce-5d7f728055ad" />

### Halaman Lupa Password
<img width="1916" height="945" alt="image" src="https://github.com/user-attachments/assets/bf8bff5e-9f8f-475a-bb89-50d48aaba658" />

### Halaman Dashboard
<img width="1917" height="968" alt="image" src="https://github.com/user-attachments/assets/ce6b250c-a000-45ce-8004-770733c8784d" />

Dashboard di akses ketika sudah login dan bisa mengatur atau pusat kendali dari website SMP Mentari
<img width="1917" height="911" alt="image" src="https://github.com/user-attachments/assets/6fee5677-1083-4864-a24a-51c7222a481c" />

Kendali atau mengelola kegiatan SMP Mentari
<img width="1917" height="907" alt="image" src="https://github.com/user-attachments/assets/f60aef17-de42-4acd-937a-6c08492e53f0" />
<img width="1917" height="916" alt="image" src="https://github.com/user-attachments/assets/376d5e9d-9de7-4776-a103-e897addc7bc3" />
<img width="1917" height="907" alt="image" src="https://github.com/user-attachments/assets/228f6481-1658-40a3-8e3d-cfd857171272" />

Kelola Buku Tamu
<img width="1917" height="902" alt="image" src="https://github.com/user-attachments/assets/9f356f64-aaa0-408d-ae3e-6418d31ed82e" />

Konfigurasi tampilan Home Kegiatan per page dengan default nya 6 (Bisa diubah sesuai keinginan)
<img width="1917" height="908" alt="image" src="https://github.com/user-attachments/assets/18853634-f460-4e44-8871-bad739055354" />

