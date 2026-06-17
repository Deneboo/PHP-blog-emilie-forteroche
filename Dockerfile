FROM php:8.3-fpm-alpine

# Dépendances système
RUN apk add --no-cache \
    icu-dev \
    icu-data-full \
    oniguruma-dev \
    libzip-dev \
    $PHPIZE_DEPS

# Extensions PHP
RUN docker-php-ext-configure intl \
    && docker-php-ext-install intl pdo pdo_mysql

# Installation Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install bash to run with : docker exec -it php-image-name bash
RUN apk add --no-cache bash

RUN rm -rf /var/cache/apk/*