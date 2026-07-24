#!/bin/bash

# Clever Cloud Laravel deployment script

export LANG=C
export LC_ALL=C

echo "Starting Laravel deployment..."

echo "Installing Composer dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction > /dev/null 2>&1

echo "Installing NPM dependencies..."
npm install > /dev/null 2>&1
echo "Building assets..."
npm run build > /dev/null 2>&1

echo "Generating application key..."
php artisan key:generate --force > /dev/null 2>&1

echo "Running database migrations..."
php artisan migrate --force > /dev/null 2>&1

echo "Caching configurations..."
php artisan config:cache > /dev/null 2>&1
php artisan view:cache > /dev/null 2>&1
php artisan route:cache > /dev/null 2>&1

echo "Creating webroot symlink..."
ln -sf public/index.php index.php

echo "Setting permissions..."
chmod -R 775 storage bootstrap/cache
chmod -R 755 public

echo "[OK] Laravel deployment completed successfully!"