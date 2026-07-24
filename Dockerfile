FROM php:8.3-apache

RUN a2enmod rewrite

RUN apt-get update && apt-get install -y \
        libpq-dev \
        curl \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && docker-php-ext-install pdo_pgsql pgsql

COPY composer.json composer.lock package.json /var/www/html/
RUN cd /var/www/html && composer install --no-dev --optimize-autoloader --no-interaction
RUN cd /var/www/html && npm install && npm run build

COPY . /var/www/html

COPY fly-entrypoint.sh /usr/local/bin/fly-entrypoint.sh
RUN chmod +x /usr/local/bin/fly-entrypoint.sh

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache && \
    chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache && \
    chmod -R 755 /var/www/html/public

EXPOSE 8080

ENTRYPOINT ["fly-entrypoint.sh"]
CMD ["apache2-foreground"]