FROM wordpress:php8.2-apache

# Copy plugin
COPY wordpress/wp-content/plugins/iot-portal \
/var/www/html/wp-content/plugins/iot-portal

# Fix permissions
RUN chown -R www-data:www-data /var/www/html \
 && chmod -R 755 /var/www/html

# Fix apache directory permissions
RUN echo "<Directory /var/www/html>\n\
AllowOverride All\n\
Require all granted\n\
</Directory>" >> /etc/apache2/apache2.conf

EXPOSE 80

CMD bash -c "\
a2dismod mpm_event || true && \
a2dismod mpm_worker || true && \
a2enmod mpm_prefork && \
apache2-foreground"
