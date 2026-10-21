FROM php:8.2.35-fpm-alpine

# System packages and PHP extensions
RUN apk add --no-cache bash nginx supervisor libpq libzip icu-libs \
    && apk add --no-cache --virtual .build-deps $PHPIZE_DEPS postgresql-dev libzip-dev icu-dev \
    && docker-php-ext-install pdo_pgsql pdo_mysql intl zip opcache \
    && apk del .build-deps

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# PHP, php-fpm, nginx and supervisor config
RUN cp /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini
COPY conf/php/docker-vars.ini /usr/local/etc/php/conf.d/docker-vars.ini
COPY conf/php/www-overrides.conf /usr/local/etc/php-fpm.d/zz-overrides.conf
COPY conf/nginx/nginx-site.conf /etc/nginx/http.d/default.conf
COPY conf/supervisor/supervisord.conf /etc/supervisord.conf
COPY conf/start.sh /start.sh

WORKDIR /var/www/html
COPY . .
RUN chown -R www-data:www-data storage bootstrap/cache

# Laravel config
ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr

# Allow composer to run as root
ENV COMPOSER_ALLOW_SUPERUSER 1

EXPOSE 80

CMD ["/start.sh"]
