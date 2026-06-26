<?php
require 'db.php';

$message = "";

// Обработка отправленной формы регистрации
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($username !== '' && $password !== '') {
        // Для регистрации используем безопасный prepared statement
        // (уязвимость нам нужна только в форме ЛОГИНА, по заданию атака идёт через авторизацию).
        $stmt = mysqli_prepare($conn, "INSERT INTO users (username, password) VALUES (?, ?)");
        mysqli_stmt_bind_param($stmt, "ss", $username, $password);
        if (mysqli_stmt_execute($stmt)) {
            $message = "Пользователь '$username' зарегистрирован!";
        } else {
            $message = "Ошибка регистрации: " . mysqli_error($conn);
        }
    } else {
        $message = "Заполните все поля.";
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
</head>
<body>
    <h2>Регистрация</h2>
    <form method="POST" action="register.php">
        <p>Логин: <input type="text" name="username"></p>
        <p>Пароль: <input type="text" name="password"></p>
        <p><button type="submit">Зарегистрироваться</button></p>
    </form>
    <p><?php echo htmlspecialchars($message); ?></p>
    <p><a href="login.php">Перейти к авторизации</a></p>
</body>
</html>
