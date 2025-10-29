# 📚 Readloop

> Соціальна мережа для справжніх любителів книг

[![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?style=flat&logo=laravel)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat&logo=php)](https://php.net)
[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)

## 📖 Про проєкт

**Readloop** — це соціальна платформа, створена для книголюбів, де ви можете:

- 📚 Відстежувати прочитані книги та створювати персональні колекції
- ⭐ Оцінювати та рецензувати улюблені твори
- 💬 Обговорювати книги з однодумцями в групах та коментарях
- 📝 Ділитися цитатами та думками
- 🎯 Відкривати нові книги через рекомендації спільноти
- 👥 Слідкувати за авторами та іншими читачами

## 🚀 Технології

### Backend

- **Laravel 12.x** — сучасний PHP фреймворк
- **Filament** — адміністративна панель
- **PostgreSQL** — база даних
- **Scribe** — автоматична генерація API документації

### Frontend

- **React** — ...

## 📋 Вимоги

- PHP >= 8.2
- Composer
- Node.js >= 18.x
- MySQL >= 8.0 або PostgreSQL >= 14
- Git

## 🛠️ Встановлення

### 1. Клонування репозиторію

```bash
git clone https://github.com/your-username/readloop.git
cd readloop
```

### 2. Встановлення залежностей

```bash
# PHP залежності
composer install

# Node.js залежності
npm install
```

### 3. Налаштування середовища

```bash
# Створіть файл .env
cp .env.example .env

# Згенеруйте ключ додатку
php artisan key:generate
```

### 4. Налаштування бази даних

Відредагуйте `.env` файл і вкажіть параметри підключення до БД:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=defaultdb
DB_USERNAME=
DB_PASSWORD=
```

### 5. Міграції та seed-дані

```bash
# Виконайте міграції
php artisan migrate

# (Опціонально) Заповніть тестовими даними
php artisan db:seed

```

### 6. Збірка frontend

```bash
# Для розробки
npm run dev

# Для продакшну
npm run build
```

### 7. Запуск сервера

```bash
php artisan serve
```

Додаток буде доступний за адресою: `http://localhost:8000`

## 🧪 Тестування

```bash
# Запуск всіх тестів
php artisan test

# Запуск з coverage
php artisan test --coverage
php artisan db:seed --class=UkrainianSeeder
```

## 📚 API Документація

API документація доступна за адресою `/docs/api` після запуску додатку.

Для оновлення документації:

```bash
php artisan scribe:generate
```

## 🔐 Аутентифікація

Проєкт використовує Laravel Sanctum для API аутентифікації:

- **POST** `/api/register` — реєстрація
- **POST** `/api/login` — вхід
- **POST** `/api/logout` — вихід

## 📁 Структура проєкту

```
readloop/
├── app/
│   ├── Http/Controllers/     # Контролери API
│   ├── Models/               # Eloquent моделі
│   └── ...
├── config/                   # Конфігураційні файли
├── database/
│   ├── migrations/           # Міграції БД
│   └── seeders/              # Seed-класи
├── public/                   # Публічні файли
├── resources/
│   ├── views/                # Blade шаблони
│   └── js/                   # JavaScript файли
├── routes/
│   ├── api.php               # API маршрути
│   └── web.php               # Web маршрути
└── tests/                    # Тести
```

