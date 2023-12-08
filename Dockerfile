FROM php:7.2-apache

# Instalação do SQLite e PDO SQLite
RUN apt-get update && \
    apt-get install -y libsqlite3-dev && \
    docker-php-ext-install pdo_sqlite

# Instalação do driver MySQLi
RUN docker-php-ext-install mysqli

# Instalação do Xdebug
RUN pecl install xdebug && docker-php-ext-enable xdebug

# Configuração do Xdebug
RUN echo "xdebug.remote_enable=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_autostart=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.coverage_enable=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# Instalação do Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Limpeza de pacotes não necessários
RUN apt-get clean && \
    rm -rf /var/lib/apt/lists/*
