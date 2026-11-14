FROM php:8.3-fpm-alpine

# Install system dependencies & PHP extensions required for Laravel
RUN apk add --no-cache bash nginx supervisor libpq libzip icu-libs sqlite \
    && apk add --no-cache --virtual .build-deps $PHPIZE_DEPS postgresql-dev libzip-dev icu-dev sqlite-dev \
    && docker-php-ext-install pdo_pgsql pdo_mysql pdo_sqlite intl zip opcache pcntl bcmath \
    && apk del .build-deps

# Copy Composer from official composer image
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Configure Nginx, Supervisor, and startup script
COPY conf/nginx/nginx-site.conf /etc/nginx/http.d/default.conf
COPY conf/supervisor/supervisord.conf /etc/supervisord.conf
COPY conf/start.sh /start.sh
RUN chmod +x /start.sh

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . .

# Install production PHP dependencies
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# Set permissions for Laravel directories
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Production environment defaults
ENV APP_ENV=production
ENV APP_DEBUG=false
ENV LOG_CHANNEL=stderr
ENV COMPOSER_ALLOW_SUPERUSER=1

EXPOSE 80

CMD ["/start.sh"]

