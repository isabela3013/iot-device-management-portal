FROM wordpress:php8.2-apache

# Copy FULL wordpress installation
COPY wordpress/ /var/www/html/

# Fix permissions
RUN chown -R www-data:www-data /var/www/html \
 && chmod -R 755 /var/www/html

EXPOSE 80
