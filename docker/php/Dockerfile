# Utilise l'image PHP 8.3 FPM comme base
FROM php:8.3-fpm

# Installer les dépendances nécessaires et l'extension MongoDB
RUN apt-get update && apt-get install -y \
    libssl-dev \
    pkg-config \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb

# Installer les dépendances nécessaires et l'extension intl
RUN apt-get update && apt-get install -y \
    libicu-dev \
    && docker-php-ext-install intl

# Nettoyer le cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*