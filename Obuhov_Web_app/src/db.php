<?php
// Подключение к базе данных MySQL.
// Хост 'db' — это имя контейнера БД из docker-compose (Docker сам резолвит его в IP).

$host = "db";
$user = "root";
$pass = "rootpass";
$dbname = "obuhov_db";

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Ошибка подключения к БД: " . mysqli_connect_error());
}
?>
