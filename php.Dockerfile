FROM node:latest AS node
FROM php:8.2-apache

COPY --from=node /usr/local/lib/node_modules /usr/local/lib/node_modules
COPY --from=node /usr/local/bin/node /usr/local/bin/node
RUN ln -s /usr/local/lib/node_modules/npm/bin/npm-cli.js /usr/local/bin/npm

RUN apt-get update && apt-get install -y libicu-dev git zip \
    && pecl install xdebug \
    && docker-php-ext-install pdo pdo_mysql mysqli \
	&& docker-php-ext-enable xdebug \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl \
    && a2enmod rewrite

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer