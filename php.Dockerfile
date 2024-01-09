FROM node:latest AS node
FROM php:8.2-apache

COPY --from=node /usr/local/lib/node_modules /usr/local/lib/node_modules
COPY --from=node /usr/local/bin/node /usr/local/bin/node
RUN ln -s /usr/local/lib/node_modules/npm/bin/npm-cli.js /usr/local/bin/npm

RUN apt-get update && apt-get install -y libicu-dev git zip libpng-dev libmagickwand-dev --no-install-recommends \
    && pecl install xdebug imagick \
    && docker-php-ext-install pdo pdo_mysql mysqli intl gd \
	  && docker-php-ext-enable xdebug imagick \
    && docker-php-ext-configure intl \
    && a2enmod rewrite

ARG UID
ARG GID

ENV UID=${UID}
ENV GID=${GID}

RUN groupadd -g ${GID} php && \
    useradd -g php -u ${UID} -s /bin/sh -m php

RUN sed -i 's/export APACHE_RUN_USER=www-data/export APACHE_RUN_USER=php/g' /etc/apache2/envvars
RUN sed -i 's/export APACHE_RUN_GROUP=www-data/export APACHE_RUN_GROUP=php/g' /etc/apache2/envvars

USER php

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
