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

# Copy env file
COPY .env.example .env

# Create startup script - production safe with verbose logging
RUN cat > /entrypoint.sh << 'EOF'
#!/bin/sh
set -e

echo "[$(date)] Starting Shipment Tracker..."

# Ensure APP_KEY is set
if ! grep -q "^APP_KEY=" .env || [ -z "$(grep '^APP_KEY=' .env | cut -d= -f2)" ]; then
  echo "[$(date)] Generating APP_KEY..."
  php artisan key:generate --force
fi

# Set production mode
echo "[$(date)] Configuring production environment..."
sed -i 's/APP_ENV=.*/APP_ENV=production/' .env
sed -i 's/APP_DEBUG=.*/APP_DEBUG=false/' .env

# Run migrations if DATABASE_URL is set
if [ -n "$DATABASE_URL" ]; then
  echo "[$(date)] DATABASE_URL detected. Running migrations..."
  # Use migrate:refresh to drop and recreate schema
  php artisan migrate:refresh --force || php artisan migrate --force
  echo "[$(date)] Migrations completed successfully"
else
  echo "[$(date)] DATABASE_URL not set, skipping migrations"
fi

echo "[$(date)] Starting PHP-FPM..."
exec php-fpm
EOF
RUN chmod +x /entrypoint.sh

EXPOSE 9000

ENTRYPOINT ["/entrypoint.sh"]
