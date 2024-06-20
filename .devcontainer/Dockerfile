FROM php:8.3-cli

RUN apt-get update \
    && apt-get -y install git \
    nano \
    unzip \
    git \
    curl \
    zsh

# Installer oh-my-zsh
RUN sh -c "$(curl -fsSL https://raw.githubusercontent.com/ohmyzsh/ohmyzsh/master/tools/install.sh)" "" --unattended

# Changer le shell par défaut en zsh
RUN chsh -s $(which zsh)

# Exposer le shell zsh
CMD ["zsh"]

RUN pecl install xdebug-3.3.2 \
	&& docker-php-ext-enable xdebug

RUN echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer