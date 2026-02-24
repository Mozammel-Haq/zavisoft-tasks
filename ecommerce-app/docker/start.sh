#!/bin/sh
set -e

cd /var/www/html

echo "==> Clearing any old cache..."
php artisan config:clear
php artisan cache:clear

echo "==> Caching config, routes, and views..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "==> Running migrations..."
php artisan migrate --force

echo "==> Seeding database..."
php artisan db:seed --force

echo "==> Installing Passport..."
php artisan passport:install --force

echo "==> Fixing Passport key permissions..."
chmod 600 storage/oauth-private.key
chmod 600 storage/oauth-public.key

echo "==> Setting storage permissions..."
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

echo "==> Starting services..."
exec supervisord -c /etc/supervisord.conf
