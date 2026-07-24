#!/bin/bash
set -e

echo "Waiting for MySQL..."
until mysql -h "$DB_HOST" -u "$DB_USERNAME" -p"$DB_PASSWORD" -e "SELECT 1" > /dev/null 2>&1; do
  sleep 2
done
echo "MySQL ready."

php /var/www/html/artisan key:generate --force
php /var/www/html/artisan migrate --force
php /var/www/html/artisan config:cache
php /var/www/html/artisan view:cache
php /var/www/html/artisan route:cache

chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 755 /var/www/html/public

exec apache2-foreground