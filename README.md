Клонируйте проект с GitHub:
```bash
git clone <repository_url>
cd <repository_folder>
```

Установите PHP-зависимости:
```bash
composer install
```

Установите зависимости npm:
```bash
npm install
```

Скопируйте файл .env.example в .env и настройте его:
```bash
cp .env.example .env
```

Обновите файл .env, <strong>указав данные для подключения к базе данных</strong>:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

Сгенерируйте новый ключ приложения:
```bash
php artisan key:generate
```

Запустите миграции для настройки структуры БД:
```bash
php artisan migrate --seed
```

Заполните базу данных, собственно, данными:
```bash
php artisan db:seed
```

Запустите сервер:
```bash
php artisan serve
```

Приложение будет доступно по адресу [http://127.0.0.1:8000](http://127.0.0.1:8000).

Если вы используете Nginx, настройте его так, чтобы он указывал на папку `public` проекта.

### Шаг 7: Запуск тестов
Запустите тесты PHPUnit для проверки работы приложения:
```bash
php artisan test
```



