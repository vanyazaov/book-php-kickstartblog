FROM php:5.4.39-cli

RUN echo "deb http://archive.debian.org/debian/ jessie main" > /etc/apt/sources.list \
 && echo "deb http://archive.debian.org/debian-security jessie/updates main" >> /etc/apt/sources.list

RUN apt-get update -o Acquire::Check-Valid-Until=false \
 && apt-get install -y --allow-unauthenticated libmysqlclient-dev ca-certificates wget \
 && update-ca-certificates --fresh

# Создаём директорию для конфигов PHP
RUN mkdir -p /usr/local/etc/php/conf.d

# pdo_mysql
RUN cd /usr/src/php/ext/pdo_mysql \
 && phpize \
 && ./configure --with-pdo-mysql=/usr \
 && make && make install \
 && echo "extension=pdo_mysql.so" > /usr/local/etc/php/conf.d/pdo_mysql.ini

# mysql (старое расширение)
RUN cd /usr/src/php/ext/mysql \
 && phpize \
 && ./configure --with-mysql=/usr \
 && make && make install \
 && echo "extension=mysql.so" > /usr/local/etc/php/conf.d/mysql.ini

# zip
RUN cd /usr/src/php/ext/zip \
 && phpize \
 && ./configure \
 && make && make install \
 && echo "extension=zip.so" > /usr/local/etc/php/conf.d/zip.ini


# Рабочая директория
WORKDIR /var/www/html
