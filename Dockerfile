# Używamy oficjalnego obrazu PHP 8.2 jako bazowego
FROM php:8.2-fpm

# Ustawienie zmiennych środowiskowych
ENV DEBIAN_FRONTEND=noninteractive

# Instalacja zależności systemowych
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    libzip-dev \
    libonig-dev \
    libpq-dev \
    libmcrypt-dev

# Instalacja rozszerzeń PHP
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# Instalacja kompozytora
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Ustawienie katalogu roboczego
WORKDIR /var/www

# Kopiowanie plików aplikacji
COPY . .

# Instalacja zależności PHP
RUN composer install

# Ustawienie uprawnień dla katalogów storage i bootstrap/cache
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Uruchomienie serwera PHP-FPM
CMD ["php-fpm"]
