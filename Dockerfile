FROM php:8.3-fpm-bullseye

WORKDIR /app

# Install only essential system dependencies (fast)
RUN apt-get update && apt-get install -y --no-install-recommends \
    libpq-dev postgresql-client \
    && docker-php-ext-install pdo pdo_pgsql bcmath \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Copy Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy all app files first
COPY . .

# Install PHP dependencies (quiet mode, no progress, no scripts)
RUN composer install --no-dev --no-interaction --prefer-dist --no-scripts -q

# Set permissions and create required directories
RUN chown -R www-data:www-data /app && \
    mkdir -p storage/logs storage/framework/cache storage/framework/sessions storage/framework/views bootstrap/cache && \
    chown -R www-data:www-data storage bootstrap/cache

# Create startup script to parse DATABASE_URL and run migrations
RUN echo '#!/bin/sh\nset -e\necho "Creating .env file..."\ncp .env.example .env\necho "Setting production environment..."\nsed -i "s/APP_ENV=local/APP_ENV=production/" .env\nsed -i "s/APP_DEBUG=true/APP_DEBUG=false/" .env\necho "Running database migrations..."\nphp artisan migrate --force\necho "Starting PHP-FPM..."\nexec php-fpm' > /entrypoint.sh && \
    chmod +x /entrypoint.sh

EXPOSE 9000

ENTRYPOINT ["/entrypoint.sh"]
