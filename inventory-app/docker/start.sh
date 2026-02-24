#!/bin/sh

cd /var/www/html

echo "==> Clearing config cache..."
php artisan config:clear

echo "==> Caching config, routes, and views..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "==> Running migrations..."
php artisan migrate --force

echo "==> Seeding database..."
php artisan db:seed --force

echo "==> Setting storage permissions..."
chmod -R 775 storage bootstrap/cache

echo "==> Starting Laravel server on port 8080..."
php artisan serve --host=0.0.0.0 --port=8080
