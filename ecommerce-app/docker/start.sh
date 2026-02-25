#!/bin/sh

cd /var/www/html

echo "==> Production Optimization: Caching config, routes, and views..."
# We clear first to ensure fresh state, then cache
php artisan config:clear
php artisan route:clear
php artisan view:clear

php artisan config:cache
php artisan route:cache
php artisan view:cache

# echo "==> Running migrations (DISABLED for performance)..."
# php artisan migrate --force

# echo "==> Seeding database (DISABLED for performance)..."
# php artisan db:seed --force

# echo "==> Installing Passport (DISABLED- Keys should be persistent)..."
# php artisan passport:install --force

echo "==> Fixing permissions..."
chmod -R 775 storage bootstrap/cache

echo "==> Starting FrankenPHP server on port 8080..."
# FrankenPHP handles its own execution from the Docker CMD, 
# but we can trigger any last minute setup here if needed.
# For FrankenPHP with the default binary, we just exit this script 
# and let the Docker CMD take over, or we run the binary here.

exec frankenphp run --config /etc/caddy/Caddyfile --adapter caddyfile
