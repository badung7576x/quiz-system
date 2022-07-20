FROM php:8.0-fpm-alpine

RUN apk add --no-cache git unzip shadow \
    libpng-dev jpeg-dev freetype-dev \
    ffmpeg libzip-dev

RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
 && docker-php-ext-install pdo_mysql gd zip

COPY conf/www.conf /usr/local/etc/php-fpm.d/www.conf
COPY conf/php.ini /usr/local/etc/php/php.ini

ARG uid gid

RUN groupmod -g $gid www-data \
 && usermod -u $uid -g www-data www-data

ENV COMPOSER_HOME="/app/.composer"
WORKDIR /app
