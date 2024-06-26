FROM php:8.2.3-fpm

# Arguments defined in docker-compose.yml

RUN apt-get update && apt-get install -y \
    build-essential \
    libzip-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libwebp-dev libjpeg62-turbo-dev libpng-dev libxpm-dev \
    libfreetype6 \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    unzip \
    git \
    curl \
    libpq-dev # Add PostgreSQL library

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo pdo_pgsql pgsql gd # Install PostgreSQL extensions

RUN apt-get update; \
    # Imagick extension
    apt-get install -y libmagickwand-dev; \
    pecl install imagick; \
    docker-php-ext-enable imagick; \
    docker-php-ext-install intl; \
    docker-php-ext-enable intl; \
    # Success
    true

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user to run Composer and Artisan Commands
RUN groupadd -g 1000 www \
    && useradd -u 1000 -ms /bin/bash -g www www

USER www

WORKDIR /var/www

CMD ["php-fpm"]
