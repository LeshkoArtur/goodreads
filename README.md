# Goodreads - Laravel Application

Веб-додаток для управління книгами та читацькими списками, побудований на Laravel з використанням Docker.

## 🚀 Швидкий запуск

### Передумови

Переконайтеся, що у вас встановлено:
- [Docker](https://docs.docker.com/get-docker/) (версія 20.10+)
- [Docker Compose](https://docs.docker.com/compose/install/) (версія 2.0+)

### Крок 1: Клонування репозиторію

```bash
git clone <repository-url>
cd goodreads
```

### Крок 2: Налаштування середовища

Створіть файл `.env` на основі `.env.example`:

```bash
cp .env.example .env
```

**Важливо:** Переконайтеся, що в `.env` файлі встановлені правильні налаштування для Docker:

```env
# База даних
DB_CONNECTION=pgsql
DB_HOST=db
DB_PORT=5432
DB_DATABASE=goodreads
DB_USERNAME=goodreads
DB_PASSWORD=secret

# Redis
REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379

# Кеш
CACHE_STORE=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis
```

### Крок 3: Запуск додатка

```bash
# Запуск всіх сервісів
docker compose up -d

# Або з перебудовою образів
docker compose up -d --build
```

### Крок 4: Перевірка роботи

Відкрийте браузер і перейдіть на:
```
http://localhost:8080
```

Ви повинні побачити стартову сторінку Laravel.

## 🐳 Docker сервіси

Додаток складається з наступних сервісів:

| Сервіс | Опис                  | Порт |
|--------|-----------------------|------|
| **app** | PHP 8.4-FPM з Laravel | - |
| **nginx** | Веб-сервер Nginx      | 8080 |
| **db** | PostgreSQL 15         | 5432 |
| **redis** | Redis 7 для кешування | 6379 |

## 🔧 Автоматична ініціалізація

При запуску контейнера `app` автоматично виконуються:

1. **Створення .env файлу** (якщо не існує)
2. **Генерація APP_KEY** (якщо не встановлений)
3. **Очікування доступності бази даних** (до 60 секунд)
4. **Очищення кешу Laravel** (`php artisan optimize:clear`)
5. **Запуск міграцій** (`php artisan migrate --force`)

Ви можете відстежити процес ініціалізації через логи:

```bash
docker compose logs app -f
```

## 📋 Корисні команди

### Управління контейнерами

```bash
# Запуск сервісів
docker compose up -d

# Зупинка сервісів
docker compose down

# Перезапуск конкретного сервіса
docker compose restart app

# Перегляд логів
docker compose logs app
docker compose logs nginx
docker compose logs db

# Перегляд статусу сервісів
docker compose ps
```

### Робота з Laravel

```bash
# Виконання Artisan команд
docker compose exec app php artisan migrate
docker compose exec app php artisan migrate:rollback
docker compose exec app php artisan db:seed
docker compose exec app php artisan tinker

# Очищення кешу
docker compose exec app php artisan optimize:clear

# Встановлення залежностей
docker compose exec app composer install
docker compose exec app composer update

# Запуск тестів
docker compose exec app php artisan test
```

### Робота з базою даних

```bash
# Підключення до PostgreSQL
docker compose exec db psql -U goodreads_user -d goodreads

# Бекап бази даних
docker compose exec db pg_dump -U goodreads_user goodreads > backup.sql

# Відновлення з бекапу
docker compose exec -T db psql -U goodreads_user goodreads < backup.sql
```

### Робота з Redis

```bash
# Підключення до Redis CLI
docker compose exec redis redis-cli

# Очищення Redis кешу
docker compose exec redis redis-cli FLUSHALL
```

## 🛠️ Розробка

### Встановлення залежностей

```bash
# PHP залежності
docker compose exec app composer install

# Якщо потрібно встановити нові пакети
docker compose exec app composer require package-name
```

### Робота з файлами

Всі файли проекту монтуються в контейнер, тому зміни в коді відразу відображаються без перезапуску контейнерів.

### Налагодження

```bash
# Перегляд логів Laravel
docker compose exec app tail -f /var/www/html/storage/logs/laravel.log

# Перегляд логів PHP-FPM
docker compose logs app

# Перегляд логів Nginx
docker compose logs nginx
```

## 🔍 Усунення проблем

### Проблема: Сайт не відкривається

1. Перевірте, чи запущені всі сервіси:
   ```bash
   docker compose ps
   ```

2. Перевірте логи:
   ```bash
   docker compose logs nginx
   docker compose logs app
   ```

### Проблема: Помилки бази даних

1. Перевірте, чи запущений PostgreSQL:
   ```bash
   docker compose logs db
   ```

2. Перевірте підключення:
   ```bash
   docker compose exec app php artisan migrate:status
   ```

### Проблема: Помилки кешу

1. Очистіть кеш:
   ```bash
   docker compose exec app php artisan optimize:clear
   ```

2. Перезапустіть Redis:
   ```bash
   docker compose restart redis
   ```

### Повне перезавантаження

Якщо виникли серйозні проблеми:

```bash
# Зупинка всіх сервісів
docker compose down

# Видалення образів (опціонально)
docker compose down --rmi all

# Видалення томів (УВАГА: видалить дані БД)
docker compose down -v

# Повна перебудова
docker compose up -d --build
```

## 📝 Примітки

- Порт 8080 повинен бути вільним на вашій системі
- Дані PostgreSQL зберігаються в Docker volume `goodreads_postgres_data`
- Логи Laravel зберігаються в `storage/logs/laravel.log`
- При першому запуску може знадобитися кілька хвилин для завантаження образів

---

**Автор:** Arakviel
**Версія:** 1.0
**Дата:** 2025-07-12
