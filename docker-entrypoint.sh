#!/bin/bash

set -e

echo "Waiting for MySQL to be ready..."
until mysql -h "$DB_HOST" -u "$DB_USERNAME" -p"$DB_PASSWORD" -e "SELECT 1" > /dev/null 2>&1; do
  sleep 2
done
echo "MySQL is ready."

echo "Generating application key if needed..."
php artisan key:generate --force

echo "Running database migrations..."
php artisan migrate --force

echo "Caching configurations..."
php artisan config:cache
php artisan view:cache
php artisan route:cache

echo "Setting permissions..."
chmod -R 775 storage bootstrap/cache
chmod -R 755 public

echo "Starting Apache..."
exec apache2-foreground