<?php
// Подключение к базе данных

include("./session.php"); // Подключаем session.php


include("../config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получаем данные из формы
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Запрос к базе данных для проверки пользователя
    $sql = "SELECT * FROM users WHERE login = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Устанавливаем информацию о пользователе в сессии
        $_SESSION['username'] = $user['login'];
        $_SESSION['admin_level'] = $user['admin_level'];

        // Перенаправляем пользователя на нужную страницу, например, на страницу zayavka.php
        header("Location: ../zayavka.php");
    } else {
        echo "Неправильный логин или пароль. Попробуйте снова.";
    }
}

$conn->close();
?>

