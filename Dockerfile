FROM php:8.4-alpine3.23

ENV USERNAME=www-data

WORKDIR /var/www/html

# install composer
COPY --chown=${USERNAME}:${USERNAME} --from=composer:latest /usr/bin/composer /usr/local/bin/composer

COPY . /var/www/html
RUN composer install --optimize-autoloader --no-interaction --no-progress --no-dev
CMD cd /var/www/html && php -S 0.0.0.0:8080 -t public public/index.php

EXPOSE 8080