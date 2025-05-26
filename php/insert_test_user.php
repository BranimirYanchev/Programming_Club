<?php
include __DIR__ . "/connection.php";

// Примерен admin
$email = "admin@pcb.bg";
$password = password_hash("admin123", PASSWORD_DEFAULT);
$role = "admin";

$stmt = $conn->prepare("INSERT INTO users (email, password, role) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $email, $password, $role);
$stmt->execute();

echo "✅ Админ добавен успешно.";
