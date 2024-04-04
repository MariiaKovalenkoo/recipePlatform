FROM php:fpm

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install Xdebug
RUN pecl install xdebug && docker-php-ext-enable xdebug

# Copy Xdebug configuration
COPY ./xdebug.ini "${PHP_INI_DIR}/conf.d"
