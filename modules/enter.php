<?php
// Подключение к базе данных
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
        $admin_level = $user['admin_level'];

        // Проверка admin_level
        if ($admin_level == 0) {
            header("Location: ../zayavka.php"); // Перенаправление на страницу zayavka.php для обычных пользователей
        } elseif ($admin_level == 1) {
            // Ваш код для администратора
        } else {
            // Обработка других уровней доступа
        }
    } else {
        echo "Неправильный логин или пароль. Попробуйте снова.";
    }
}

$conn->close();
?>

