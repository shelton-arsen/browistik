<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Проверяем, что это POST запрос
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Метод не разрешен']);
    exit;
}

// Проверяем Content-Type
$contentType = $_SERVER['CONTENT_TYPE'] ?? '';
if (strpos($contentType, 'application/json') !== false) {
    $input = json_decode(file_get_contents('php://input'), true);
} else {
    $input = $_POST;
}

// Валидация данных
if (empty($input['phone'])) {
    echo json_encode([
        'success' => false, 
        'message' => 'Номер телефона обязателен'
    ]);
    exit;
}

$phone = trim($input['phone']);
$name = trim($input['name'] ?? '');

// Валидация телефона (белорусский формат)
if (!preg_match('/^\+375\s\d{2}\s\d{3}-\d{2}-\d{2}$/', $phone)) {
    echo json_encode([
        'success' => false, 
        'message' => 'Некорректный формат номера телефона. Пример: +375 29 123-45-67'
    ]);
    exit;
}

// Подключаем необходимые файлы
require_once '../config/database.php';
require_once '../classes/TelegramBot.php';

// Проверяем подключение к БД
if (!isset($pdo)) {
    error_log("Database connection not found in callback.php");
    echo json_encode([
        'success' => false, 
        'message' => 'Ошибка подключения к базе данных'
    ]);
    exit;
}

try {
    // Сохранение в БД
    $stmt = $pdo->prepare("INSERT INTO callback_requests (name, phone, ip_address, user_agent, created_at) VALUES (?, ?, ?, ?, NOW())");
    $stmt->execute([
        $name, 
        $phone, 
        $_SERVER['REMOTE_ADDR'] ?? null,
        $_SERVER['HTTP_USER_AGENT'] ?? null
    ]);
    
    $requestId = $pdo->lastInsertId();
    
    // Отправка в Telegram
    $telegram = new TelegramBot();
    $telegramResult = $telegram->sendCallbackRequest($name, $phone);
    
    // Логируем результат отправки в Telegram
    if (!$telegramResult) {
        error_log("Failed to send Telegram notification for callback request ID: $requestId");
    }
    
    echo json_encode([
        'success' => true,
        'message' => 'Спасибо! Ваша заявка принята. Мы свяжемся с вами в ближайшее время.',
        'telegram_sent' => $telegramResult
    ]);
    
} catch (PDOException $e) {
    error_log("Database error in callback.php: " . $e->getMessage());
    echo json_encode([
        'success' => false, 
        'message' => 'Произошла ошибка при сохранении заявки. Попробуйте позже.'
    ]);
    
} catch (Exception $e) {
    error_log("General error in callback.php: " . $e->getMessage());
    echo json_encode([
        'success' => false, 
        'message' => 'Произошла ошибка при отправке заявки. Попробуйте позже.'
    ]);
}
?>
