# Gunakan image PHP resmi dengan Apache
FROM php:8.2-apache

# Install ekstensi PHP yang umum dibutuhkan (mysqli untuk database)
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Aktifkan mod_rewrite supaya file .htaccess kamu berfungsi
RUN a2enmod rewrite

# Copy semua file codingan kamu ke dalam folder html di container
COPY . /var/www/html/

# Atur permission folder (biar aman)
RUN chown -R www-data:www-data /var/www/html

# Expose port 80 biar bisa diakses
EXPOSE 80