# Use official PHP image with Apache
FROM php:8.3.19-apache

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    mariadb-client \
    && docker-php-ext-install pdo_mysql mysqli \
    && a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . /var/www/html/

# Make sure upload directory exists and is writable by www-data
RUN mkdir -p /var/www/html/src/uploads/products \
    && chown -R www-data:www-data /var/www/html/src/uploads \
    && chmod -R 755 /var/www/html/src/uploads

# Expose port 80
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
