# Tahap 1: Install dependensi PHP dengan Composer
FROM composer:2 as vendor

WORKDIR /app

# Salin file composer untuk menginstal dependensi
COPY database/ database/
COPY composer.json composer.json
COPY composer.lock composer.lock

# Install dependensi tanpa script dev dan optimalkan autoloader
RUN composer install --no-interaction --no-plugins --no-scripts --no-dev --prefer-dist --optimize-autoloader


# Tahap 2: Bangun aset frontend dengan Node.js
FROM node:18-alpine as frontend

WORKDIR /app

# Salin file-file konfigurasi frontend yang ADA di proyek Anda
COPY package.json .
COPY webpack.mix.js .
# CATATAN: Menghapus baris untuk 'package-lock.json', 'tailwind.config.ts', dan 'postcss.config.mjs'
# karena file-file tersebut tidak ada di struktur proyek Anda.

# Install dependensi Node.js
RUN npm install

# Salin folder resources yang berisi aset mentah (js, css)
COPY resources/ resources/

# Kompilasi aset untuk production
RUN npm run prod


# Tahap 3: Final Image Aplikasi PHP
FROM php:8.2-fpm-alpine

WORKDIR /var/www/html

# Set argumen untuk user dan group
ARG UID=1000
ARG GID=1000

# Install dependensi sistem yang umum dibutuhkan Laravel
# dan ekstensi PHP yang diperlukan
RUN apk add --no-cache \
    nginx \
    supervisor \
    libzip-dev \
    zip \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    imagemagick-dev;

RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install pdo pdo_mysql zip bcmath opcache

# Hapus cache apk
RUN rm -rf /var/cache/apk/*

# Salin kode aplikasi dari direktori lokal
COPY . .

# Salin dependensi PHP dari tahap 'vendor'
COPY --from=vendor /app/vendor/ /var/www/html/vendor/

# Salin aset frontend yang sudah di-build dari tahap 'frontend'
COPY --from=frontend /app/public/ /var/www/html/public/

# Buat user dan group agar tidak berjalan sebagai root
RUN addgroup -g ${GID} --system laravel
RUN adduser -u ${UID} -G laravel --shell /bin/sh --disabled-password laravel

# Ubah kepemilikan file ke user baru
RUN chown -R laravel:laravel /var/www/html

# Ganti ke user non-root
USER laravel

# Expose port untuk PHP-FPM
EXPOSE 9000

# Perintah default untuk menjalankan PHP-FPM
CMD ["php-fpm"]
