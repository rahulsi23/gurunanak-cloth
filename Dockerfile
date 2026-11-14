FROM php:8.3-apache

# Install required system libraries and PHP extensions
RUN apt-get update && apt-get install -y --no-install-recommends \
    libzip-dev \
    zip \
    unzip \
    git \
    sqlite3 \
    libsqlite3-dev \
    libicu-dev \
    libpq-dev \
    && docker-php-ext-install pdo_mysql pdo_pgsql intl zip pcntl bcmath \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

# Copy Composer binary
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Configure Apache DocumentRoot to point to Laravel's public directory
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Configure Apache to listen on both 80 and 10000 (Render expected port)
RUN sed -i 's/Listen 80/Listen 80\nListen 10000/' /etc/apache2/ports.conf \
    && sed -i 's/<VirtualHost \*:80>/<VirtualHost \*:80 \*:10000>/' /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www/html
COPY . .

# Install PHP dependencies without scripts that need DB
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader --no-scripts

# Permissions
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

COPY conf/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

ENV PORT=10000
EXPOSE 80 10000

CMD ["/entrypoint.sh"]
