<?php
session_start();
include "connection.php";

// Debug ON
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$email = $_POST["email"] ?? '';
$password = $_POST["password"] ?? '';

if (empty($email) || empty($password)) {
    echo "❌ Липсва имейл или парола.";
    exit;
}

// Проверяваме дали потребителят съществува
$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    // Проверка на парола
    if (password_verify($password, $user["password"])) {
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["email"] = $user["email"];
        $_SESSION["role"] = $user["role"];

        // Пренасочване спрямо роля
        if ($user["role"] === "admin") {
            header("Location: ../php/admin.php");
            exit;
        } elseif ($user["role"] === "owner") {
            header("Location: ../php/owner.php");
            exit;
        } else {
            echo "✅ Успешен вход, но неразпозната роля.";
            exit;
        }
    } else {
        echo "❌ Грешна парола.";
        exit;
    }
} else {
    echo "❌ Имейлът не съществува.";
    exit;
}
