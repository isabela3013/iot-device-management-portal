FROM wordpress:php8.2-apache

COPY wordpress/wp-content/plugins/iot-portal \
/var/www/html/wp-content/plugins/iot-portal

RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
