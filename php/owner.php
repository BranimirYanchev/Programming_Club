<?php
session_start();

// Ако не си логнат или не си owner — няма достъп
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "owner") {
    http_response_code(403);
    echo "⛔ Нямаш достъп до тази страница.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Owner панел</title>
</head>
<body>
    <h1>👑 Здравей, <?php echo htmlspecialchars($_SESSION["email"]); ?> (Owner)</h1>
    <p>Това е owner панелът.</p>
    <a href="logout.php">Изход</a>
</body>
</html>
