<?php
include("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST["full_name"];
    $passport_number = $_POST["passport_number"];
    $division_code = $_POST["division_code"];
    $registration_address = $_POST["registration_address"];
    $category = $_POST['category'];
// $category  содержит выбранное пользователем текстовое значение из выпадающего списка.
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

    // Редирект на главную страницу или другую страницу по вашему выбору
    header("Location: index.php");
}


?>

