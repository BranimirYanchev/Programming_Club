<?php
// Зареждане на PHPMailer от папката forms/PHPMailer
require '/PHPMailer/src/Exception.php';
require '/PHPMailer/src/PHPMailer.php';
require '/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name  = trim($_POST['last_name'] ?? '');
    $email      = trim($_POST['email'] ?? '');
    $phone      = trim($_POST['phone'] ?? '');
    $message    = trim($_POST['message'] ?? '');

    // Валидация
    if (empty($first_name) || empty($last_name) || empty($email) || empty($phone) || empty($message)) {
        http_response_code(400);
        echo "Моля, попълнете всички полета.";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo "Невалиден имейл адрес.";
        exit;
    }

    // Безопасност
    $first_name = htmlspecialchars($first_name, ENT_QUOTES, 'UTF-8');
    $last_name  = htmlspecialchars($last_name, ENT_QUOTES, 'UTF-8');
    $message    = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');

    $mail = new PHPMailer(true);

    try {
        // Настройки на Gmail SMTP
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'programmingclub25@gmail.com';
        $mail->Password   = 'uwdx bofu vywx yxqk'; // App Password от Google
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Имейл параметри
        $mail->setFrom('programmingclub25@gmail.com', 'Contact Form');
        $mail->addAddress('programmingclub25@gmail.com');
        $mail->addReplyTo($email, "$first_name $last_name");

        $mail->Subject = 'Ново съобщение от сайта';
        $mail->Body    = "Име: $first_name $last_name\nИмейл: $email\nТелефон: $phone\n\nСъобщение:\n$message";

        $mail->send();

        http_response_code(200);
        echo "Вашето съобщение беше изпратено успешно.";
    } catch (Exception $e) {
        http_response_code(500);
        echo "Грешка при изпращане: {$mail->ErrorInfo}";
    }
} else {
    http_response_code(403);
    echo "Недопустим метод на заявката.";
}
