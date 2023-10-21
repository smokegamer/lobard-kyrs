<?php
include("./modules/session.php"); // Подключаем session.php
include("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isUserAuthenticated()) {
        // Пользователь не авторизован, выведите сообщение и завершите выполнение
        $response = array('message' => 'Пользователь не авторизован. Пожалуйста, войдите.');
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }

    // Получите `username` (логин) из сессии
    $username = getUsername();

    // Получите `user_id` на основе логина пользователя
    $user_id = getUserIdFromUsername($username);

    if ($user_id === false) {
        // Ошибка: не удалось найти `user_id` для данного пользователя
        $response = array('message' => 'Не удалось найти информацию о пользователе.');
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }

    // Здесь продолжите обработку заявки, как раньше
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

    $sql = "INSERT INTO applications (full_name, passport_number, division_code, registration_address, category, product_name, selling_price, application_number, status, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssdsd", $full_name, $passport_number, $division_code, $registration_address, $category, $product_name, $selling_price, $application_number, $status, $user_id);
    $stmt->execute();

    // Закрываем подготовленное выражение
    $stmt->close();

    // Формируем JSON-ответ
    $response = array(
        'message' => 'Заявка успешно отправлена',
        'application_number' => $application_number
    );

    // Отправьте данные в формате JSON
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // Если метод запроса не POST, выведите сообщение об ошибке
    $response = array('message' => 'Недопустимый метод запроса');
    header('Content-Type: application/json');
    echo json_encode($response);
}

// Функция для получения `user_id` на основе логина пользователя
function getUserIdFromUsername($username) {
    global $conn;
    $sql = "SELECT id FROM users WHERE login = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        return $row['id'];
    }
    return false; // Если не удалось найти `user_id`
}
?>
