FROM php:8.3-fpm-bullseye

WORKDIR /app

# Install only essential system dependencies (fast)
RUN apt-get update && apt-get install -y --no-install-recommends \
    libpq-dev postgresql-client \
    && docker-php-ext-install pdo pdo_pgsql bcmath \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Copy Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy only composer files first (for better caching)
COPY composer.json composer.lock ./

# Install PHP dependencies (skip scripts that hang)
RUN composer install --no-dev --no-scripts --optimize-autoloader

# Copy app code
COPY . .

# Set permissions
RUN chown -R www-data:www-data /app && \
    mkdir -p storage/logs storage/framework/cache storage/framework/sessions storage/framework/views

EXPOSE 9000

CMD ["php-fpm"]
