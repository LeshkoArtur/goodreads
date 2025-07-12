FROM php:8.4-fpm

# Встановлення системних залежностей
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libxml2-dev \
    libcurl4-openssl-dev \
    libicu-dev \
    libexif-dev \
    unzip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Налаштування та встановлення PHP-розширень
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) pdo pdo_pgsql pgsql bcmath zip gd curl intl exif

# Встановлення Redis через PECL
RUN pecl install redis && docker-php-ext-enable redis \
    && rm -rf /tmp/pear

# Налаштування OPcache для продуктивності
RUN echo "opcache.enable=1" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.memory_consumption=128" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.interned_strings_buffer=8" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.max_accelerated_files=10000" >> /usr/local/etc/php/conf.d/opcache.ini

# Копіювання кастомного php.ini
COPY docker/php/php.ini /usr/local/etc/php/conf.d/custom.ini

# Копіювання entrypoint скрипта
COPY docker/php/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Встановлення Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Налаштування робочої директорії
WORKDIR /var/www/html

# Копіювання коду проєкту
COPY --chown=www-data:www-data . /var/www/html

# Встановлення залежностей Composer
RUN composer install --no-dev --optimize-autoloader

# Створення необхідних директорій та налаштування прав доступу
RUN mkdir -p /var/www/html/storage/framework/{sessions,views,cache} \
    && mkdir -p /var/www/html/storage/logs \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

# Запуск PHP-FPM від імені www-data
USER www-data

# Встановлення entrypoint
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]

# Команда за замовчуванням
CMD ["php-fpm"]

