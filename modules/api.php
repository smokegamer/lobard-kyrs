<?php
include("../config.php");

// Функция для получения информации о заявке по номеру
function getApplicationByNumber($conn, $applicationNumber) {
    $sql = "SELECT * FROM applications WHERE application_number = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $applicationNumber);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();
    return $row;
}

// Получение номера заявки из запроса
if (isset($_GET["applicationNumber"])) {
    $applicationNumber = $_GET["applicationNumber"];

    // Поиск заявки по номеру
    $application = getApplicationByNumber($conn, $applicationNumber);

    if ($application) {
        // Успешно найдено
        $status = $application["status"];
        $statusColor = "";

        if ($status == "Обработка") {
            $statusColor = "bg-blue-500";
        } elseif ($status == "Отклонено") {
            $statusColor = "bg-red-500";
        } elseif ($status == "Одобрено") {
            $statusColor = "bg-green-500";
        }

        // Формирование ответа в формате JSON
        $response = [
            "id" => $application["id"],
            "full_name" => $application["full_name"],
            "passport_number" => $application["passport_number"],
            "division_code" => $application["division_code"],
            "registration_address" => $application["registration_address"],
            "category" => $application["category"],
            "product_name" => $application["product_name"],
            "selling_price" => $application["selling_price"],
            "application_number" => $application["application_number"],
            "status" => $status,
            "statusColor" => $statusColor
        ];

        // Отправка ответа в формате JSON
        header("Content-Type: application/json");
        echo json_encode($response);
    } else {
        // Заявка не найдена
        header("HTTP/1.1 404 Not Found");
        echo json_encode(["error" => "Заявка не найдена"]);
    }
} else {
    // Номер заявки не указан
    header("HTTP/1.1 400 Bad Request");
    echo json_encode(["error" => "Номер заявки не указан"]);
}

// Закрытие соединения с базой данных
$conn->close();
