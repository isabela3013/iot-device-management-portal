FROM wordpress:latest

RUN a2dismod mpm_event || true
RUN a2enmod mpm_prefork

COPY wordpress/wp-content/plugins/iot-portal \
/var/www/html/wp-content/plugins/iot-portal