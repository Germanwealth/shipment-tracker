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

# Copy env file
COPY .env.example .env

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

# Override APP_KEY from environment if set (MUST be before config:cache)
if [ -n "$APP_KEY" ]; then
  echo "[$(date)] Setting APP_KEY from environment variable..."
  sed -i "s|^APP_KEY=.*|APP_KEY=$APP_KEY|" .env
fi

# Override DATABASE_URL from environment if set (MUST be before config:cache)
if [ -n "$DATABASE_URL" ]; then
  echo "[$(date)] Setting DATABASE_URL from environment variable..."
  sed -i "s|^DATABASE_URL=.*|DATABASE_URL=$DATABASE_URL|" .env
fi

# Set production mode
echo "[$(date)] Configuring production environment..."
sed -i 's/^APP_ENV=.*/APP_ENV=production/' .env
sed -i 's/^APP_DEBUG=.*/APP_DEBUG=true/' .env

# Ensure storage and bootstrap directories are writable
echo "[$(date)] Setting permissions..."
chmod -R 777 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# Clear any old cache files
rm -rf bootstrap/cache/config.php
rm -rf storage/framework/cache/*

# NOW cache config and views (AFTER environment variables are set)
echo "[$(date)] Caching configuration..."
php artisan config:cache 2>&1 || echo "Warning: Config cache failed"
echo "[$(date)] Caching views..."
php artisan view:cache 2>&1 || echo "Warning: View cache failed"

# Test database connection
echo "[$(date)] Testing database connection..."
php artisan db:show --json 2>&1 || echo "Warning: Database test failed (will retry on first request)"

# Try to run a simple Artisan command to check if everything works
echo "[$(date)] Running health check..."
php artisan route:list 2>&1 | head -5 || echo "Warning: Route list failed"

echo "[$(date)] Starting PHP-FPM..."
php-fpm -D

echo "[$(date)] Starting Nginx..."
nginx -g "daemon off;"
EOF
RUN chmod +x /entrypoint.sh

EXPOSE 8080

ENTRYPOINT ["/entrypoint.sh"]
