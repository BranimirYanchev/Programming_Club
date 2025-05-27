<?php
session_start();

// Проверка дали админът е логнат
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
</head>
<body>
    <h1>Добре дошъл, <?php echo htmlspecialchars($_SESSION['admin_email']); ?>!</h1>
    <p>Това е защитена админ страница.</p>

    <form method="post" action="logout.php">
        <input type="submit" value="Изход">
    </form>
</body>
</html>
