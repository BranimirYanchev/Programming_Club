<?php
require __DIR__ . '/PHPMailer/src/Exception.php';
require __DIR__ . '/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$first_name = trim($_POST['first_name'] ?? '');
$last_name  = trim($_POST['last_name'] ?? '');
$email      = trim($_POST['email'] ?? '');
$phone      = trim($_POST['phone'] ?? '');
$message    = trim($_POST['message'] ?? '');

// Проверка за задължителни полета
if (
    $first_name === '' ||
    $last_name === '' ||
    $email === '' ||
    $phone === '' ||
    $message === ''
) {
    http_response_code(400);
    echo "Всички полета са задължителни.";
    exit;
}

// Имейл валидация (като в JS)
if (!preg_match('/^[^@\s]+@[^@\s]+\.[^@\s]+$/', $email)) {
    http_response_code(400);
    echo "Имейл адресът изглежда невалиден или не съществува.";
    exit;
}

// Телефон валидация
if (!preg_match('/^[\d\s\+\-\(\)]{7,20}$/', $phone)) {
    http_response_code(400);
    echo "Моля, въведете валиден телефонен номер.";
    exit;
}

// Ескейпване
$first_name = htmlspecialchars($first_name, ENT_QUOTES, 'UTF-8');
$last_name  = htmlspecialchars($last_name, ENT_QUOTES, 'UTF-8');
$message    = nl2br(htmlspecialchars($message, ENT_QUOTES, 'UTF-8')); // nl2br за нови редове

$mail = new PHPMailer(true);

try {
    // SMTP конфигурация
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'programmingclub25@gmail.com';
    $mail->Password   = 'uwdx bofu vywx yxqk'; // App Password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // Кодировка
    $mail->CharSet = 'UTF-8';
    $mail->Encoding = 'base64';
    $mail->isHTML(true);

    // Получатели
    $mail->setFrom('programmingclub25@gmail.com', 'Форма за контакт');
    $mail->addAddress('programmingclub25@gmail.com');
    $mail->addReplyTo($email, "$first_name $last_name");

    // Имейл съдържание (HTML)
    $mail->Subject = 'Ново съобщение от сайта';
    $mail->Body = "
      <div style=\"background-color: #232162; color: #fff; padding: 20px; font-family: Arial, sans-serif; border-radius: 8px;\">
        <h2 style=\"margin-top: 0;\">Ново съобщение от сайта</h2>
        <p><strong>Име:</strong> $first_name $last_name</p>
        <p><strong>Имейл:</strong> $email</p>
        <p><strong>Телефон:</strong> $phone</p>
        <p><strong>Съобщение:</strong><br>$message</p>
        <hr style=\"border-color: #fff; margin: 20px 0;\">
        <a href=\"https://programming-club-php.onrender.com\" 
           style=\"
             display: inline-block;
             background-color: #fff;
             color: #232162;
             padding: 12px 20px;
             border-radius: 6px;
             text-decoration: none;
             font-weight: bold;
           \"
        >
          Посети сайта
        </a>
      </div>
    ";

    $mail->AltBody = "Име: $first_name $last_name\nИмейл: $email\nТелефон: $phone\n\nСъобщение:\n$message";

    $mail->send();

    http_response_code(200);
    echo "Вашето съобщение беше изпратено успешно!";
} catch (Exception $e) {
    http_response_code(500);
    echo "Възникна грешка при изпращането. Моля, опитайте отново по-късно.";
}
