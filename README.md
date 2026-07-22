# Bagi Kata

Media sosial berbasis web yang terinspirasi dari konsep microblogging seperti Twitter. Proyek ini dibangun menggunakan Laravel dan Livewire secara hybrid, dengan Flux UI untuk mempercepat pengembangan antarmuka.

### DEMO APP ->
https://bagikata.freedev.app/

## Fitur Utama

- Timeline postingan dengan interaksi sosial (like, favorit, tag)
- Pengelolaan profil pengguna
- Komponen UI berbasis Livewire + Flux UI
- Dukungan build frontend via Vite

## Teknologi

- Laravel 13
- Livewire 4
- Flux UI (livewire/flux)
- Vite + Tailwind CSS

## Prasyarat

- PHP 8.3+
- Composer
- Node.js + npm
- Database (MySQL, MariaDB, atau SQLite)

## Instalasi

```bash
composer install
cp .env.example .env
php artisan key:generate
```

Atur koneksi database di file `.env`, lalu jalankan migrasi:

```bash
php artisan migrate
```

Install dependency frontend dan build aset:

```bash
npm install
npm run build
```

## Menjalankan Aplikasi (Development)

```bash
composer run dev
```

Perintah di atas akan menjalankan server Laravel, queue listener, log viewer, dan Vite dev server secara bersamaan.

## Skrip Berguna

- `composer run analyze` - Menjalankan PHPStan
- `composer run test` - Menjalankan test suite Laravel
- `npm run dev` - Menjalankan Vite dev server
- `npm run build` - Build aset produksi

## Lisensi

Proyek ini berlisensi MIT.
