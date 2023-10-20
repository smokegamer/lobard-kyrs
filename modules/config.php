<?php
$hostname = "127.0.0.1"; // по умолчанию 127.0.0.1 либо localhost
$username = "root"; // логин по умолчанию root
$password = ""; // пароль по умолчанию отключен
$database = "lombard";  // название бд , дамп прилагаю

$conn = new mysqli($hostname, $username, $password, $database);
if ($conn->connect_error) {
    die("Ошибка подключения к базе данных: " . $conn->connect_error);
}
?>

