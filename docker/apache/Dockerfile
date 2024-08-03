FROM php:8.2-apache

RUN apt-get update && apt-get install -y curl \
    && docker-php-ext-install pdo pdo_mysql \
    && docker-php-ext-enable pdo_mysql \
    && a2enmod rewrite

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY . .


WORKDIR /var/www/html

EXPOSE 80

CMD ["apache2-foreground"]