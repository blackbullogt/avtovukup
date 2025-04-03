<?php
// Открытие файла для записи данных
$file = fopen('post-data.txt', 'a+');

// Запись данных (дата, POST данные) в файл
fwrite($file, '[' . date("Y-m-d H:i:s") . ']: ' . json_encode($_POST, JSON_UNESCAPED_UNICODE) . PHP_EOL);
fclose($file);

// Получаем данные из формы
$name = $_POST['name'];
$phone = $_POST['phone'];
$marka_avto = $_POST['marka_avto'];
$model_avto = $_POST['model_avto'];

// Получаем IP-адрес пользователя
$ip = $_SERVER['REMOTE_ADDR'];

// Файл для сохранения всех данных
$check_file = 'data-check.txt';

// Запись нового IP и номера телефона в файл
file_put_contents($check_file, $ip . '|' . $phone . PHP_EOL, FILE_APPEND);

// Ваш токен бота и ID чата
$token = "7460039377:AAHr2_QeJYnE3chmU8OtiDURRTnmztjX46c";
$chat_id = "-1002201316526";

// Формируем сообщение
$message = "Name: " . $name . "\n";
$message .= "Phone: 0" . $phone . "\n";
$message .= "Марка авто: " . $marka_avto . "\n";
$message .= "Модель авто: " . $model_avto . "\n";

// URL для отправки сообщения через Telegram API
$url = "https://api.telegram.org/bot" . $token . "/sendMessage";

// Параметры запроса
$data = array(
    'chat_id' => $chat_id,
    'text' => $message
);

// Инициализация cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Выполнение запроса
$response = curl_exec($ch);

// Закрытие cURL
curl_close($ch);

// Перенаправление на страницу благодарности
header("Location: thankyou.php");
?>
