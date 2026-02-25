FROM wordpress:6.4-apache

# Force Apache to use only prefork MPM
RUN rm -f /etc/apache2/mods-enabled/mpm_event.load \
    && rm -f /etc/apache2/mods-enabled/mpm_worker.load \
    && a2enmod mpm_prefork

# Copy plugin
COPY wordpress/wp-content/plugins/iot-portal \
/var/www/html/wp-content/plugins/iot-portal

EXPOSE 80