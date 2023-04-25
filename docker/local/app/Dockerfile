FROM php:8.2.5-fpm-alpine3.17

RUN apk add --no-cache --virtual .build-deps \
    $PHPIZE_DEPS \
    supervisor \
    build-base \
    libpng-dev \
    libzip-dev \
    dcron \
    unzip \
    linux-headers \
    zip \
    postgresql-dev \
    && pecl install redis\
    && docker-php-ext-enable redis

RUN docker-php-ext-install \
    pdo_pgsql \
    gd \
    pcntl \
    zip

WORKDIR /srv/app

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

COPY ./horizon.conf /etc/supervisor/conf.d/horizon.conf

COPY ./docker-entrypoint.sh /docker-entrypoint.sh

COPY ./crontab /etc/crontabs/root

RUN chmod +x /docker-entrypoint.sh

EXPOSE 9000

ENTRYPOINT ["/docker-entrypoint.sh"]

CMD ["/bin/sh"]
