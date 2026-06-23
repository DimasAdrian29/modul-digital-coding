# Modul Digital Coding

Modul Digital Coding adalah aplikasi pembelajaran berbasis web untuk membantu siswa mempelajari materi coding secara bertahap per bab. Aplikasi ini menyediakan materi video, latihan soal, forum diskusi, pelacakan progres belajar, dan sertifikat digital untuk bab yang lulus.

Project ini dibangun dengan Laravel dan Blade, dengan area belajar untuk siswa serta dashboard manajemen untuk guru atau admin.

## Fitur Utama

- Autentikasi login dan register untuk `siswa` dan `guru`
- Role-based access untuk `siswa`, `guru`, dan `admin`
- Materi pembelajaran terstruktur per bab
- Sistem unlock bab berikutnya berdasarkan progres belajar
- Latihan soal pilihan ganda per bab
- Penyimpanan riwayat hasil latihan per user
- Forum diskusi per bab
- Dashboard admin/guru untuk kelola materi, soal, forum, dan sertifikat
- Sertifikat digital otomatis untuk user yang memenuhi nilai minimum
- Export sertifikat ke PDF

## Stack Teknologi

- PHP `^8.3`
- Laravel `^13.0`
- Blade Template Engine
- Tailwind CSS `^4`
- Vite `^8`
- Dompdf `^3.1`
- PHPUnit `^12`

## Alur Penggunaan

### Siswa

1. Register akun sebagai `siswa`
2. Login ke aplikasi
3. Buka daftar bab pada halaman utama
4. Pelajari materi di bab yang tersedia
5. Kerjakan latihan soal
6. Jika nilai latihan memenuhi syarat, bab berikutnya akan terbuka
7. Jika nilai akhir memenuhi syarat sertifikat, user dapat melihat dan mengunduh PDF sertifikat
8. Ikut berdiskusi di forum per bab

### Guru/Admin

1. Login menggunakan akun dengan role `guru` atau `admin`
2. Masuk ke dashboard admin
3. Kelola materi pembelajaran
4. Kelola bank soal per bab
5. Memantau dan membalas diskusi forum
6. Melihat daftar sertifikat yang sudah diterbitkan

## Struktur Fitur Inti

### Domain Model

- `Materi`: konten pembelajaran per bab
- `Soal`: bank soal latihan
- `BabProgress`: progres belajar user per bab
- `Sertifikat`: sertifikat digital user
- `ForumPost`: topik diskusi forum
- `ForumReply`: balasan diskusi forum
- `User`: akun dengan role dan profil siswa/guru

### Controller Penting

- `HomeController`: alur belajar siswa, progres bab, latihan, forum, dan sertifikat
- `AuthController`: login, register, logout, dan redirect berdasarkan role
- `AdminDashboardController`: ringkasan statistik dashboard guru/admin
- `MateriController`: CRUD materi
- `SoalController`: CRUD soal
- `ForumPostController`: moderasi dan balasan forum
- `SertifikatController`: tampilan dan download sertifikat

### Route Utama

- `/login`, `/register`
- `/` untuk beranda siswa
- `/bab/{bab}` untuk halaman bab
- `/bab/{bab}/materi` untuk daftar materi per bab
- `/bab/{bab}/latihan` untuk latihan soal
- `/bab/{bab}/forum` untuk diskusi forum
- `/admin` untuk dashboard guru/admin

## Struktur Project Singkat

```text
app/
  Http/
    Controllers/
    Middleware/
  Models/
  Support/
database/
  migrations/
  seeders/
public/
  css/
  images/
  js/
resources/
  css/
  js/
  views/
routes/
  web.php
tests/
  Feature/
  Unit/
```

## Setup Lokal

### 1. Clone dan masuk ke folder project

```bash
git clone <repository-url>
cd modul-digital-coding
```

### 2. Install dependency

```bash
composer install
npm install
```

### 3. Siapkan environment

```bash
copy .env.example .env
php artisan key:generate
```

Sesuaikan konfigurasi database di file `.env`.

### 4. Jalankan migration dan seeder

```bash
php artisan migrate --seed
```

Seeder bawaan akan mengisi:

- 6 materi pembelajaran dari `Bab 1` sampai `Bab 6`
- 5 soal latihan awal untuk `Bab 1`

### 5. Jalankan aplikasi

Untuk mode development penuh:

```bash
composer run dev
```

Perintah ini akan menjalankan:

- Laravel development server
- Queue listener
- Laravel Pail
- Vite dev server

Jika ingin menjalankan manual:

```bash
php artisan serve
npm run dev
```

## Konfigurasi Penting

Beberapa konfigurasi yang layak diperhatikan:

- `APP_NAME`
- `APP_URL`
- `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`
- `APP_LOCALE`
- `APP_FALLBACK_LOCALE`
- `QUEUE_CONNECTION`
- `SESSION_DRIVER`

Catatan:

- `.env.example` masih default Laravel untuk locale dan timezone
- Jika aplikasi dipakai penuh dalam Bahasa Indonesia, disarankan menyesuaikan locale dan timezone pada environment aktif

## Testing

Jalankan test dengan:

```bash
php artisan test
```

Area yang sudah memiliki coverage test:

- urutan bab berdasarkan nomor
- normalisasi nama bab
- mekanisme lock/unlock bab
- progres belajar per user
- pembuatan sertifikat
- pencegahan sertifikat duplikat

## Mekanisme Sertifikat

Sertifikat akan dibuat otomatis saat user menyelesaikan latihan dan nilainya memenuhi ambang yang diterapkan aplikasi. Sertifikat:

- unik per user per bab
- dapat dilihat di browser
- dapat diunduh dalam format PDF
- memakai renderer browser jika tersedia, dan fallback ke Dompdf atau generator PDF sederhana

## Catatan Pengembangan

- `README.md` ini menjelaskan aplikasi, tetapi belum mencakup diagram arsitektur
- Frontend saat ini dominan menggunakan Blade dan JavaScript langsung pada `public/js`
- Role `admin` didukung pada middleware dan routing, tetapi flow pembuatan akun admin tidak disediakan dari halaman register
- Tidak ada API terpisah; aplikasi ini memakai pendekatan server-rendered

## Rekomendasi Lanjutan

Beberapa pengembangan yang cocok dilakukan berikutnya:

- menambah dokumentasi deployment
- menambah akun admin seeder atau command bootstrap admin
- memperluas test untuk auth, forum, dan admin CRUD
- memindahkan asset JavaScript ke alur bundling Vite yang konsisten
- menyesuaikan locale dan timezone agar format tanggal sesuai kebutuhan sekolah

## License

Project ini mengikuti lisensi yang digunakan pada basis Laravel, kecuali ditentukan lain oleh pemilik project.
