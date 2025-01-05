FROM php:8.1-apache

RUN docker-php-ext-install pdo_mysql

# DocumentRoot를 /var/www/html/public으로 변경
RUN sed -i 's#/var/www/html#/var/www/html/public#' /etc/apache2/sites-available/000-default.conf

COPY . /var/www/html

EXPOSE 80
CMD ["apache2-foreground"]
