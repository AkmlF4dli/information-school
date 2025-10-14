# Dockerfile
FROM php:8.2-fpm

# Instal ekstensi PHP yang dibutuhkan Laravel dan untuk MariaDB/MySQL
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    --no-install-recommends && \
    docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath gd opcache

# Hapus cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Instal Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory di dalam container
WORKDIR /var/www/html

# Salin kode aplikasi (asumsi kode ada di folder saat ini)
COPY . /var/www/html

# Instal dependensi Composer
RUN composer install --no-dev --optimize-autoloader

# Atur hak akses folder storage dan bootstrap/cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Port default PHP-FPM
EXPOSE 9000
CMD ["php-fpm"]
