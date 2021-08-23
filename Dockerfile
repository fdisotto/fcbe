ARG PHP_VERSION=7.4
FROM php:${PHP_VERSION}-fpm-alpine


# packages
RUN set -xe \
  && apk add --no-cache --update \
    $PHPIZE_DEPS \
    bash \
    curl \
    openssl \
    unzip \
    git \
    npm \
    nginx \
    supervisor \
    procps \
    icu \
    icu-dev \
    libintl \
    libxml2-dev \
    libzip-dev \
    libpng-dev \
    zlib-dev \
    gnu-libiconv \
    imagemagick \
    imagemagick-libs \
    imagemagick-dev \
    php7-imagick \
    libjpeg-turbo-dev \
    libpng-dev \
    freetype-dev \
  && docker-php-ext-configure gd --with-jpeg --with-freetype \
  && docker-php-ext-install -j$(nproc) \
    intl \
    gd \
    pcntl

# config
COPY docker/php-fpm/fpm-pool.conf /etc/php7/php-fpm.d/www.conf
COPY docker/php-fpm/php.ini /usr/local/etc/php/conf.d/php.ini
#COPY docker/php-fpm/dev/xdebug.ini /usr/local/etc/php/conf.d/dev/xdebug.ini
COPY docker/nginx/nginx.conf /etc/nginx/nginx.conf
COPY docker/nginx/default.conf /etc/nginx/sites-available/default.conf
#COPY docker/nginx/websocket.conf /etc/nginx/sites-available
COPY docker/supervisord/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
EXPOSE 443 80 5000

# install
WORKDIR /var/www/app

COPY composer.json ./
COPY dati/ ./dati
COPY inc/ ./inc
COPY pages/ ./pages
COPY public/ ./public
COPY version.txt ./

RUN set -xe \
    && curl -o composer.phar -sS https://getcomposer.org/composer-1.phar \
    && mv composer.phar /usr/bin/composer \
    && chmod +x /usr/bin/composer \
    && composer install --prefer-dist --no-cache --no-interaction --no-progress --no-suggest --no-autoloader --no-plugins --no-scripts

RUN set -xe \
    && composer dump-autoload --optimize \
    && chmod +x /usr/local/bin/entrypoint.sh

RUN chown www-data: -R .

ENV TZ=Europe/Rome
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# entrypoint
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
