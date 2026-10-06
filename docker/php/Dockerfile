FROM php:8.3-fpm-alpine

RUN apk add --no-cache \
    curl \
    unzip \
    git \
    libzip-dev \
    && docker-php-ext-install zip

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
