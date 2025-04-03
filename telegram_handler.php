<?php

// Открытие файла для записи данных
$file = fopen('post-data.txt', 'a+');

// Запись данных (дата, POST данные) в файл
fwrite($file, '[' . date("Y-m-d H:i:s") . ']: ' . json_encode($_POST, JSON_UNESCAPED_UNICODE) . PHP_EOL);
fclose($file);
header('Content-Type: application/json');

// Читаем данные из запроса
$data = json_decode(file_get_contents("php://input"), true);

// Ваш токен бота и ID чата
$token = "7460039377:AAHr2_QeJYnE3chmU8OtiDURRTnmztjX46c";
$chat_id = "-1002201316526";

// Подготовка сообщения для отправки
$message = "Новая заявка на оценку авто:\n";
$message .= "Марка: " . $data['carMake'] . "\n";
$message .= "Модель: " . $data['carModel'] . "\n";
$message .= "Рік та пробіг: " . $data['yearMileage'] . "\n";
$message .= "Стан кузов та салону: " . $data['condition'] . "\n";
$message .= "Технічний стан авто: " . $data['technicalCondition'] . "\n";
$message .= "Ім'я: " . $data['name_user'] . "\n";
$message .= "Телефон: " . $data['phone'] . "\n";
$message .= "IP: " . $_SERVER['REMOTE_ADDR'] . "\n";

// URL для отправки запроса в Telegram
$url = "https://api.telegram.org/bot$token/sendMessage?chat_id=$chat_id&text=" . urlencode($message);

// Отправка запроса в Telegram
$response = file_get_contents($url);

if ($response) {
    // Если запрос в Telegram был успешным, отправляем событие в Google Tag Manager (через gtag.js)
    echo "<script async src=\"https://www.googletagmanager.com/gtag/js?id=AW-16671858625\"></script>
    
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'AW-16671858625');
    </script>";

    // Отправляем успешный ответ
    echo json_encode(["success" => true, "message" => "Заявка успешно отправлена."]);
} else {
    // Если ошибка при отправке в Telegram
    echo json_encode(["success" => false, "message" => "Ошибка при отправке заявки в Telegram."]);
}
?>
