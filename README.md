<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

##

# WEBSI

Ini adalah project Laravel yang sudah saya upload ke GitHub. Berikut langkah-langkah untuk cloning dan menjalankannya di komputer Anda. Pastikan sudah menginstal :
1. Composer
2. PHP versi >= 8.2
3. NodeJs
4. Git

## Langkah-langkah

# 1. Clone Repository
    git clone https://github.com/Rayyanda/fintek.git
    cd nama-project

# 2. Install Dependencies
    composer install

# 3. Copy file .env
    cp .env.example .env

# 4. Generate Application Key
    php artisan key:generate

# 5. Atur Konfigurasi Database
    Buka file .env dan ubah konfigurasi berikut sesuai dengan database Anda:
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=nama_database
    DB_USERNAME=username_database
    DB_PASSWORD=password_database

# 6. Jalankan Migrasi dan Seeder
    php artisan migrate
    php artisan db:seed

# 7. Jalankan Server Lokal
    php artisan serve


Project Laravel Anda sekarang sudah berjalan di http://127.0.0.1:8000
