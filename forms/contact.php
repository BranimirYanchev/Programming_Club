<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $message = trim($_POST['message']);

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

    // Изчистване на данните от HTML опасни символи (ако се използват някъде повторно)
    $first_name = htmlspecialchars($first_name, ENT_QUOTES, 'UTF-8');
    $last_name = htmlspecialchars($last_name, ENT_QUOTES, 'UTF-8');
    $message = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');

    $to = "programmingclub25@gmail.com";
    $subject = "Нов контакт от сайта";

    $email_content = "Име: $first_name $last_name\n";
    $email_content .= "Имейл: $email\n";
    $email_content .= "Телефон: $phone\n\n";
    $email_content .= "Съобщение:\n$message\n";

    $headers = "From: programmingclub25@gmail.com\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    if (mail($to, $subject, $email_content, $headers)) {
        http_response_code(200);
        echo "Вашето съобщение беше изпратено успешно.";
        exit;
    } else {
        http_response_code(500);
        echo "Възникна грешка при изпращане на съобщението.";
        exit;
    }
} else {
    http_response_code(403);
    echo "Грешен метод на заявката.";
    exit;
}
?>
