<?php
// Подключение к базе данных
include("./session.php"); // Подключаем session.php
include("../config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получаем данные из формы
    $username = $conn->real_escape_string($_POST['username']); // Используйте real_escape_string для безопасности
    $password = $conn->real_escape_string($_POST['password']); // Используйте real_escape_string для безопасности

    // Запрос к базе данных для проверки пользователя
    $sql = "SELECT * FROM users WHERE login = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Устанавливаем информацию о пользователе в сессии
        $_SESSION['username'] = $user['login'];
        $_SESSION['admin_level'] = $user['admin_level'];

        if ($user['admin_level'] == 1) {
            // Если пользователь - администратор с admin_level 1, перенаправляем на alogin.php
            header("Location: ../alogin.php");
        } else {
            // В противном случае, перенаправляем на zayavka.php
            header("Location: ../zayavka.php");
        }
    } else {
        echo "Неправильный логин или пароль. Попробуйте снова.";
    }
}

$conn->close();


?>