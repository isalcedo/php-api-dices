FROM php:7.4-fpm
RUN set -eux; \
    apt-get update; \
    apt-get upgrade -y; \
    apt-get install -y --no-install-recommends \
            curl \
            libmemcached-dev \
            libz-dev \
            libpq-dev \
            libjpeg-dev \
            libpng-dev \
            libfreetype6-dev \
            libssl-dev \
            libzip-dev \
            libmcrypt-dev; \
    rm -rf /var/lib/apt/lists/*

RUN set -eux; \
    # Install the PHP pdo_mysql extention
    docker-php-ext-install pdo_mysql; \
    # Install the PHP pdo_pgsql extention
    docker-php-ext-install pdo_pgsql; \
    # Install the PHP gd library
    docker-php-ext-configure gd \
            --with-jpeg=/usr/include \
            --with-freetype=/usr/include; \
    docker-php-ext-install gd; \
    docker-php-ext-install zip; \
    docker-php-ext-install pcntl; \
    php -r 'var_dump(gd_info());'
