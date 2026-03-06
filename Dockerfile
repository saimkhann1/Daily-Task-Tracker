# PHP aur Apache ka server use karein
FROM php:8.2-apache

# Zaroori softwares aur Node.js (Vite ke liye) install karein
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nodejs \
    npm

# Cache saaf karein
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# PHP extensions install karein jo Laravel ko chahiye
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Composer install karein
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Project ka working folder set karein
WORKDIR /var/www/html

# Apna sara code Docker mein copy karein
COPY . /var/www/html

# Composer aur NPM ki files install karein
RUN composer install --no-interaction --optimize-autoloader --no-dev
RUN npm install && npm run build

# Storage aur Cache folders ko permissions dein
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Apache ko batayein ke Laravel ka 'public' folder main hai
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# URL rewriting on karein (Login/Register routes ke liye)
RUN a2enmod rewrite

EXPOSE 80