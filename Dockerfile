# Use the official PHP Apache image
FROM php:8.2-apache

# Install PDO and MySQL driver extensions for database connectivity
RUN docker-php-ext-install pdo pdo_mysql

# Enable the Apache rewrite module
RUN a2enmod rewrite

# Update Apache configuration to change DocumentRoot to /public.
# This keeps private app files protected from direct HTTP access.
ENV APACHE_DOCUMENT_ROOT=/var/www/html

# Explicitly set the hostname to avoid the default "Could not reliably determine the server's fully qualified domain name" warning.
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Rewrite the default Apache config to the public directory at build time.
RUN sed -ri -e "s!/var/www/html!${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/sites-available/*.conf
RUN sed -ri -e "s!/var/www/html!${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
