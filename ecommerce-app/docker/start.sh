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

echo "==> Installing Passport..."
php artisan passport:install --force

echo "==> Fixing permissions..."
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache
chmod 600 storage/oauth-private.key
chmod 600 storage/oauth-public.key

echo "==> Starting services..."
exec supervisord -c /etc/supervisord.conf
```

### Update Railway Variables

Go to Railway → ecommerce service → **Variables** → set:
```
PORT = 8080
