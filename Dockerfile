FROM wordpress:6.4-apache
COPY wordpress/wp-content/plugins/iot-portal \
/var/www/html/wp-content/plugins/iot-portal
EXPOSE 80