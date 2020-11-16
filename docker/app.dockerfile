FROM php:7.4-fpm-alpine

RUN apk update && apk upgrade
RUN apk add --no-cache mariadb-client
RUN apk add --no-cache composer
RUN apk add --no-cache nodejs npm
RUN apk add --no-cache bash

# using mlocati/php-extension-installer to simplifiy php extension installation for all php version
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/bin/
RUN install-php-extensions opcache pdo_mysql pcntl zip


