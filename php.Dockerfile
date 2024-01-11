FROM node:latest AS node
FROM php:8.2-apache

COPY --from=node /usr/local/lib/node_modules /usr/local/lib/node_modules
COPY --from=node /usr/local/bin/node /usr/local/bin/node
RUN ln -s /usr/local/lib/node_modules/npm/bin/npm-cli.js /usr/local/bin/npm

ARG UNAME=www-data
ARG UGROUP=www-data
ARG UID
ARG GID

ENV UID=${UID}
ENV GID=${GID}

RUN apt-get update && apt-get install -y libicu-dev git zip libpng-dev libmagickwand-dev --no-install-recommends \
    && pecl install xdebug imagick \
    && docker-php-ext-install pdo pdo_mysql mysqli intl gd \
	  && docker-php-ext-enable xdebug imagick \
    && docker-php-ext-configure intl \
    && a2enmod rewrite \
    && usermod  --uid $UID $UNAME \
    && groupmod --gid $GID $UGROUP

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
