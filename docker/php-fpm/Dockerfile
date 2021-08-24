FROM php:7.4-fpm-alpine AS phpbase

RUN apk update \
    && apk add  --no-cache \
    git \
    curl \
    icu-dev \
    libxml2-dev \
    g++ \
    libzip-dev \
    make \
    autoconf \
    zip \
    zlib-dev \
    openssh-keygen \
    && docker-php-source extract \
    && pecl install xdebug redis\
    && docker-php-ext-enable xdebug redis \
    && docker-php-source delete

RUN docker-php-ext-install intl zip \
     mysqli pdo_mysql \
#    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --1 --filename=composer \
    && rm -rf /tmp/*

RUN rm -rf /var/www/html 2> /dev/null

WORKDIR /var/www/
