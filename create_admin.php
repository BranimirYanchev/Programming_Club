<?php
require_once 'db.php';

$email = 'admin@pcb.com';
$password = password_hash('admin123', PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO admins (email, password) VALUES (:email, :password)");
$stmt->bindParam(':email', $email);
$stmt->bindParam(':password', $password);
$stmt->execute();

echo "Админ потребител създаден.";
?>
