FROM php:8.3-fpm-alpine

# Install dependencies
RUN apk add --no-cache \
    postgresql-dev \
    libzip-dev \
    zip \
    unzip

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_pgsql zip

# Set working directory
WORKDIR /var/www

# Expose port for php-fpm
EXPOSE 9000

# Start php-fpm
CMD ["php-fpm"]
