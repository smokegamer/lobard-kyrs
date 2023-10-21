<?php
include("session.php"); // Подключаем session.php
include("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получите данные из формы регистрации
    $newUsername = $_POST["newUsername"];
    $newPassword = $_POST["newPassword"];

    // Проверка наличия пользователя с таким логином в базе данных
    $sql = "SELECT id FROM users WHERE login = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $newUsername);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Пользователь с таким логином уже существует
        $response = array('message' => 'Пользователь с таким логином уже существует.');
    } else {
        // Вставка новой записи в таблицу users
        $sql = "INSERT INTO users (login, password, admin_level) VALUES (?, ?, 0)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $newUsername, $newPassword); // Сохраняем пароль как текстовую строку

        if ($stmt->execute()) {
            // Регистрация успешно завершена
            $response = array('message' => 'Регистрация успешно завершена. Вы можете войти.');
            header('Location: ../login.php');
            exit; //
        } else {
            // Ошибка при регистрации
            $response = array('message' => 'Ошибка при регистрации. Пожалуйста, попробуйте ещё раз.');
        }
    }

    // Отправьте ответ в формате JSON
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // Если метод запроса не POST, выведите сообщение об ошибке
    $response = array('message' => 'Недопустимый метод запроса');
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
