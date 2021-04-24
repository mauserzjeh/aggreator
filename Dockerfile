FROM php:7.4-fpm

# Copy composer.lock and composer.json
COPY composer.lock composer.json /var/www/

# Set working directory
WORKDIR /var/www

# Install dependencies
RUN apt-get update && apt-get install -y \
	build-essential \
    curl \
    git gifsicle \ 
    jpegoptim \
    libfreetype6-dev libjpeg62-turbo-dev libonig-dev libpng-dev libxml2-dev libzip-dev locales \
    nginx \
    optipng \
    pngquant \
    unzip \
    vim \ 
    zip

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl
RUN docker-php-ext-configure gd \
    --enable-gd \
    --with-freetype=/usr/include/ \
    --with-jpeg=/usr/include/
RUN docker-php-ext-install gd

ARG WITH_XDEBUG=false
RUN if [ $WITH_XDEBUG = "true" ]; then \
    pecl install xdebug; \
    docker-php-ext-enable xdebug; \
    echo "error_reporting = E_ALL" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
    echo "display_startup_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
    echo "display_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
    echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
    echo "xdebug.discover_client_host = 1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
    echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
    fi;

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Add user for application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Copy existing application directory contents
COPY . /var/www

# Copy nginx config files
COPY ./nginx/nginx.conf /etc/nginx/nginx.conf
COPY ./nginx/conf.d/default.conf /etc/nginx/conf.d/default.conf

# Add permissions for nginx and application
RUN chown -R www:www /var/www && chmod -R 755 /var/www && \
    chown -R www:www /var/lib/nginx && \
    chown -R www:www /var/log/nginx && \
    chown -R www:www /etc/nginx

RUN touch /var/run/nginx.pid && \
    chown -R www:www /var/run/nginx.pid

RUN composer install

# Switch to non-root user
USER www

# Expose ports
EXPOSE 8000

# Run commands
CMD ["sh", "-c", "nginx && php-fpm"]