FROM php:7.2.10-apache-stretch

RUN apt-get update -yqq
RUN docker-php-ext-install mbstring tokenizer mysqli pdo_mysql

RUN php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer

COPY default.conf /etc/apache2/sites-enabled/000-default.conf

WORKDIR /var/www/app

CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]

EXPOSE 80