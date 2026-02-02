FROM php:8.3-fpm-bullseye

WORKDIR /app

# Install dependencies and PHP extensions (minimal - only what Laravel needs)
RUN apt-get update && apt-get install -y --no-install-recommends \
    curl libpq-dev postgresql-client nginx supervisor \
    && docker-php-ext-install pdo pdo_pgsql bcmath \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Copy Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy app files
COPY . .

# Install dependencies
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader && \
    chown -R www-data:www-data /app && \
    mkdir -p storage/logs storage/framework/cache storage/framework/sessions storage/framework/views

# Copy configs
COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/default.conf /etc/nginx/conf.d/default.conf
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

EXPOSE 8080

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
