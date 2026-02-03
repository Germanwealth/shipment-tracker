FROM php:8.3-fpm-bullseye

WORKDIR /app

# Install system dependencies including nginx
RUN apt-get update && apt-get install -y --no-install-recommends \
    libpq-dev postgresql-client nginx \
    && docker-php-ext-install pdo pdo_pgsql bcmath \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Copy Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy all app files
COPY . .

# Install PHP dependencies (quiet mode, no progress, no scripts)
RUN composer install --no-dev --no-interaction --prefer-dist --no-scripts -q

# Set permissions and create required directories
RUN chown -R www-data:www-data /app && \
    mkdir -p storage/logs storage/framework/cache storage/framework/sessions storage/framework/views bootstrap/cache && \
    chmod -R 775 storage bootstrap/cache && \
    chown -R www-data:www-data storage bootstrap/cache

# DO NOT copy .env here - let entrypoint create it from environment variables

# Configure Nginx to forward to PHP-FPM
RUN mkdir -p /etc/nginx/sites-available /etc/nginx/sites-enabled && \
    cat > /etc/nginx/sites-available/default << 'NGINX'
server {
    listen 8080 default_server;
    server_name _;
    root /app/public;
    index index.php index.html;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        fastcgi_param SCRIPT_NAME /index.php;
        include fastcgi_params;
        fastcgi_hide_header X-Powered-By;
        
        # Error handling
        error_page 502 503 /50x.html;
    }

    location ~ /\. {
        deny all;
    }
}
NGINX

RUN ln -sf /etc/nginx/sites-available/default /etc/nginx/sites-enabled/default

# Create startup script
RUN cat > /entrypoint.sh << 'EOF'
#!/bin/sh
set -e

echo "[$(date)] Starting Shipment Tracker..."

# Copy .env.example to .env if .env doesn't exist
if [ ! -f .env ]; then
  echo "[$(date)] Creating .env from .env.example..."
  cp .env.example .env
fi

# Read all environment variables and write to .env
echo "[$(date)] Updating .env with environment variables..."

# Function to update or add env variable
update_env() {
  key=$1
  value=$2
  if grep -q "^$key=" .env; then
    # Update existing
    sed -i "s|^$key=.*|$key=$value|" .env
    echo "  Updated: $key"
  else
    # Add new
    echo "$key=$value" >> .env
    echo "  Added: $key"
  fi
}

# Update variables from environment
echo "[$(date)] Environment vars before update:"
echo "  APP_KEY env: $([ -n "$APP_KEY" ] && echo 'SET' || echo 'NOT SET')"
echo "  DATABASE_URL env: $([ -n "$DATABASE_URL" ] && echo 'SET' || echo 'NOT SET')"

[ -n "$APP_KEY" ] && update_env "APP_KEY" "$APP_KEY"
[ -n "$APP_ENV" ] && update_env "APP_ENV" "$APP_ENV"
[ -n "$APP_DEBUG" ] && update_env "APP_DEBUG" "$APP_DEBUG"
[ -n "$APP_URL" ] && update_env "APP_URL" "$APP_URL"
[ -n "$LOG_LEVEL" ] && update_env "LOG_LEVEL" "$LOG_LEVEL"
[ -n "$DATABASE_URL" ] && update_env "DATABASE_URL" "$DATABASE_URL"

# Force production and debug mode
sed -i 's/^APP_ENV=.*/APP_ENV=production/' .env
sed -i 's/^APP_DEBUG=.*/APP_DEBUG=true/' .env

# Log what we have now
echo "[$(date)] .env APP_KEY after update:"
grep "^APP_KEY=" .env || echo "  APP_KEY NOT FOUND IN .env!"

# Ensure storage and bootstrap directories are writable
echo "[$(date)] Setting permissions..."
chmod -R 777 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# Clear old cache files
rm -rf bootstrap/cache/config.php
rm -rf storage/framework/cache/*

# Skip all caching - use fresh environment
echo "[$(date)] Skipping config and view caching - will use dynamic caching..."

# Test database connection
echo "[$(date)] Testing database connection..."
php artisan db:show --json 2>&1 || echo "Warning: Database test failed"

# Try to verify views directory
echo "[$(date)] Verifying views directory..."
ls -la storage/framework/views/ 2>/dev/null | head -5 || echo "No view cache yet"

echo "[$(date)] Starting PHP-FPM..."
php-fpm -D

echo "[$(date)] Starting Nginx..."
nginx -g "daemon off;"
EOF
RUN chmod +x /entrypoint.sh

EXPOSE 8080

ENTRYPOINT ["/entrypoint.sh"]
