
CREATE DATABASE IF NOT EXISTS brows CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE brows;

CREATE TABLE IF NOT EXISTS callback_requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL DEFAULT '',
    phone VARCHAR(20) NOT NULL,
    status ENUM('new', 'processed', 'completed', 'cancelled') DEFAULT 'new',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    processed_at TIMESTAMP NULL,
    completed_at TIMESTAMP NULL,
    notes TEXT,
    source VARCHAR(50) DEFAULT 'website',
    ip_address VARCHAR(45),
    user_agent TEXT,
    INDEX idx_created_at (created_at),
    INDEX idx_status (status),
    INDEX idx_phone (phone),
    INDEX idx_source (source)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    rating TINYINT(1) NOT NULL CHECK (rating >= 1 AND rating <= 5),
    review_text TEXT NOT NULL,
    service_type VARCHAR(100),
    is_published BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    published_at TIMESTAMP NULL,
    INDEX idx_published (is_published),
    INDEX idx_rating (rating),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS appointments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    client_name VARCHAR(255) NOT NULL,
    client_phone VARCHAR(20) NOT NULL,
    client_email VARCHAR(255),
    service_type VARCHAR(100) NOT NULL,
    appointment_date DATE NOT NULL,
    appointment_time TIME NOT NULL,
    duration_minutes INT DEFAULT 60,
    price DECIMAL(10,2),
    status ENUM('pending', 'confirmed', 'completed', 'cancelled', 'no_show') DEFAULT 'pending',
    notes TEXT,
    reminder_sent BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_appointment_date (appointment_date),
    INDEX idx_appointment_time (appointment_time),
    INDEX idx_status (status),
    INDEX idx_client_phone (client_phone),
    UNIQUE KEY unique_appointment (appointment_date, appointment_time)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price_from DECIMAL(10,2),
    price_to DECIMAL(10,2),
    duration_minutes INT,
    category ENUM('brows', 'lashes', 'combo') NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    sort_order INT DEFAULT 0,
    image_url VARCHAR(500),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_category (category),
    INDEX idx_active (is_active),
    INDEX idx_sort_order (sort_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO services (name, description, price_from, price_to, duration_minutes, category, sort_order) VALUES
('Архитектура бровей', 'Создание идеальной формы бровей с учетом особенностей вашего лица. Коррекция, окрашивание и укладка.', 25.00, 35.00, 60, 'brows', 1),
('Долговременная укладка бровей', 'Современная процедура, которая делает брови послушными и аккуратными на 4-6 недель.', 45.00, 55.00, 90, 'brows', 2),
('Окрашивание бровей', 'Профессиональное окрашивание хной или краской для создания насыщенного и стойкого цвета.', 20.00, 25.00, 45, 'brows', 3),
('Ламинирование ресниц', 'Процедура, которая делает ресницы длинными, объемными и изогнутыми без наращивания.', 35.00, 45.00, 75, 'lashes', 4),
('Наращивание ресниц', 'Классическое и объемное наращивание ресниц премиальными материалами.', 50.00, 80.00, 120, 'lashes', 5),
('Комплексный уход', 'Полный комплекс процедур для бровей и ресниц со скидкой. Идеально для особых случаев.', 80.00, 120.00, 150, 'combo', 6);

CREATE TABLE IF NOT EXISTS site_visits (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ip_address VARCHAR(45),
    user_agent TEXT,
    page_url VARCHAR(500),
    referrer VARCHAR(500),
    session_id VARCHAR(255),
    visit_date DATE NOT NULL,
    visit_time TIME NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_visit_date (visit_date),
    INDEX idx_ip_address (ip_address),
    INDEX idx_session_id (session_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE OR REPLACE VIEW active_callbacks AS
SELECT 
    id,
    name,
    phone,
    status,
    created_at,
    TIMESTAMPDIFF(MINUTE, created_at, NOW()) as minutes_ago
FROM callback_requests 
WHERE status IN ('new', 'processed')
ORDER BY created_at DESC;

CREATE OR REPLACE VIEW daily_stats AS
SELECT 
    DATE(created_at) as date,
    COUNT(*) as total_requests,
    COUNT(CASE WHEN status = 'new' THEN 1 END) as new_requests,
    COUNT(CASE WHEN status = 'processed' THEN 1 END) as processed_requests,
    COUNT(CASE WHEN status = 'completed' THEN 1 END) as completed_requests
FROM callback_requests 
GROUP BY DATE(created_at)
ORDER BY date DESC;

DELIMITER $$
CREATE TRIGGER callback_status_update 
    BEFORE UPDATE ON callback_requests
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

SHOW TABLES;
