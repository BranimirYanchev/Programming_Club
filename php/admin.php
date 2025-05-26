<?php
session_start();

// Ако не си логнат или не си админ — няма достъп
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    http_response_code(403);
    echo "⛔ Нямаш достъп до тази страница.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin панел</title>
</head>
<body>
    <h1>👋 Здравей, <?php echo htmlspecialchars($_SESSION["email"]); ?> (Admin)</h1>
    <p>Това е админ панелът.</p>
    <a href="logout.php">Изход</a>
</body>
</html>
