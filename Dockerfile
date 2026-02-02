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

# Parse DATABASE_URL if provided
if [ -n "$DATABASE_URL" ]; then
  echo "Parsing DATABASE_URL..."
  # Extract components from postgresql://user:password@host:port/database
  DB_HOST=$(echo $DATABASE_URL | sed -n 's/.*@\([^:]*\).*/\1/p')
  DB_PORT=$(echo $DATABASE_URL | sed -n 's/.*:\([0-9]*\)\/.*/\1/p')
  DB_DATABASE=$(echo $DATABASE_URL | sed -n 's/.*\/\([^?]*\).*/\1/p')
  DB_USER=$(echo $DATABASE_URL | sed -n 's/.*:\/\/\([^:]*\).*/\1/p')
  DB_PASSWORD=$(echo $DATABASE_URL | sed -n 's/.*:\/\/[^:]*:\([^@]*\).*/\1/p')
  
  sed -i "s/DB_HOST=.*/DB_HOST=$DB_HOST/" .env
  sed -i "s/DB_PORT=.*/DB_PORT=$DB_PORT/" .env
  sed -i "s/DB_DATABASE=.*/DB_DATABASE=$DB_DATABASE/" .env
  sed -i "s/DB_USERNAME=.*/DB_USERNAME=$DB_USER/" .env
  sed -i "s/DB_PASSWORD=.*/DB_PASSWORD=$DB_PASSWORD/" .env
  echo "Database configuration updated from DATABASE_URL"
fi

echo "Running database migrations..."
php artisan migrate --force || echo "Migrations may have already run"

echo "Starting PHP-FPM..."
exec php-fpm
EOF
chmod +x /entrypoint.sh

EXPOSE 9000

ENTRYPOINT ["/entrypoint.sh"]
