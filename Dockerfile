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
RUN cat > /entrypoint.sh << 'EOF'
#!/bin/sh
set -e
echo "Creating .env file..."
cp .env.example .env

echo "Setting production environment..."
sed -i "s/APP_ENV=local/APP_ENV=production/" .env
sed -i "s/APP_DEBUG=true/APP_DEBUG=false/" .env

# If DATABASE_URL is set, add it to .env
if [ -n "$DATABASE_URL" ]; then
  echo "DATABASE_URL environment variable detected"
  echo "DATABASE_URL=$DATABASE_URL" >> .env
fi

echo "Running database migrations..."
php artisan migrate --force || echo "Migrations already ran or connection issue"

echo "Starting PHP-FPM..."
exec php-fpm
EOF
RUN chmod +x /entrypoint.sh

EXPOSE 9000

ENTRYPOINT ["/entrypoint.sh"]
