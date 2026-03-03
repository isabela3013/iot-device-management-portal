FROM wordpress:php8.2-apache

# Copy plugin
COPY wordpress/wp-content/plugins/iot-portal \
/var/www/html/wp-content/plugins/iot-portal

RUN chown -R www-data:www-data /var/www/html

EXPOSE 80

# Fix Apache modules at runtime
CMD bash -c "\
a2dismod mpm_event || true && \
a2dismod mpm_worker || true && \
a2enmod mpm_prefork && \
apache2-foreground"
