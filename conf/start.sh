#!/usr/bin/env bash
set -e

echo "=== Starting Gurunanak Cloth House on Render ==="

# Ensure storage directories exist and have permissions
mkdir -p /var/www/html/storage/framework/sessions \
         /var/www/html/storage/framework/views \
         /var/www/html/storage/framework/cache \
         /var/www/html/storage/logs
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# If SQLite is used or no external DB provided, ensure sqlite file exists
if [ "$DB_CONNECTION" = "sqlite" ] || ([ -z "$DB_CONNECTION" ] && [ -z "$DATABASE_URL" ]); then
    mkdir -p /var/www/html/database
    touch /var/www/html/database/database.sqlite
    chown -R www-data:www-data /var/www/html/database
    chmod -R 775 /var/www/html/database
fi

# Link storage
php artisan storage:link || true

# Run database migrations
echo "Running database migrations..."
php artisan migrate --force || true

# Seed required initial tables (admin user, products, store settings, sections)
echo "Running database seeders..."
php artisan db:seed --force || true

# Clear and rebuild caches
echo "Optimizing Laravel configuration, routes, and views..."
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

echo "=== Launching Nginx & PHP-FPM ==="
exec /usr/bin/supervisord -c /etc/supervisord.conf
