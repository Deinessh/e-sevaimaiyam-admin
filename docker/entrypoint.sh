#!/bin/sh
set -e

# Dynamically set Apache listening port to match Render's $PORT environment variable
PORT=${PORT:-80}
sed -i "s/Listen 80/Listen ${PORT}/g" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:80>/<VirtualHost \*:${PORT}>/g" /etc/apache2/sites-available/000-default.conf

# Ensure .env file exists
if [ ! -f /var/www/html/.env ]; then
    if [ -f /var/www/html/.env.example ]; then
        cp /var/www/html/.env.example /var/www/html/.env
    else
        touch /var/www/html/.env
    fi
fi

# Ensure required storage and cache directories exist
mkdir -p /var/www/html/storage/framework/cache/data \
         /var/www/html/storage/framework/sessions \
         /var/www/html/storage/framework/views \
         /var/www/html/storage/logs \
         /var/www/html/bootstrap/cache \
         /var/www/html/database \
         /var/www/html/public/uploads

# Ensure SQLite database file exists
touch /var/www/html/database/database.sqlite

# Set correct ownership and permissions for Apache (www-data)
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database /var/www/html/public/uploads
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database /var/www/html/public/uploads

# Generate application key if not set
if ! grep -q "APP_KEY=base64:" /var/www/html/.env || [ -z "$APP_KEY" ]; then
    php artisan key:generate --force || true
fi

# Run database migrations automatically
php artisan migrate --force || true

# Execute passed command (default: apache2-foreground)
exec "$@"
