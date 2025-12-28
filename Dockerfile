# Use official PHP with Apache
FROM php:8.1-apache

# Install PDO MySQL extension
RUN docker-php-ext-install pdo pdo_mysql

# Enable Apache mod_rewrite for .htaccess
RUN a2enmod rewrite

# Copy backend and frontend to Apache document root
COPY backend /var/www/html/backend
COPY frontend /var/www/html/frontend

# Set working directory
WORKDIR /var/www/html

# Update Apache config to allow .htaccess
RUN echo '<Directory /var/www/html/>\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>' > /etc/apache2/conf-available/override.conf \
    && a2enconf override

# Expose port 8080 (DigitalOcean App Platform requirement)
EXPOSE 8080

# Update Apache to listen on port 8080
RUN sed -i 's/80/8080/g' /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf

# Start Apache
CMD ["apache2-foreground"]
