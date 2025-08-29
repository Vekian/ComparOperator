FROM php:8.1-fpm

# Installer extensions PHP nécessaires
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip git curl \
    && docker-php-ext-install pdo pdo_mysql zip \
    && rm -rf /var/lib/apt/lists/*

# Copier le code dans l’image
WORKDIR /var/www/html
COPY . .

# Définir un user non-root (bonne pratique en prod)
RUN useradd -m www && chown -R www:www /var/www/html
USER www
