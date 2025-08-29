<?php
$host = 'localhost';
$user = 'admin';
$password = 'ADMIN'; // Добави парола ако имаш
$database = 'admin_dashboard';

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
