# Base image
FROM php:8.2-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpq-dev \
    libzip-dev \
    zip unzip git curl

# Install Node.js + npm (official way, Node 20 LTS)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Enable PHP extensions
RUN docker-php-ext-install pdo pdo_pgsql zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set workdir
WORKDIR /var/www

# Copy the whole project into the container
COPY . .

# (Optional) Install composer dependencies during build
# RUN composer install --no-dev --optimize-autoloader

# Default command for artisan serve
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
