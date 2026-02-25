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

# Optional: Ensure Passport keys exist if they are not in environment
# We only do this if they are missing to avoid unnecessary overhead
if [ ! -f storage/oauth-private.key ]; then
    echo "==> Generating Passport keys..."
    php artisan passport:keys --force
fi

echo "==> Fixing permissions..."
chmod -R 775 storage bootstrap/cache

echo "==> Starting FrankenPHP server on port 8080..."
# Using php-server mode is the most robust way to serve Laravel with FrankenPHP
exec frankenphp php-server --listen :8080 --root public/
