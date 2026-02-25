FROM dunglas/frankenphp:1-php8.2-alpine

RUN apk add --no-cache \
    curl \
    zip \
    unzip \
    git \
    oniguruma-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    postgresql-dev \
    libsodium-dev \
    libzip-dev

# Add the PHP extension installer helper
ADD --chmod=0755 https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN install-php-extensions \
    pdo_pgsql \
    pcntl \
    bcmath \
    gd \
    intl \
    zip \
    opcache

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --prefer-dist

RUN chmod -R 775 storage bootstrap/cache

# Environment variables for FrankenPHP
ENV SERVER_NAME=":8080"
ENV DOCUMENT_ROOT=/var/www/html/public
ENV PHP_INI_SCAN_DIR="/usr/local/etc/php/conf.d"

EXPOSE 8080

CMD ["/bin/sh", "/var/www/html/docker/start.sh"]
