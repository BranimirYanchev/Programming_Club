<?php
session_start();
require 'db.php';

// Ако вече е логнат, пренасочи към дашборда
if (isset($_SESSION['email']) && isset($_SESSION['role'])) {
    header("Location: admin-dashboard.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];
            header("Location: admin-dashboard.php");
            exit();
        } else {
            $error = "Невалидна парола!";
        }
    } else {
        $error = "Имейлът не съществува!";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <title>Клуб по програмиране "По същество" | Благоевград | Admin Login</title>
    <link rel="stylesheet" href="style.css">
      <!-- Favicons -->
  <link rel="icon" type="image/x-icon" href="/assets/favicon.ico">
    <style>
      body {
        min-height: 100vh;
        margin: 0;
        padding: 0;
        font-family: 'Segoe UI', Arial, sans-serif;
        background: #2193b0;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
      }

      /* Animated background circles */
      .bg-circles {
        position: fixed;
        top: 0; left: 0;
        width: 100vw; height: 100vh;
        z-index: 0;
        pointer-events: none;
        overflow: hidden;
      }
      .bg-circles span {
        position: absolute;
        display: block;
        border-radius: 50%;
        opacity: 0.25;
        animation: move 16s linear infinite;
      }
      .bg-circles span:nth-child(1) {
        width: 120px; height: 120px; background: #6dd5ed;
        left: 10vw; top: 20vh; animation-duration: 18s;
      }
      .bg-circles span:nth-child(2) {
        width: 80px; height: 80px; background: #2193b0;
        left: 70vw; top: 60vh; animation-duration: 14s;
      }
      .bg-circles span:nth-child(3) {
        width: 100px; height: 100px; background: #6dd5ed;
        left: 50vw; top: 80vh; animation-duration: 20s;
      }
      .bg-circles span:nth-child(4) {
        width: 60px; height: 60px; background: #2193b0;
        left: 80vw; top: 30vh; animation-duration: 12s;
      }
      .bg-circles span:nth-child(5) {
        width: 90px; height: 90px; background: #6dd5ed;
        left: 30vw; top: 70vh; animation-duration: 16s;
      }
      @keyframes move {
        0% { transform: translateY(0) scale(1);}
        50% { transform: translateY(-40px) scale(1.1);}
        100% { transform: translateY(0) scale(1);}
      }

      /* BG animated objects */
      .bg-objects {
        position: fixed;
        top: 0; left: 0;
        width: 100vw; height: 100vh;
        z-index: 0;
        pointer-events: none;
      }
      .bg-object {
        position: absolute;
        opacity: 0.18;
        animation: float3d 18s infinite cubic-bezier(.68,-0.55,.27,1.55);
        will-change: transform;
        filter: drop-shadow(0 0 18px #2193b044);
      }
      .bg-object.laptop { animation-delay: 2s; }
      .bg-object.code { animation-delay: 5s; }
      .bg-object.mouse { animation-delay: 8s; }
      .bg-object.chip { animation-delay: 11s; }

      @keyframes float3d {
        0%   { transform: translateY(0) scale(1) rotateY(0deg) rotateZ(0deg);}
        25%  { transform: translateY(-30px) scale(1.08) rotateY(20deg) rotateZ(10deg);}
        50%  { transform: translateY(-60px) scale(1.12) rotateY(40deg) rotateZ(20deg);}
        75%  { transform: translateY(-30px) scale(1.08) rotateY(20deg) rotateZ(10deg);}
        100% { transform: translateY(0) scale(1) rotateY(0deg) rotateZ(0deg);}
      }

      /* Animate login-container */
      .login-container {
        animation: fadeInUp 1s cubic-bezier(.68,-0.55,.27,1.55);
      }
      @keyframes fadeInUp {
        0% { opacity: 0; transform: translateY(40px) scale(0.98);}
        100% { opacity: 1; transform: translateY(0) scale(1);}
      }

      /* Animate logo-circle */
      .logo-circle {
        animation: popIn 1.2s cubic-bezier(.68,-0.55,.27,1.55);
      }
      @keyframes popIn {
        0% { opacity: 0; transform: scale(0.5) translateX(-50%);}
        80% { opacity: 1; transform: scale(1.1) translateX(-50%);}
        100% { opacity: 1; transform: scale(1) translateX(-50%);}
      }

      .login-container {
        width: 100%;
        max-width: 370px;
        background: rgba(255,255,255,0.95);
        padding: 40px 32px 32px 32px;
        border-radius: 16px;
        box-shadow: 0 8px 32px rgba(33,147,176,0.18);
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
      }

      .login-container form {
        width: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
      }

      .login-container h2 {
        width: 100%;
        text-align: center;
      }

      .login-container input {
        width: 90%;
        max-width: 260px;
        padding: 12px;
        margin: 10px 0 18px 0;
        border: 1.5px solid #b2ebf2;
        border-radius: 8px;
        font-size: 16px;
        background: #f7fbfc;
        transition: border-color 0.3s, box-shadow 0.3s, transform 0.2s;
        box-shadow: 0 2px 8px rgba(33,147,176,0.07);
        text-align: center;
        outline: none;
      }

      .login-container input:focus {
        border-color: #2193b0;
        box-shadow: 0 0 12px #6dd5ed55;
        transform: scale(1.04);
      }

      .login-container button {
        width: 90%;
        max-width: 260px;
        padding: 12px;
        background: linear-gradient(90deg, #2193b0 0%, #6dd5ed 100%);
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 17px;
        font-weight: 500;
        cursor: pointer;
        box-shadow: 0 2px 8px rgba(33,147,176,0.10);
        transition: background 0.3s, transform 0.2s, box-shadow 0.3s;
        margin-bottom: 8px;
        text-align: center;
      }

      .login-container button:hover, .login-container button:focus {
        background: linear-gradient(90deg, #6dd5ed 0%, #2193b0 100%);
        transform: scale(1.05);
        box-shadow: 0 4px 16px #2193b055;
      }

      .logo-circle {
        position: absolute;
        top: -45px;
        left: 50%;
        transform: translateX(-50%);
        width: 90px;
        height: 90px;
        background: #2193b0;
        border-radius: 50%;
        box-shadow: 0 4px 16px rgba(33,147,176,0.25);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        z-index: 2;
      }
      .logo-circle img {
        width: 78px;
        height: 78px;
        object-fit: contain;
        border-radius: 50%;
        background: white;
        border: 2px solid #e0f7fa; /* по-тънък бордър */
      }

      h2 {
        text-align: center;
        margin-bottom: 24px;
        font-weight: 600;
        color: #2193b0;
        letter-spacing: 1px;
        z-index: 1;
      }

      .error {
        color: #e53935;
        text-align: center;
        margin-bottom: 10px;
        font-weight: 500;
      }

      .success {
        color: #43a047;
        text-align: center;
        margin-bottom: 10px;
        font-weight: 500;
      }

      @media (max-width: 500px) {
        .login-container {
          max-width: 95vw;
          padding: 32px 8vw 24px 8vw;
        }
        .logo-circle {
          width: 80px;
          height: 80px;
          top: -35px;
        }
        .logo-circle img {
          width: 60px;
          height: 60px;
        }
      }
    </style>
</head>
<body>
<div class="bg-circles">
  <span></span>
  <span></span>
  <span></span>
  <span></span>
  <span></span>
</div>
<div class="bg-objects">
  <!-- Лаптоп SVG -->
  <div class="bg-object laptop" style="left:12vw;top:65vh;">
    <svg width="60" height="40" viewBox="0 0 60 40" fill="none">
      <rect x="5" y="10" width="50" height="20" rx="3" fill="#2193b0"/>
      <rect x="10" y="15" width="40" height="10" rx="2" fill="#fff"/>
      <rect x="0" y="30" width="60" height="7" rx="2" fill="#6dd5ed"/>
    </svg>
  </div>
  <!-- Код SVG -->
  <div class="bg-object code" style="left:80vw;top:15vh;">
    <svg width="50" height="50" viewBox="0 0 50 50" fill="none">
      <rect x="10" y="10" width="30" height="30" rx="6" fill="#fff"/>
      <text x="25" y="32" text-anchor="middle" font-size="18" fill="#2193b0">&lt;/&gt;</text>
    </svg>
  </div>
  <!-- Мишка SVG -->
  <div class="bg-object mouse" style="left:60vw;top:75vh;">
    <svg width="32" height="50" viewBox="0 0 32 50" fill="none">
      <rect x="4" y="4" width="24" height="42" rx="12" fill="#6dd5ed"/>
      <rect x="12" y="10" width="8" height="10" rx="4" fill="#2193b0"/>
    </svg>
  </div>
  <!-- Чип SVG -->
  <div class="bg-object chip" style="left:25vw;top:10vh;">
    <svg width="40" height="40" viewBox="0 0 40 40" fill="none">
      <rect x="8" y="8" width="24" height="24" rx="6" fill="#2193b0"/>
      <rect x="14" y="14" width="12" height="12" rx="3" fill="#fff"/>
    </svg>
  </div>
</div>
<div class="login-container">
    <div class="logo-circle">
      <img src="assets/logo.png" alt="Клуб Лого">
    </div>
    <form method="POST" action="">
        <h2>Влезте в админ панела</h2>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <input type="email" name="email" placeholder="Имейл" required>
        <input type="password" name="password" placeholder="Парола" required>
        <button type="submit">Влез</button>
    </form>
</div>
</body>
</html>
