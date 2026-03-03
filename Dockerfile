FROM wordpress:php8.2-apache

# Fix Apache conflict
RUN a2dismod mpm_event || true \
 && a2dismod mpm_worker || true \
 && a2enmod mpm_prefork \
 && echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Copy only plugin
COPY wordpress/wp-content/plugins/iot-portal \
/var/www/html/wp-content/plugins/iot-portal

EXPOSE 80

CMD ["apache2-foreground"]
