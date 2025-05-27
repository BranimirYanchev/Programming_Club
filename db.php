<?php
$host = 'localhost';
$dbname = 'pcb';       // името на базата
$username = 'admin';    // смени на 'admin' ако вече създадеш такъв потребител
$password = 'ADMIN';        // паролата за MySQL root (или за admin)

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // За тест:
    // echo "✅ Свързан с базата успешно!";
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
