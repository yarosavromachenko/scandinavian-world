FROM php:8.1-cli

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libzip-dev \
    libicu-dev \
    libonig-dev \
    zlib1g-dev \
    && docker-php-ext-install pdo pdo_mysql intl zip opcache bcmath \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN curl -sS https://get.symfony.com/cli/installer | bash \
    && mv /root/.symfony*/bin/symfony /usr/local/bin/symfony

WORKDIR /var/www/html

COPY docker/php/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint

ENTRYPOINT ["/entrypoint"]
