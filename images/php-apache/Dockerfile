FROM php:8.0-apache
RUN apt-get update
RUN docker-php-ext-install mysqli

RUN apt-get install apache2-utils -y
RUN apt-get install libaprutil1-dbd-mysql -y
RUN a2enmod dbd
RUN a2enmod authn_dbd