## this docker file is for building production container

## Stage 1 buld & install packages
FROM php:7.4-fpm

## installing neccessary packages
RUN apt-get update -y
RUN apt-get install -y curl
RUN apt-get install -y libpcre3-dev libzip-dev libpng-dev

## install pecl packages
RUN pecl install psr \
        && docker-php-ext-enable psr
RUN pecl install zip \
        && docker-php-ext-enable zip

## enabling PHP extensions
RUN docker-php-ext-install gd
RUN docker-php-ext-install curl
RUN docker-php-ext-install pdo

ADD ./ /code

WORKDIR /code
## download composer and install packages
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
        && php composer-setup.php && php -r "unlink('composer-setup.php');"
RUN php composer.phar install --no-dev

## clean up
RUN rm composer.phar .gitignore composer.json composer.lock phpunit.xml.dist symfony.lock
RUN rm -rf bin docker migrations tests




