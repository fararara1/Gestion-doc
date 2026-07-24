#!/bin/bash
set -e

if [ -n "$DATABASE_URL" ]; then
    export DB_CONNECTION="pgsql"
    export DB_USERNAME=$(echo "$DATABASE_URL" | sed -n 's|^postgres://\([^:]*\):.*|\1|p')
    export DB_PASSWORD=$(echo "$DATABASE_URL" | sed -n 's|^postgres://[^:]*:\([^@]*\)@.*|\1|p')
    export DB_HOST=$(echo "$DATABASE_URL" | sed -n 's|^postgres://[^@]*@\([^:]*\):.*|\1|p')
    export DB_PORT=$(echo "$DATABASE_URL" | sed -n 's|^postgres://[^:]*:[^@]*@[^:]*:\([^/]*\)/.*|\1|p')
    export DB_DATABASE=$(echo "$DATABASE_URL" | sed -n 's|^postgres://[^/]*/\(.*\)$|\1|p')
fi

echo "Waiting for database..."
until php -r "try { new PDO('pgsql:host=${DB_HOST:-postgres};port=${DB_PORT:-5432};dbname=${DB_DATABASE}', '${DB_USERNAME}', '${DB_PASSWORD}'); exit(0); } catch(Exception \$e) { exit(1); }" > /dev/null 2>&1; do
  sleep 2
done
echo "Database ready."

php /var/www/html/artisan key:generate --force
php /var/www/html/artisan migrate --force
php /var/www/html/artisan config:cache
php /var/www/html/artisan view:cache
php /var/www/html/artisan route:cache

chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 755 /var/www/html/public

exec apache2-foreground