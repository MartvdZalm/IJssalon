# Use the official PHP 8.0 Apache image as the base image
FROM php:8.0-apache

# Enable mod_rewrite
RUN a2enmod rewrite

# Enable pdo
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Set the working directory to the app directory
WORKDIR /var/www/html

# Set the document root to the root directory of the project
ENV DOCUMENT_ROOT /var/www/html

# Copy the app files to the container
COPY . .

# Expose port 80
EXPOSE 80
