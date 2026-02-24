#!/bin/sh

cd /var/www/html

echo "==> Clearing config cache..."
php artisan config:clear

echo "==> Caching config, routes, and views..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "==> Setting storage permissions..."
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

echo "==> Starting services (php-fpm + nginx) via supervisord..."
exec supervisord -n -c /etc/supervisord.conf
