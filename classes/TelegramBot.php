<?php
class TelegramBot {
    private $botToken;
    private $chatId;
    private $apiUrl;
    
    public function __construct() {
        $this->botToken = $_ENV['TELEGRAM_BOT_TOKEN'] ?? '';
        $this->chatId = $_ENV['TELEGRAM_CHAT_ID'] ?? '';
        $this->apiUrl = "https://api.telegram.org/bot{$this->botToken}/";
        
        if (empty($this->botToken) || empty($this->chatId)) {
            error_log("Telegram bot credentials not configured");
        }
    }
    
    /**
     * Отправить заявку на обратный звонок в Telegram
     */
    public function sendCallbackRequest($name, $phone) {
        if (empty($this->botToken) || empty($this->chatId)) {
            return false;
        }
        
        $message = $this->formatCallbackMessage($name, $phone);
        return $this->sendMessage($message);
    }
    
    /**
     * Форматировать сообщение для заявки на обратный звонок
     */
    private function formatCallbackMessage($name, $phone) {
        $emoji = "📞";
        $date = date('d.m.Y H:i');
        
        $message = "{$emoji} <b>Новая заявка на обратный звонок</b>\n\n";
        
        if (!empty($name)) {
            $message .= "👤 <b>Имя:</b> " . htmlspecialchars($name) . "\n";
        }
        
        $message .= "📱 <b>Телефон:</b> <code>" . htmlspecialchars($phone) . "</code>\n";
        $message .= "🕐 <b>Время:</b> {$date}\n\n";
        $message .= "💜 <i>Browistik - идеальные брови для вас!</i>";
        
        return $message;
    }
    
    /**
     * Отправить сообщение в Telegram
     */
    private function sendMessage($message) {
        $data = [
            'chat_id' => $this->chatId,
            'text' => $message,
            'parse_mode' => 'HTML',
            'disable_web_page_preview' => true
        ];
        
        return $this->makeRequest('sendMessage', $data);
    }
    
    /**
     * Выполнить запрос к Telegram API
     */
    private function makeRequest($method, $data = []) {
        $url = $this->apiUrl . $method;
        
        $options = [
            CURLOPT_URL => $url,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($data),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/x-www-form-urlencoded'
            ]
        ];
        
        $curl = curl_init();
        curl_setopt_array($curl, $options);
        
        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $error = curl_error($curl);
        
        curl_close($curl);
        
        if ($error) {
            error_log("Telegram API curl error: " . $error);
            return false;
        }
        
        if ($httpCode !== 200) {
            error_log("Telegram API HTTP error: " . $httpCode);
            error_log("Response: " . $response);
            return false;
        }
        
        $result = json_decode($response, true);
        
        if (!$result || !$result['ok']) {
            error_log("Telegram API response error: " . $response);
            return false;
        }
        
        return true;
    }
    
    /**
     * Отправить фото в Telegram
     */
    public function sendPhoto($photo, $caption = '') {
        if (empty($this->botToken) || empty($this->chatId)) {
            return false;
        }
        
        $data = [
            'chat_id' => $this->chatId,
            'photo' => $photo,
            'caption' => $caption,
            'parse_mode' => 'HTML'
        ];
        
        return $this->makeRequest('sendPhoto', $data);
    }
    
    /**
     * Проверить статус бота
     */
    public function checkBotStatus() {
        return $this->makeRequest('getMe');
    }
    
    /**
     * Получить информацию о чате
     */
    public function getChatInfo() {
        $data = ['chat_id' => $this->chatId];
        return $this->makeRequest('getChat', $data);
    }
    
    /**
     * Отправить уведомление о новом посетителе сайта
     */
    public function sendVisitorNotification($userAgent, $ip = null) {
        if (empty($this->botToken) || empty($this->chatId)) {
            return false;
        }
        
        $message = "👀 <b>Новый посетитель на сайте Browistik</b>\n\n";
        $message .= "🕐 <b>Время:</b> " . date('d.m.Y H:i') . "\n";
        
        if ($ip) {
            $message .= "🌐 <b>IP:</b> <code>{$ip}</code>\n";
        }
        
        if ($userAgent) {
            $browser = $this->getBrowserFromUserAgent($userAgent);
            $message .= "💻 <b>Браузер:</b> {$browser}\n";
        }
        
        $message .= "\n💜 <i>Время привлекать новых клиентов!</i>";
        
        return $this->sendMessage($message);
    }
    
    /**
     * Определить браузер из User Agent
     */
    private function getBrowserFromUserAgent($userAgent) {
        if (strpos($userAgent, 'Chrome') !== false) {
            return 'Google Chrome';
        } elseif (strpos($userAgent, 'Firefox') !== false) {
            return 'Mozilla Firefox';
        } elseif (strpos($userAgent, 'Safari') !== false) {
            return 'Safari';
        } elseif (strpos($userAgent, 'Edge') !== false) {
            return 'Microsoft Edge';
        } elseif (strpos($userAgent, 'Opera') !== false) {
            return 'Opera';
        } else {
            return 'Неизвестный браузер';
        }
    }
}
?>
