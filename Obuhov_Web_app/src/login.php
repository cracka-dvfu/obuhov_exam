<?php
require 'db.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // ===== УЯЗВИМОЕ МЕСТО (SQL-инъекция) =====
    // Ввод пользователя вставляется в запрос напрямую, без экранирования.
    // Это позволяет провести SQLi через форму авторизации (пункт задания 3.1).
    // Примеры атаки:
    //   Обход авторизации:  username = admin' --
    //   UNION для извлечения данных:
    //     ' UNION SELECT 1,database(),3 --
    //     ' UNION SELECT 1,table_name,3 FROM information_schema.tables WHERE table_schema=database() --
    //     ' UNION SELECT id,username,password FROM users --
    $sql = "SELECT id, username, password FROM users WHERE username='$username' AND password='$password'";

    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        // Берём первую строку результата.
        // При обычном входе это реальный пользователь.
        // При UNION-инъекции сюда попадут извлечённые данные — и они отобразятся
        // на странице приветствия, что и демонстрирует утечку.
        $row = mysqli_fetch_assoc($result);
        $loggedUser = $row['username'];

        // ===== COOKIE (пункт задания 1.3) =====
        // Ставим cookie с именем авторизованного пользователя на 1 час.
        setcookie("user", $loggedUser, time() + 3600, "/");

        // Переходим на страницу приветствия
        header("Location: welcome.php");
        exit;
    } else {
        $message = "Неверный логин или пароль.";
        if ($result === false) {
            // Показываем ошибку SQL — помогает при подборе UNION-инъекции
            $message .= " (SQL error: " . mysqli_error($conn) . ")";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Авторизация</title>
</head>
<body>
    <h2>Авторизация</h2>
    <form method="POST" action="login.php">
        <p>Логин: <input type="text" name="username"></p>
        <p>Пароль: <input type="text" name="password"></p>
        <p><button type="submit">Войти</button></p>
    </form>
    <p style="color:red;"><?php echo $message; ?></p>
    <p><a href="register.php">Регистрация</a></p>
</body>
</html>
