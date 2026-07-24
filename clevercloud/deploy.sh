#!/bin/bash

# Clever Cloud Laravel deployment script

export LANG=C
export LC_ALL=C

echo "Starting Laravel deployment..."

# Install dependencies
echo "Installing Composer dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction

# Install NPM dependencies and build assets
echo "Installing NPM dependencies..."
npm install
echo "Building assets..."
npm run build

# Generate application key if not set
echo "Generating application key..."
php artisan key:generate --force

# Run database migrations
echo "Running database migrations..."
php artisan migrate --force

# Clear and cache configurations
echo "Caching configurations..."
php artisan config:cache
php artisan view:cache
php artisan route:cache

# Create symlink so Apache finds index.php at root
echo "Creating webroot symlink..."
ln -sf public/index.php index.php

# Set proper permissions
echo "Setting permissions..."
chmod -R 775 storage bootstrap/cache
chmod -R 755 public

echo "[OK] Laravel deployment completed successfully!"
