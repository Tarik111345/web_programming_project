# Use official PHP with Apache
FROM php:8.1-apache

# Install PDO MySQL extension
RUN docker-php-ext-install pdo pdo_mysql

# Enable Apache mod_rewrite for .htaccess
RUN a2enmod rewrite

# Copy backend and frontend to Apache document root
COPY backend /var/www/html/backend
COPY frontend /var/www/html/frontend

# Copy Apache configuration
COPY apache-config.conf /etc/apache2/sites-available/000-default.conf

# Update ports.conf to listen on 8080
RUN sed -i 's/Listen 80/Listen 8080/g' /etc/apache2/ports.conf

# Set working directory
WORKDIR /var/www/html

# Expose port 8080 (DigitalOcean App Platform requirement)
EXPOSE 8080

# Start Apache
CMD ["apache2-foreground"]