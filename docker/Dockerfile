FROM php:8.2-fpm

ENV COMPOSER_HOME /tmp

RUN apt-get update

RUN apt-get install -y \
    git \
    libicu-dev \
    libpq-dev \
    libzip-dev \
    unzip

RUN docker-php-ext-configure intl

RUN docker-php-ext-install -j$(nproc) intl pcntl pdo pdo_pgsql zip

COPY php.ini $PHP_INI_DIR/conf.d/webapp.ini

COPY --from=composer/composer /usr/bin/composer /usr/bin/composer
