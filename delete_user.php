<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'owner') {
    header("Location: admins.php");
    exit;
}

if (isset($_POST['user_id'])) {
    $user_id = intval($_POST['user_id']);

    // Премахни проверката за owner акаунт
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->close();
}

header("Location: admins.php");
exit;