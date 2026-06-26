<?php
// Выход: удаляем cookie (ставим срок в прошлом) и возвращаем на login.
setcookie("user", "", time() - 3600, "/");
header("Location: login.php");
exit;
?>
