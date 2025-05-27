<?php
session_start();
require_once 'db.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    if (!empty($email) && !empty($password)) {
        $stmt = $conn->prepare("SELECT * FROM admins WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin) {
            if (password_verify($password, $admin['password'])) {
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_email'] = $admin['email'];
                header("Location: admin-dashboard.php");
                exit();
            } else {
                $error = "Грешна парола.";
            }
        } else {
            $error = "Имейл не е намерен.";
        }
    } else {
        $error = "Моля, попълнете всички полета.";
    }
}
?>

<!DOCTYPE html>
<html lang="bg">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Админ | PCB</title>
  <link rel="stylesheet" href="assets/css/admin.css" />
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
  />
  <link href="assets/img/favicon.png" rel="icon" />
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon" />
</head>
<body>
  <div class="wrapper">
    <header>Админ</header>
    <?php if ($error): ?>
      <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <form method="post" action="admin.php">
      <div class="field email">
        <div class="input-area">
          <input
            type="email"
            name="email"
            placeholder="Имейл"
            required
          />
          <i class="icon fas fa-envelope"></i>
          <i class="error error-icon fas fa-exclamation-circle"></i>
        </div>
        <div class="error error-txt">Въведи имейл!</div>
      </div>
      <div class="field password">
        <div class="input-area">
          <input
            type="password"
            name="password"
            placeholder="Парола"
            required
          />
          <i class="icon fas fa-lock"></i>
          <i class="error error-icon fas fa-exclamation-circle"></i>
        </div>
        <div class="error error-txt">Въведи парола!</div>
      </div>
      <input type="submit" value="Влез" />
    </form>
  </div>
  <script src="assets/js/admin.js"></script>
</body>
</html>
