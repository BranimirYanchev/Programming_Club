<?php
// Ако не ползваш Composer, сложи пътищата до класовете на PHPMailer правилно.
require __DIR__ . '/../PHPMailer/src/Exception.php';
require __DIR__ . '/../PHPMailer/src/PHPMailer.php';
require __DIR__ . '/../PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Вземаме данните
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $message = trim($_POST['message']);

    // Проверка за празни полета
    if (empty($first_name) || empty($last_name) || empty($email) || empty($phone) || empty($message)) {
        http_response_code(400);
        echo "Моля, попълнете всички полета.";
        exit;
    }

    // Проверка за валиден имейл
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo "Невалиден имейл адрес.";
        exit;
    }

    // Изчистване на HTML специални символи (за по-сигурно)
    $first_name = htmlspecialchars($first_name, ENT_QUOTES, 'UTF-8');
    $last_name = htmlspecialchars($last_name, ENT_QUOTES, 'UTF-8');
    $message = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');

    $mail = new PHPMailer(true);

    try {
        // SMTP настройки - настрой ги според твоя хостинг или имейл доставчик
        $mail->isSMTP();
        $mail->Host       = 'smtp.example.com';    // SMTP сървър (пример: smtp.gmail.com)
        $mail->SMTPAuth   = true;
        $mail->Username   = 'your_email@example.com'; // Имейл за вход
        $mail->Password   = 'your_password';           // Парола
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587; // Обикновено 587 или 465

        // Получатели
        $mail->setFrom('your_email@example.com', 'Contact Form'); // От кого се праща
        $mail->addAddress('programmingclub25@gmail.com');         // Към кого

        // Reply-To да е реалният имейл на потребителя
        $mail->addReplyTo($email, "$first_name $last_name");

        // Съдържание
        $mail->Subject = 'Нов контакт от сайта';
        $mail->Body    = "Име: $first_name $last_name\nИмейл: $email\nТелефон: $phone\n\nСъобщение:\n$message";

        $mail->send();

        http_response_code(200);
        echo "Вашето съобщение беше изпратено успешно.";
    } catch (Exception $e) {
        http_response_code(500);
        echo "Съобщението не може да бъде изпратено. Грешка: {$mail->ErrorInfo}";
    }
} else {
    http_response_code(403);
    echo "Грешен метод на заявката.";
}
?>
