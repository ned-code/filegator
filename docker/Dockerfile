FROM php:7.3-apache


RUN apt-get update && apt-get install --yes curl git libmcrypt-dev libreadline-dev libzip-dev

### Install Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php \
    && php -r "unlink('composer-setup.php');" \
    && mv composer.phar /usr/bin/composer \
    && chmod +x /usr/bin/composer

### Installl Node
RUN curl -sL https://deb.nodesource.com/setup_10.x | bash
RUN apt-get install --yes nodejs


ENV APACHE_DOCUMENT_ROOT /var/www/app/dist

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

WORKDIR /var/www/app


COPY composer.* ./
RUN composer install --ignore-platform-reqs

COPY package*.json ./
RUN npm install

COPY . .

RUN npm run build

RUN chmod -R 775 private/ \
&& chmod -R 775 repository/

EXPOSE 8080 8081
CMD [ "npm", "run", "serve" ]