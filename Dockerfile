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

echo "[$(date)] Starting Shipment Tracker on Railway..."
echo "[$(date)] Working directory: $(pwd)"

# Copy .env.example to .env if .env doesn't exist
if [ ! -f .env ]; then
  echo "[$(date)] Creating .env from .env.example..."
  cp .env.example .env
fi

# Ensure we're using the correct key
echo "[$(date)] Setting explicit APP_KEY from base64 encoded value..."
APP_KEY="base64:Uqw/jLJ3C0l7X9vF8pQ2R4sT5uV6wX7yZ8aB9cD0eF1gH2iJ3kL4mN5oP6qR7sT8u="
sed -i "s|^APP_KEY=.*|APP_KEY=$APP_KEY|" .env

# Also set from environment if Railway provides it (override if needed)
if [ -n "$RAILWAY_APP_KEY" ]; then
  echo "[$(date)] Using Railway-provided APP_KEY from RAILWAY_APP_KEY..."
  sed -i "s|^APP_KEY=.*|APP_KEY=$RAILWAY_APP_KEY|" .env
fi

# Ensure .env has these critical settings
echo "[$(date)] Setting production environment variables..."
sed -i 's/^APP_ENV=.*/APP_ENV=production/' .env || echo "APP_ENV=production" >> .env
sed -i 's/^APP_DEBUG=.*/APP_DEBUG=false/' .env || echo "APP_DEBUG=false" >> .env

# Override database URL from Railway environment if set
if [ -n "$DATABASE_URL" ]; then
  echo "[$(date)] Using Railway DATABASE_URL..."
  sed -i "s|^DATABASE_URL=.*|DATABASE_URL=$DATABASE_URL|" .env || echo "DATABASE_URL=$DATABASE_URL" >> .env
fi

# Log the critical settings (don't log the actual key!)
echo "[$(date)] Critical settings:"
grep "^APP_ENV=" .env || echo "  APP_ENV not found"
grep "^APP_DEBUG=" .env || echo "  APP_DEBUG not found"
grep "^APP_KEY=" .env | sed 's/=.*$/=***/' || echo "  APP_KEY not found"
grep "^DATABASE_" .env | head -1 || echo "  DATABASE not found"

# Ensure storage and bootstrap directories are writable
echo "[$(date)] Setting permissions..."
chmod -R 777 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# Clear any old cache files that might have wrong keys
echo "[$(date)] Clearing old cache files..."
rm -rf bootstrap/cache/*
rm -rf storage/framework/cache/*
rm -rf storage/framework/views/*

echo "[$(date)] Starting PHP-FPM..."
php-fpm -D

echo "[$(date)] Starting Nginx..."
nginx -g "daemon off;"
EOF
RUN chmod +x /entrypoint.sh

EXPOSE 8080

ENTRYPOINT ["/entrypoint.sh"]
