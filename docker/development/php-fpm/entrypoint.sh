#!/bin/sh
set -e

# 1. Comment out the chown line. 
# Windows handles these permissions differently, so this is unnecessary and slow.
# echo "Fixing file permissions..."
# chown -R ${UID:-1000}:${GID:-1000} /var/www || echo "Some files could not be changed"

# 2. Keep the cache clearing (useful for Laravel)
echo "Clearing configurations..."
php artisan config:clear || echo "Artisan not found yet, skipping..."
php artisan route:clear || echo "Artisan not found yet, skipping..."
php artisan view:clear || echo "Artisan not found yet, skipping..."

# 3. This is the most important part! 
# It runs whatever command comes from docker-compose (usually php-fpm)
exec "$@"