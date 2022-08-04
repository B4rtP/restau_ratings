FROM php:8.1.8-apache
WORKDIR /var/www/html
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
RUN apt-get update -y && apt-get install -y \
git \
zip \
unzip \
libmariadb-dev \
libpng-dev \
libfreetype6-dev \
libjpeg62-turbo-dev \
libpng-dev \
wget \
curl \
&& docker-php-ext-configure gd --with-freetype --with-jpeg \
&& docker-php-ext-install -j$(nproc) gd
RUN docker-php-ext-install pdo_mysql && a2enmod rewrite
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug