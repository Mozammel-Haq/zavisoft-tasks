#!/bin/sh

cd /var/www/html

echo "==> Production Optimization: Caching config, routes, and views..."
php artisan config:clear
php artisan route:clear
php artisan view:clear

php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "==> Fixing permissions..."
chmod -R 775 storage bootstrap/cache

echo "==> Starting FrankenPHP server on port 8080..."
# Using php-server mode is the most robust way to serve Laravel with FrankenPHP
exec frankenphp php-server --listen :8080 --root public/
