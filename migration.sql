-- =====================================================
-- Browistik Website Database Migration Script
-- Версия: 1.0
-- Дата создания: 2025-01-15
-- Описание: Полная миграция базы данных для сайта Browistik
-- =====================================================

-- Настройки MySQL
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

-- =====================================================
-- СОЗДАНИЕ БАЗЫ ДАННЫХ
-- =====================================================

-- Создание базы данных (если не существует)
CREATE DATABASE IF NOT EXISTS `brows` 
DEFAULT CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

-- Использование базы данных
USE `brows`;

-- =====================================================
-- СОЗДАНИЕ ПОЛЬЗОВАТЕЛЯ БД (раскомментируйте при необходимости)
-- =====================================================

-- CREATE USER IF NOT EXISTS 'brows_user'@'localhost' IDENTIFIED BY 'iZ9hN0uC9h';
-- GRANT ALL PRIVILEGES ON brows.* TO 'brows_user'@'localhost';
-- FLUSH PRIVILEGES;

-- =====================================================
-- ТАБЛИЦЫ ДЛЯ ОСНОВНОГО ФУНКЦИОНАЛА
-- =====================================================

-- Таблица для заявок на обратный звонок
DROP TABLE IF EXISTS `callback_requests`;
CREATE TABLE `callback_requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT 'Имя клиента',
  `phone` varchar(20) NOT NULL COMMENT 'Номер телефона',
  `status` enum('new','processed','completed','cancelled') NOT NULL DEFAULT 'new' COMMENT 'Статус заявки',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Дата создания',
  `processed_at` timestamp NULL DEFAULT NULL COMMENT 'Дата обработки',
  `completed_at` timestamp NULL DEFAULT NULL COMMENT 'Дата завершения',
  `notes` text COMMENT 'Заметки менеджера',
  `source` varchar(50) NOT NULL DEFAULT 'website' COMMENT 'Источник заявки',
  `ip_address` varchar(45) DEFAULT NULL COMMENT 'IP адрес клиента',
  `user_agent` text COMMENT 'User Agent браузера',
  PRIMARY KEY (`id`),
  KEY `idx_created_at` (`created_at`),
  KEY `idx_status` (`status`),
  KEY `idx_phone` (`phone`),
  KEY `idx_source` (`source`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Заявки на обратный звонок';

-- Таблица для отзывов клиентов
DROP TABLE IF EXISTS `reviews`;
CREATE TABLE `reviews` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT 'Имя клиента',
  `rating` tinyint(1) NOT NULL CHECK (`rating` >= 1 AND `rating` <= 5) COMMENT 'Оценка от 1 до 5',
  `review_text` text NOT NULL COMMENT 'Текст отзыва',
  `service_type` varchar(100) DEFAULT NULL COMMENT 'Тип услуги',
  `is_published` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Опубликован ли отзыв',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `published_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_published` (`is_published`),
  KEY `idx_rating` (`rating`),
  KEY `idx_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Отзывы клиентов';

-- Таблица для записи на процедуры
DROP TABLE IF EXISTS `appointments`;
CREATE TABLE `appointments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_name` varchar(255) NOT NULL COMMENT 'Имя клиента',
  `client_phone` varchar(20) NOT NULL COMMENT 'Телефон клиента',
  `client_email` varchar(255) DEFAULT NULL COMMENT 'Email клиента',
  `service_type` varchar(100) NOT NULL COMMENT 'Тип услуги',
  `appointment_date` date NOT NULL COMMENT 'Дата записи',
  `appointment_time` time NOT NULL COMMENT 'Время записи',
  `duration_minutes` int(11) NOT NULL DEFAULT '60' COMMENT 'Длительность в минутах',
  `price` decimal(10,2) DEFAULT NULL COMMENT 'Стоимость услуги',
  `status` enum('pending','confirmed','completed','cancelled','no_show') NOT NULL DEFAULT 'pending',
  `notes` text COMMENT 'Заметки',
  `reminder_sent` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Отправлено ли напоминание',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_appointment` (`appointment_date`,`appointment_time`),
  KEY `idx_appointment_date` (`appointment_date`),
  KEY `idx_appointment_time` (`appointment_time`),
  KEY `idx_status` (`status`),
  KEY `idx_client_phone` (`client_phone`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Записи на процедуры';

-- Таблица для услуг
DROP TABLE IF EXISTS `services`;
CREATE TABLE `services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT 'Название услуги',
  `description` text COMMENT 'Описание услуги',
  `price_from` decimal(10,2) DEFAULT NULL COMMENT 'Цена от',
  `price_to` decimal(10,2) DEFAULT NULL COMMENT 'Цена до',
  `duration_minutes` int(11) DEFAULT NULL COMMENT 'Длительность в минутах',
  `category` enum('brows','lashes','combo') NOT NULL COMMENT 'Категория услуги',
  `is_active` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Активна ли услуга',
  `sort_order` int(11) NOT NULL DEFAULT '0' COMMENT 'Порядок сортировки',
  `image_url` varchar(500) DEFAULT NULL COMMENT 'URL изображения',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_category` (`category`),
  KEY `idx_active` (`is_active`),
  KEY `idx_sort_order` (`sort_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Список услуг';

-- Таблица для статистики посещений
DROP TABLE IF EXISTS `site_visits`;
CREATE TABLE `site_visits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) DEFAULT NULL COMMENT 'IP адрес посетителя',
  `user_agent` text COMMENT 'User Agent браузера',
  `page_url` varchar(500) DEFAULT NULL COMMENT 'URL страницы',
  `referrer` varchar(500) DEFAULT NULL COMMENT 'Откуда пришел пользователь',
  `session_id` varchar(255) DEFAULT NULL COMMENT 'ID сессии',
  `visit_date` date NOT NULL COMMENT 'Дата визита',
  `visit_time` time NOT NULL COMMENT 'Время визита',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_visit_date` (`visit_date`),
  KEY `idx_ip_address` (`ip_address`),
  KEY `idx_session_id` (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Статистика посещений сайта';

-- =====================================================
-- ВСТАВКА БАЗОВЫХ ДАННЫХ
-- =====================================================

-- Вставка базовых услуг
INSERT INTO `services` (`name`, `description`, `price_from`, `price_to`, `duration_minutes`, `category`, `sort_order`) VALUES
('Архитектура бровей', 'Создание идеальной формы бровей с учетом особенностей вашего лица. Коррекция, окрашивание и укладка.', 20.00, 25.00, 60, 'brows', 1),
('Долговременная укладка бровей', 'Современная процедура, которая делает брови послушными и аккуратными на 4-6 недель.', 40.00, 45.00, 90, 'brows', 2),
('Окрашивание + коррекция бровей', 'Профессиональное окрашивание краской для создания насыщенного и стойкого цвета с коррекцией формы.', 25.00, 30.00, 45, 'brows', 3),
('Окрашивание ресниц', 'Профессиональное окрашивание ресниц для создания выразительного взгляда и подчеркивания естественной красоты.', 10.00, 15.00, 30, 'lashes', 4),
('Комплексный уход', 'Полный комплекс процедур для бровей со скидкой. Идеально для особых случаев.', 60.00, 70.00, 150, 'combo', 5);

-- =====================================================
-- ПРЕДСТАВЛЕНИЯ (VIEWS)
-- =====================================================

-- Представление для активных заявок
CREATE OR REPLACE VIEW `active_callbacks` AS
SELECT 
    `id`,
    `name`,
    `phone`,
    `status`,
    `created_at`,
    TIMESTAMPDIFF(MINUTE, `created_at`, NOW()) as `minutes_ago`
FROM `callback_requests` 
WHERE `status` IN ('new', 'processed')
ORDER BY `created_at` DESC;

-- Представление для статистики по дням
CREATE OR REPLACE VIEW `daily_stats` AS
SELECT 
    DATE(`created_at`) as `date`,
    COUNT(*) as `total_requests`,
    COUNT(CASE WHEN `status` = 'new' THEN 1 END) as `new_requests`,
    COUNT(CASE WHEN `status` = 'processed' THEN 1 END) as `processed_requests`,
    COUNT(CASE WHEN `status` = 'completed' THEN 1 END) as `completed_requests`
FROM `callback_requests` 
GROUP BY DATE(`created_at`)
ORDER BY `date` DESC;

-- =====================================================
-- ТРИГГЕРЫ
-- =====================================================

-- Триггер для автоматического обновления processed_at
DROP TRIGGER IF EXISTS `callback_status_update`;
DELIMITER $$
CREATE TRIGGER `callback_status_update` 
    BEFORE UPDATE ON `callback_requests`
    FOR EACH ROW
BEGIN
    IF NEW.status = 'processed' AND OLD.status = 'new' THEN
        SET NEW.processed_at = NOW();
    END IF;
    
    IF NEW.status = 'completed' AND OLD.status != 'completed' THEN
        SET NEW.completed_at = NOW();
    END IF;
END$$
DELIMITER ;

-- =====================================================
-- ПРОЦЕДУРЫ И ФУНКЦИИ
-- =====================================================

-- Процедура для очистки старых записей (старше 1 года)
DROP PROCEDURE IF EXISTS `cleanup_old_data`;
DELIMITER $$
CREATE PROCEDURE `cleanup_old_data`()
BEGIN
    -- Удаляем старые заявки (старше 1 года)
    DELETE FROM `callback_requests` 
    WHERE `created_at` < DATE_SUB(NOW(), INTERVAL 1 YEAR);
    
    -- Удаляем старые записи посещений (старше 6 месяцев)
    DELETE FROM `site_visits` 
    WHERE `created_at` < DATE_SUB(NOW(), INTERVAL 6 MONTH);
    
    -- Показываем количество удаленных записей
    SELECT ROW_COUNT() as 'deleted_records';
END$$
DELIMITER ;

-- =====================================================
-- ИНДЕКСЫ ДЛЯ ОПТИМИЗАЦИИ
-- =====================================================

-- Дополнительные индексы для оптимизации запросов
CREATE INDEX `idx_callback_created_status` ON `callback_requests` (`created_at`, `status`);
CREATE INDEX `idx_appointment_date_status` ON `appointments` (`appointment_date`, `status`);
CREATE INDEX `idx_services_category_active` ON `services` (`category`, `is_active`);

-- =====================================================
-- ЗАВЕРШЕНИЕ МИГРАЦИИ
-- =====================================================

-- Показать созданные таблицы
SHOW TABLES;

-- Показать статистику базы данных
SELECT 
    TABLE_NAME as 'Таблица',
    TABLE_ROWS as 'Количество записей',
    DATA_LENGTH as 'Размер данных (байт)',
    INDEX_LENGTH as 'Размер индексов (байт)'
FROM information_schema.TABLES 
WHERE TABLE_SCHEMA = 'brows'
ORDER BY TABLE_NAME;

-- Подтверждение транзакции
COMMIT;

-- =====================================================
-- ИНСТРУКЦИИ ПО УСТАНОВКЕ
-- =====================================================

/*
ИНСТРУКЦИИ ПО УСТАНОВКЕ:

1. Подключитесь к MySQL:
   mysql -u root -p

2. Выполните миграцию:
   source /path/to/migration.sql

3. Проверьте созданные таблицы:
   USE brows;
   SHOW TABLES;

4. Проверьте данные:
   SELECT * FROM services;
   SELECT * FROM callback_requests;

5. Настройте пользователя БД (опционально):
   - Раскомментируйте строки создания пользователя в начале файла
   - Измените пароль на более безопасный

6. Обновите конфигурацию в config/database.php:
   - Укажите правильные данные подключения
   - Проверьте права доступа пользователя

ПРИМЕЧАНИЯ:
- Все таблицы создаются с кодировкой utf8mb4 для поддержки эмодзи
- Используются индексы для оптимизации производительности
- Настроены триггеры для автоматического обновления временных меток
- Созданы представления для удобного доступа к данным
*/
