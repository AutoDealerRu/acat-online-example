FROM php:7.2-alpine

COPY . /var/www/html
RUN cd /var/www/html && php ./composer.phar install --no-dev
CMD cd /var/www/html && php -S 0.0.0.0:8080 -t public public/index.php

EXPOSE 8080