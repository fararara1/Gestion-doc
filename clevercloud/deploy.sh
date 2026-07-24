#!/bin/bash

# Clever Cloud Laravel deployment script

# Install dependencies
composer install --no-dev --optimize-autoloader --no-interaction

# Install NPM dependencies and build assets
npm install
npm run build

# Generate application key if not set
php artisan key:generate --force

# Run database migrations
php artisan migrate --force

# Clear and cache configurations
php artisan config:cache
php artisan view:cache
php artisan route:cache

# Set proper permissions
chmod -R 775 storage bootstrap/cache
chmod -R 755 public

echo "✅ Laravel deployment completed successfully!"
