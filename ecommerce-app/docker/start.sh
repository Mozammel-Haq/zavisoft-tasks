#!/bin/sh
set -e

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

echo "==> Installing Passport..."
php artisan passport:install --force

echo "==> Fixing Passport key permissions..."
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache
chmod 600 storage/oauth-private.key
chmod 600 storage/oauth-public.key

echo "==> Configuring nginx port..."
envsubst '${PORT}' < /etc/nginx/nginx.conf > /tmp/nginx-final.conf
cp /tmp/nginx-final.conf /etc/nginx/nginx.conf

echo "==> Starting services..."
exec supervisord -c /etc/supervisord.conf
```

---

Also add `PORT` to Railway environment variables:

Go to Railway → ecommerce service → **Variables** → add:
```
PORT = 8000
