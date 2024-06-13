FROM php:8.3-cli

RUN apt-get update \
    && apt-get -y install git \
    nano \
    unzip \
    git \
    curl

RUN pecl install xdebug-3.3.2 \
	&& docker-php-ext-enable xdebug

RUN echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer