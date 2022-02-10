FROM php:7.1-fpm-alpine

WORKDIR /var/www/app

RUN apk update --no-cache \
    && apk add --no-cache \
    git \
    zip \
    unzip \
    libpng-dev \
    icu-dev \
    libzip-dev \
    autoconf \
    g++ \
    make

RUN docker-php-ext-install pdo_mysql intl gd zip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

RUN chown -R www-data:www-data /var/www/app