FROM wordpress:php8.2-apache

# Fix Apache MPM conflict (THIS is the real fix)
RUN a2dismod mpm_event || true
RUN a2dismod mpm_worker || true
RUN a2enmod mpm_prefork

# Copy WordPress files
COPY wordpress/ /var/www/html/

# Permissions
RUN chown -R www-data:www-data /var/www/html

# Apache config fix
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

EXPOSE 80

CMD ["apache2-foreground"]
