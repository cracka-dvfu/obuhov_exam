<?php
// ===== СТРАНИЦА ПРИВЕТСТВИЯ (пункты задания 1.4 + 1.3) =====
// Доступ только после авторизации: проверяем cookie 'user'.
// Если cookie нет — пользователь не входил, отправляем на login.

if (!isset($_COOKIE['user'])) {
    header("Location: login.php");
    exit;
}

$username = $_COOKIE['user'];
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Приветствие</title>
</head>
<body>
    <!-- Имя пользователя берётся из переменной (cookie авторизованного пользователя) -->
    <h1>Привет, <?php echo htmlspecialchars($username); ?></h1>
    <p><a href="logout.php">Выйти</a></p>
</body>
</html>
