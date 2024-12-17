# Use an official PHP image with Composer and Node.js pre-installed
FROM php:8.2-cli

# Set environment variables
ENV DEBIAN_FRONTEND=noninteractive

# Install system dependencies, Node.js, and PHP extensions required by Laravel
RUN apt-get update && apt-get install -y \
    curl \
    git \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    zip \
    npm \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    # Configure and install GD with JPEG and FreeType support
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd \
    # Clean up to reduce image size
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Set working directory
WORKDIR /var/www/

# Copy application files (from the local directory to the working directory)
COPY ./ /var/www/

# Install Composer and PHP dependencies
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer
RUN composer install --optimize-autoloader --no-dev

# Install Node.js dependencies
RUN npm install && npm run build

# Set permissions for Laravel storage and cache directories
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
RUN chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Copy the deployment script and set executable permission
COPY deploy.sh /var/www/deploy.sh
RUN chmod +x /var/www/deploy.sh

# Set the entrypoint to the start script
CMD ["/var/www/deploy.sh"]
