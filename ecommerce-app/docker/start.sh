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

echo "==> Installing Passport keys..."
php artisan passport:install --force

echo "==> Converting Passport keys to RSA format..."
openssl rsa -in storage/oauth-private.key -out storage/oauth-private.key 2>/dev/null || true
openssl rsa -in storage/oauth-private.key -pubout -out storage/oauth-public.key 2>/dev/null || true

echo "==> Setting storage permissions..."
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

echo "==> Fixing Passport key permissions..."
chmod 600 storage/oauth-private.key
chmod 600 storage/oauth-public.key

echo "==> Starting services..."
exec supervisord -c /etc/supervisord.conf
