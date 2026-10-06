# Median Group — Лендінг

Простий односторінковий лендінг з формою заявки та інтеграцією з CRM через зовнішній API. Стек: Laravel + Livewire.

## Технології

- **PHP** 8.3 (FPM Alpine)
- **Laravel** 12
- **Livewire** 4 — реактивна форма без перезавантаження сторінки
- **Nginx** 1.25
- **Docker** + Docker Compose

## Функціонал

- Форма заявки: ім'я, телефон, email, повідомлення
- Валідація в реальному часі на фронті (Livewire)
- Серверна валідація через Laravel FormRequest
- Відправка даних на CRM через Laravel HTTP Client
- Збір UTM-міток з URL у сесію та передача разом з формою
- Показ статусу «успішно» / «помилка» без перезавантаження сторінки
- Логування запитів у `storage/logs/laravel.log`

## Запуск локально

### Вимоги

- [Docker Desktop](https://www.docker.com/products/docker-desktop/) встановлений і запущений

### Кроки

```bash
# 1. Клонувати репозиторій
git clone <repo-url>
cd test-task-midian-group

# 2. Зібрати Docker-образи
docker compose build

# 3. Запустити контейнери
docker compose up -d

# 4. Встановити PHP-залежності
docker compose exec app composer install

# 5. Скопіювати файл середовища
cp src/.env.example src/.env

# 6. Згенерувати ключ додатку
docker compose exec app php artisan key:generate

# 7. Очистити кеш конфігурації
docker compose exec app php artisan config:clear
```

Відкрити **http://localhost:8888** у браузері.

### Змінні середовища

| Змінна | За замовчуванням | Опис |
|--------|-----------------|------|
| `CRM_TIMEOUT` | `10` | Таймаут HTTP-запиту до CRM (секунди) |
| `SESSION_DRIVER` | `file` | Драйвер сесій |

> CRM endpoint захардкоджений у `config/services.php` — це публічний URL з умов завдання, не секрет.

### Перевірка успішної відправки

1. Відкрити `http://localhost:8888/`
2. Заповнити форму та натиснути «Send Message»
3. З'явиться зелений банер — без перезавантаження сторінки
4. Перевірити лог: `docker compose exec app tail -5 storage/logs/laravel.log`

### Перевірка UTM-міток

Відкрити сторінку з UTM-параметрами перед відправкою форми:

```
http://localhost:8888/?utm_source=google&utm_medium=cpc&utm_campaign=test_launch&utm_term=crm&utm_content=banner
```

UTM-мітки збережуться в сесії та підуть разом з даними форми на CRM.

### Перевірка обробки помилки

1. У `src/.env` додати: `CRM_ENDPOINT=https://invalid.nonexistent.url.test/api`
2. Виконати: `docker compose exec app php artisan config:clear`
3. Відправити форму — з'явиться червоний банер з повідомленням про помилку
4. Помилка залогована: `docker compose exec app tail -5 storage/logs/laravel.log`
5. Відновити: прибрати рядок з `src/.env` та знову очистити кеш конфігурації

### Перегляд логів

```bash
docker compose exec app tail -f storage/logs/laravel.log
```

## Структура проєкту

```
test-task-midian-group/
├── docker/
│   ├── nginx/default.conf      # Конфігурація Nginx
│   └── php/Dockerfile          # PHP 8.3 FPM образ
├── src/                        # Laravel-додаток
│   ├── app/
│   │   ├── Http/
│   │   │   ├── Controllers/LandingController.php
│   │   │   ├── Middleware/CaptureUtmParams.php   # Зберігає UTM у сесію
│   │   │   └── Requests/LeadFormRequest.php      # Правила валідації
│   │   ├── Livewire/LeadForm.php                 # Реактивний компонент форми
│   │   └── Services/CrmService.php               # Логіка інтеграції з CRM
│   ├── resources/views/
│   │   ├── layouts/app.blade.php
│   │   ├── landing/index.blade.php
│   │   └── livewire/lead-form.blade.php
│   └── public/css/app.css      # Спільні стилі (BEM)
├── docker-compose.yml
└── README.md
```
