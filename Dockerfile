FROM wordpress:latest

COPY wordpress/wp-content/plugins/iot-portal \
/var/www/html/wp-content/plugins/iot-portal