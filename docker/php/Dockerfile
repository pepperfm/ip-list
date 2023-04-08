FROM php:7.4-fpm

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive

ARG DOCKER_GROUP_ID
ARG DOCKER_USER_ID

USER root

RUN usermod -u ${DOCKER_USER_ID} -d /var/www/ip-list www-data && \
    groupmod -g ${DOCKER_GROUP_ID} www-data

# Fix user permissions
RUN mkdir -p /var/www/ip-list

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN chown www-data:www-data /usr/local/bin && \
    chmod 755 /usr/local/bin

RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        zip \
        unzip \
    && docker-php-ext-install mysqli pdo pdo_mysql exif

# Install selected extensions and other stuff
RUN apt-get update \
    && apt-get -y --no-install-recommends install php-memcached \
        php7.4-mysql php7.4-pgsql php7.4-pdo php7.4-pdo_mysql php-redis php7.4-sqlite3 php-xdebug \
        php7.4-bcmath php7.4-bz2 php7.4-dba \
        php7.4-enchant php7.4-gd php7.4-gmp php-igbinary php-imagick php7.4-imap \
        php7.4-intl php7.4-ldap php-mongodb php-msgpack php7.4-soap php-ssh2 \
        php7.4-sybase php-tideways php7.4-tidy php7.4-xmlrpc php7.4-xsl \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

COPY --chown=www-data:www-data composer.json composer.json

RUN composer i \
   --no-interaction \
   --no-plugins \
   --no-scripts \
   --prefer-dist

RUN chown -R www-data:www-data /var/www && chmod 755 /var/www

USER www-data

RUN composer i \
   --no-interaction \
   --no-plugins \
   --no-scripts \
   --prefer-dist

COPY --chown=www-data:www-data . .

RUN composer dump-autoload

RUN php artisan key:generate
RUN php artisan storage:link

CMD [ "php-fpm" ]
