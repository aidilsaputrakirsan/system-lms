# Panduan Setup LMS dengan Laravel dan Filament

## Prasyarat
Sebelum memulai, pastikan Anda memiliki:
* PHP 8.1+ dengan ekstensi yang diperlukan
* Composer
* PostgreSQL
* Node.js dan NPM

## 1. Instalasi Laravel
Buat proyek Laravel baru:

```bash
# Buat proyek Laravel baru di folder terpisah
composer create-project laravel/laravel lms-system

# Pindah ke direktori proyek baru
cd lms-system
```

## 2. Instalasi Filament
### Menginstal Filament pada Laravel 12
Untuk Laravel 12, gunakan Filament versi 3.3.0 atau lebih baru:

```bash
composer require filament/filament:"^3.3" -W
```

Jika mengalami error seperti berikut:
```
The "3.3" constraint for "filament/filament" appears too strict and will likely not match what you want.
```
Tetap lanjutkan dan tunggu proses selesai.

### Menjalankan Installer Filament
Setelah package terinstal, jalankan installer Filament:

```bash
php artisan filament:install --panels
```

### Publikasi Asset
```bash
php artisan vendor:publish --tag=filament-config
npm install
npm run build
```

## 3. Penanganan Error Ekstensi PHP
### Error: Ekstensi intl Tidak Ditemukan
Jika Anda melihat error seperti ini:
```
filament/support v3.3.0 requires ext-intl * -> it is missing from your system. Install or enable PHP's intl extension.
```

**Solusi:**
1. Buka file `php.ini` (umumnya di `C:\php\php.ini` untuk Windows atau `/etc/php/x.x/cli/php.ini` untuk Linux)
2. Cari baris `;extension=intl`
3. Hapus tanda titik koma di depannya menjadi `extension=intl`
4. Simpan file dan restart server PHP/webserver Anda

### Error: Driver PostgreSQL Tidak Ditemukan
Jika Anda melihat error seperti berikut:
```
could not find driver (Connection: pgsql, SQL: ...)
```

**Solusi:**
1. Buka file `php.ini`
2. Cari dan aktifkan kedua ekstensi berikut:
```
extension=pdo_pgsql
extension=pgsql
```
3. Simpan file dan restart server PHP/webserver Anda
4. Verifikasi ekstensi sudah aktif dengan perintah:
```bash
php -m | findstr pgsql
```

## 4. Konfigurasi Database PostgreSQL
### Setup Database di .env
Edit file `.env` dan sesuaikan konfigurasi database:

```
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=lms_system_db
DB_USERNAME=lms_admin
DB_PASSWORD=L3arning@Mgt#2025
```

### Membuat Database dan User
Buka PostgreSQL command line:

```bash
psql -U postgres
```

Jalankan perintah berikut:

```sql
-- Membuat database
CREATE DATABASE lms_system_db;

-- Membuat user
CREATE USER lms_admin WITH PASSWORD 'L3arning@Mgt#2025';

-- Memberikan hak akses pada database
GRANT ALL PRIVILEGES ON DATABASE lms_system_db TO lms_admin;

-- Hubungkan ke database
\c lms_system_db

-- Memberikan hak akses pada schema
GRANT ALL ON SCHEMA public TO lms_admin;
GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA public TO lms_admin;
GRANT ALL PRIVILEGES ON ALL SEQUENCES IN SCHEMA public TO lms_admin;
GRANT ALL PRIVILEGES ON ALL FUNCTIONS IN SCHEMA public TO lms_admin;

-- Mengatur user sebagai pemilik schema
ALTER SCHEMA public OWNER TO lms_admin;

-- Keluar dari psql
\q
```

### Menjalankan Migrasi
Setelah konfigurasi database selesai, jalankan migrasi:

```bash
php artisan config:clear
php artisan migrate
```

## 5. Pengaturan Tambahan dan Verifikasi

### Membuat User Admin Filament
Buat user admin untuk mengakses panel Filament:

```bash
php artisan make:filament-user
```

### Mengaktifkan Storage Link
Buat symlink untuk file storage:

```bash
php artisan storage:link
```

### Verifikasi Instalasi
Jalankan server development:

```bash
php artisan serve
```

Akses panel admin di: http://localhost:8000/admin

## 6. Pengaturan Tambahan untuk LMS

### Paket-paket yang Mungkin Dibutuhkan
Berikut adalah beberapa paket tambahan yang dapat bermanfaat untuk sistem LMS:

```bash
# Untuk penanganan file dan media
composer require spatie/laravel-medialibrary:"^10.0.0"

# Untuk penanganan slug
composer require spatie/laravel-sluggable:"^3.5"

# Untuk penanganan role dan permission
composer require spatie/laravel-permission:"^6.0"

# Untuk penanganan markdown
composer require league/commonmark:"^2.4"

# Untuk export/import Excel
composer require maatwebsite/excel:"^3.1"
```

### Publikasikan Konfigurasi Media Library
Jika menggunakan Media Library, publikasikan konfigurasinya:

```bash
php artisan vendor:publish --provider="Spatie\MediaLibrary\MediaLibraryServiceProvider" --tag="migrations"
php artisan vendor:publish --provider="Spatie\MediaLibrary\MediaLibraryServiceProvider" --tag="config"
```

Dengan langkah-langkah ini, lingkungan pengembangan Anda siap untuk implementasi model dan migration sesuai dengan diagram LMS yang telah dirancang.
