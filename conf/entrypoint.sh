#!/usr/bin/env bash
set -e

echo "=== Starting Gurunanak Cloth House on Render ==="

# Prepare database and storage
mkdir -p /var/www/html/database /var/www/html/storage/framework/sessions /var/www/html/storage/framework/views /var/www/html/storage/framework/cache /var/www/html/storage/logs
touch /var/www/html/database/database.sqlite
chown -R www-data:www-data /var/www/html/database /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/database /var/www/html/storage /var/www/html/bootstrap/cache

# Bootstrap Laravel
php artisan package:discover --ansi || true
php artisan storage:link || true
php artisan migrate --force || true
php artisan db:seed --force || true
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

echo "=== Launching Apache Server ==="
exec apache2-foreground
