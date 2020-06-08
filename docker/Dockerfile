FROM php:7.3-apache


RUN apt-get update && apt-get install --yes \
    curl \
    git \
    libasound2 \
    libgconf-2-4 \
    libgtk2.0-0 \
    libgtk-3-0 \
    libmcrypt-dev \
    libnotify-dev \
    libnss3 \
    libreadline-dev \
    libxss1 \
    libxtst6 \
    libzip-dev \
    xauth \
    xvfb \
    zip \
    && rm -rf /var/lib/apt/lists/*

### Install Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php \
    && php -r "unlink('composer-setup.php');" \
    && mv composer.phar /usr/bin/composer \
    && chmod +x /usr/bin/composer

### Install PHP extensions
RUN yes | pecl install xdebug \
    && echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_autostart=off" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_host=host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

RUN docker-php-ext-enable \
    xdebug

RUN docker-php-ext-install \
    zip

### Installl Node
RUN curl -sL https://deb.nodesource.com/setup_12.x | bash
RUN apt-get install --yes nodejs

### Change Document Root
ENV APACHE_DOCUMENT_ROOT /var/www/app/dist

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

WORKDIR /var/www/app

### Install dependencies
COPY composer.* ./
RUN composer install --ignore-platform-reqs

COPY package*.json ./
RUN npm install

COPY . .

RUN chmod -R 775 private/ \
    && chmod -R 775 repository/

RUN npm run build

EXPOSE 80