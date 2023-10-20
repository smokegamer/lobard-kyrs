<?php

include("./modules/session.php"); // Подключаем session.php

include("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // значения модаьльного окна
    $full_name = $_POST["full_name"];
    $passport_number = $_POST["passport_number"];
    $division_code = $_POST["division_code"];
    $registration_address = $_POST["registration_address"];
    $category = $_POST['category'];
    $product_name = $_POST["product_name"];
    $selling_price = $_POST["selling_price"];

    // Генерация случайного номера заявки
    function generateRandomNumber() {
        $number = rand(100000000, 999999999); // Генерируем случайное девятизначное число
        return $number;
    }

    $application_number = generateRandomNumber();

    // Присваивание статуса "Обработка" по умолчанию
    $status = "Обработка";

    $sql = "INSERT INTO applications (full_name, passport_number, division_code, registration_address, category, product_name, selling_price, application_number, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssds", $full_name, $passport_number, $division_code, $registration_address, $category, $product_name, $selling_price, $application_number, $status);
    $stmt->execute();

    // Закрываем подготовленное выражение
    $stmt->close();

    // Создание учетной записи пользователя
    $login = mt_rand(1000, 999999999);
    $password = generateRandomPassword(12);

    $userSql = "INSERT INTO users (login, password) VALUES (?, ?)";
    $userStmt = $conn->prepare($userSql);
    $userStmt->bind_param("ss", $login, $password);
    $userStmt->execute();

    // Закрываем подготовленное выражение для учетной записи
    $userStmt->close();

    // Отправка номера заявки, логина и пароля на клиентскую сторону для отображения

}

function generateRandomPassword($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $password = '';
    $charLength = strlen($characters);

    for ($i = 0; $i < $length; $i++) {
        $password .= $characters[rand(0, $charLength - 1)];
    }

    return $password;
    header("Location: index.php");

}
$responseData = array(
    'application_number' => $application_number,
    'login' => $login,
    'password' => $password
);

// Отправьте данные в формате JSON
header('Content-Type: application/json');
echo json_encode($responseData);

?>
