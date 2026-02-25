#!/bin/sh

cd /var/www/html

echo "==> Production Optimization: Caching config, routes, and views..."
php artisan config:clear
php artisan route:clear
php artisan view:clear

php artisan config:cache
php artisan route:cache
php artisan view:cache

# echo "==> Running migrations (DISABLED for performance)..."
# php artisan migrate --force

echo "==> Fixing permissions..."
chmod -R 775 storage bootstrap/cache

echo "==> Starting FrankenPHP server on port 8080..."
exec frankenphp run --config /etc/caddy/Caddyfile --adapter caddyfile
