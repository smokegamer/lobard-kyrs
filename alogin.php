<?php
include("./modules/session.php"); // Подключаем session.php
include("./config.php");

// Проверка аутентификации пользователя
if (!isUserAuthenticated()) {
    header("Location: login.php"); // Перенаправляем на страницу входа, если пользователь не аутентифицирован
    exit;
}

// Обработка изменения статусов заявок
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['application_id']) && isset($_POST['new_status'])) {
        $application_id = $_POST['application_id'];
        $new_status = $_POST['new_status'];

        // Проверка, что новый статус является допустимым значением
        if ($new_status === "Одобрено" || $new_status === "Отклонено") {
            // Обновляем статус заявки в базе данных
            $sql = "UPDATE applications SET status = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $new_status, $application_id);
            $stmt->execute();
            $stmt->close();
        }
    }
}

// Получение всех заявок пользователя из базы данных
$sql = "SELECT * FROM applications WHERE status = 'Обработка'";
$result = $conn->query($sql);

// Отображение HTML
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="assets/tailwind.css" rel="stylesheet">
    <title>Заявки</title>
</head>
<body>
<nav class="bg-gray-800 text-white py-4">
    <div class="container mx-auto flex justify-between items-center">
        <ul class="flex space-x-6">
            <li><a href="/" class="hover:text-green-500">Главная</a></li>
            <li><a href="documents.php" class="hover:text-green-500">Документы</a></li>
            <li><a href="zayavka.php" class="hover:text-green-500">Заявки</a></li>
            <?php
            if (isUserAuthenticated()) {
                echo '<li><a href="logout.php" class="bg-red-500 px-4 py-2 rounded-lg hover:bg-red-600">Выход</a></li>';
            } else {
                echo '<li><a href="login.php" class="bg-blue-500 px-4 py-2 rounded-lg hover:bg-blue-600">Личный кабинет</a></li>';
            }
            ?>
        </ul>
<!--        <a href="#" class="bg-green-500 px-4 py-2 rounded-lg hover:bg-green-600" id="openModal">Создать заявку</a>-->
    </div>
</nav>

<div class="container mx-auto mt-8">
    <h1 class="text-3xl font-semibold mb-4">Заявки</h1>

    <table class="table-auto w-full">
        <thead>
        <tr>
            <th class="px-4 py-2">ID</th>
            <th class="px-4 py-2">ФИО</th>
            <th class="px-4 py-2">Статус</th>
            <th class="px-4 py-2">Действия</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td class="border px-4 py-2">' . $row['id'] . '</td>';
                echo '<td class="border px-4 py-2">' . $row['full_name'] . '</td>';
                echo '<td class="border px-4 py-2">' . $row['status'] . '</td>';
                echo '<td class="border px-4 py-2">';
                echo '<form method="post" action="alogin.php">';
                echo '<input type="hidden" name="application_id" value="' . $row['id'] . '">';
                echo '<select name="new_status" class="bg-white border border-gray-300 rounded-lg py-2 px-4 focus:outline-none">';
                echo '<option value="Обработка">Обработка</option>';
                echo '<option value="Одобрено">Одобрено</option>';
                echo '<option value="Отклонено">Отклонено</option>';
                echo '</select>';
                echo '<button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600">Сохранить</button>';
                echo '</form>';
                echo '</td>';
                echo '</tr>';
            }
        } else {
            echo '<tr><td class="border px-4 py-2" colspan="4">Заявки с статусом "Обработка" не найдены.</td></tr>';
        }
        ?>
        </tbody>
    </table>
</div>
</body>
</html>
