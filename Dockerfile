# Dockerfile para Laravel 10

FROM php:8.1-fpm

# Instala dependencias del sistema
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    curl \
    git \
    libpq-dev \
    libzip-dev

# Instala extensiones de PHP
RUN docker-php-ext-install pdo pdo_pgsql mbstring zip exif pcntl bcmath gd

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Define directorio de trabajo
WORKDIR /var/www

# Copia los archivos del proyecto
COPY . .

# Instala dependencias del proyecto
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Da permisos
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage

# Puerto expuesto
EXPOSE 8000


# Comando de seeder
RUN php artisan migrate --seed --force


# Comando de inicio
CMD php artisan serve --host=0.0.0.0 --port=8000


