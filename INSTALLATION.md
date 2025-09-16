# Browistik Website - Инструкция по установке

## Описание проекта
Сайт для мастера по оформлению бровей и ресниц с современным дизайном, адаптивной версткой и функционалом обратного звонка.

## Системные требования
- PHP 7.4 или выше
- MySQL 5.7 или выше / MariaDB 10.3 или выше
- Веб-сервер (Apache/Nginx)
- SSL сертификат (рекомендуется)

## Структура проекта
```
brows.shaleika.fvds.ru/
├── assets/                 # Статические файлы
│   ├── css/               # Стили
│   └── js/                # JavaScript
├── ajax/                  # AJAX обработчики
├── classes/               # PHP классы
├── config/                # Конфигурация
├── uploads/               # Загруженные изображения
├── index.php              # Главная страница
├── migration.sql          # SQL миграция БД
├── database.sql          # Оригинальная схема БД
└── README.md             # Документация
```

## Установка

### 1. Загрузка файлов
Скопируйте все файлы проекта в корневую директорию вашего веб-сервера.

### 2. Настройка базы данных

#### Создание базы данных:
```bash
mysql -u root -p
```

#### Выполнение миграции:
```sql
source /path/to/migration.sql
```

Или выполните SQL файл через phpMyAdmin:
1. Откройте phpMyAdmin
2. Создайте новую базу данных `brows`
3. Импортируйте файл `migration.sql`

### 3. Настройка конфигурации

#### Обновите файл `config/database.php`:
```php
<?php
return [
    'host' => 'localhost',
    'dbname' => 'brows',
    'username' => 'your_username',
    'password' => 'your_password',
    'charset' => 'utf8mb4'
];
```

#### Настройте Telegram бота (опционально):
1. Создайте бота через @BotFather в Telegram
2. Получите токен бота
3. Обновите файл `config.env`:
```
TELEGRAM_BOT_TOKEN=your_bot_token
TELEGRAM_CHAT_ID=your_chat_id
```

### 4. Настройка веб-сервера

#### Apache (.htaccess):
```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php [QSA,L]

# Безопасность
<Files "config.env">
    Order allow,deny
    Deny from all
</Files>

<Files "*.sql">
    Order allow,deny
    Deny from all
</Files>
```

#### Nginx:
```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /path/to/project;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    # Безопасность
    location ~ /\.(env|sql)$ {
        deny all;
    }
}
```

### 5. Настройка прав доступа
```bash
chmod 755 /path/to/project
chmod 644 /path/to/project/*.php
chmod 755 /path/to/project/uploads/
chmod 644 /path/to/project/uploads/*
```

## Функционал

### Основные возможности:
- ✅ Адаптивный дизайн
- ✅ Анимации при скролле
- ✅ Форма обратного звонка
- ✅ Галерея работ
- ✅ Интеграция с Telegram
- ✅ Валидация форм
- ✅ SEO оптимизация

### База данных включает:
- Таблица заявок на обратный звонок
- Таблица услуг
- Таблица отзывов (для будущего развития)
- Таблица записей на процедуры (для будущего развития)
- Статистика посещений

## Безопасность

### Рекомендации:
1. Используйте HTTPS
2. Регулярно обновляйте PHP и MySQL
3. Настройте файрвол
4. Используйте сильные пароли
5. Регулярно делайте резервные копии БД

### Файлы для защиты:
- `config.env` - содержит токены
- `*.sql` - файлы миграции
- `config/` - конфигурационные файлы

## Резервное копирование

### Создание бэкапа БД:
```bash
mysqldump -u username -p brows > backup_$(date +%Y%m%d).sql
```

### Восстановление из бэкапа:
```bash
mysql -u username -p brows < backup_20250115.sql
```

## Мониторинг и обслуживание

### Регулярные задачи:
1. Очистка старых записей (процедура `cleanup_old_data`)
2. Мониторинг производительности
3. Обновление контента
4. Проверка работоспособности форм

### Логи для мониторинга:
- Логи веб-сервера
- Логи PHP ошибок
- Логи MySQL

## Поддержка

При возникновении проблем:
1. Проверьте логи ошибок
2. Убедитесь в правильности настроек БД
3. Проверьте права доступа к файлам
4. Убедитесь в работоспособности PHP и MySQL

## Версии

- **v1.0** - Базовая версия с основным функционалом
- **v1.1** - Оптимизация анимаций скролла
- **v1.2** - Обновление статистики достижений

---

**Разработано с ❤️ для Browistik**
