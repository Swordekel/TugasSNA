# Gunakan image PHP dengan Apache
FROM php:8.1-apache

# Set working directory
WORKDIR /var/www/html

# Install dependencies yang dibutuhkan
RUN apt-get update && apt-get install -y \
    unzip \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    git \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer secara manual
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Copy semua file proyek ke dalam container
COPY . .

# Install dependencies Laravel
RUN composer install --no-dev --optimize-autoloader

# Set permissions untuk Laravel agar bisa berjalan dengan baik
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Generate APP_KEY (Opsional)
RUN php artisan key:generate

# Expose port 80
EXPOSE 80

# Jalankan Apache
CMD ["apache2-foreground"]
