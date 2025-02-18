FROM php:8.2-fpm

# Install dependencies and extensions
RUN apt-get update && apt-get install -y \
  git \
  curl \
  libpng-dev \
  libjpeg-dev \
  libfreetype6-dev \
  libzip-dev \
  libpq-dev \
  procps \
  unzip \
  && docker-php-ext-configure gd --with-freetype --with-jpeg \
  && docker-php-ext-install gd zip pdo pdo_pgsql pdo_mysql

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www

# Copy ALL application code FIRST
COPY . .

# # Install project dependencies - this will now work correctly
# RUN composer install --no-interaction --no-dev --optimize-autoloader

# Set correct permissions for storage and bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache && chown -R www-data:www-data storage bootstrap/cache

# Start PHP-FPM
CMD ["php-fpm"]