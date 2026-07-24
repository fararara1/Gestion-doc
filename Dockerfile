FROM php:8.3-apache

RUN a2enmod rewrite

COPY composer.json composer.lock /var/www/html/
RUN cd /var/www/html && composer install --no-dev --optimize-autoloader --no-interaction

COPY . /var/www/html

COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache && \
    chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache && \
    chmod -R 755 /var/www/html/public

EXPOSE 80

ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["apache2-foreground"]