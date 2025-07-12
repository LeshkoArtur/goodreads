#!/bin/bash
set -e

# Створення .env файлу якщо він не існує
if [ ! -f /var/www/html/.env ]; then
    echo "Створення .env файлу з .env.example..."
    cp /var/www/html/.env.example /var/www/html/.env
    chown www-data:www-data /var/www/html/.env
fi

# Генерація ключа додатка якщо він не встановлений
if ! grep -q "APP_KEY=base64:" /var/www/html/.env; then
    echo "Генерація ключа додатка..."
    php artisan key:generate --no-interaction
fi

# Функція для очікування доступності бази даних
wait_for_db() {
    echo "Очікування доступності бази даних..."
    local max_attempts=30
    local attempt=1

    while [ $attempt -le $max_attempts ]; do
        if php artisan migrate:status > /dev/null 2>&1; then
            echo "База даних доступна!"
            return 0
        fi
        echo "Спроба $attempt/$max_attempts: База даних ще не готова. Очікування 2 секунди..."
        sleep 2
        attempt=$((attempt + 1))
    done

    echo "УВАГА: Не вдалося підключитися до бази даних після $max_attempts спроб."
    return 1
}

# Ініціалізація в фоновому режимі
(
    if wait_for_db; then
        echo "Очищення кешу..."
        php artisan optimize:clear

        echo "Запуск міграцій..."
        php artisan migrate --force

        echo "Ініціалізація бази даних завершена!"
    else
        echo "УВАГА: Міграції не запущені через проблеми з БД. Запустіть їх вручну пізніше."
    fi
) &

echo "Запуск PHP-FPM..."

# Запуск PHP-FPM
exec "$@"
