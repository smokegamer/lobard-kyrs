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
    // Добавление обработки удаления заявок
    if (isset($_POST['delete_application_id'])) {
        $delete_application_id = $_POST['delete_application_id'];

        // Удаление заявки из базы данных
        $sql = "DELETE FROM applications WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $delete_application_id);
        $stmt->execute();
        $stmt->close();
    }
}

// Получение всех заявок пользователя из базы данных
$statusFilter = isset($_GET['statusFilter']) ? $_GET['statusFilter'] : 'Обработка'; // Получаем выбранный статус из фильтра

$sql = "SELECT * FROM applications WHERE status = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $statusFilter);
$stmt->execute();
$result = $stmt->get_result();



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
    <form method="get"> <!-- Форма для фильтрации -->
        <div class="mb-4">
            <label for="statusFilter" class="block text-sm font-medium text-gray-700">Фильтр по статусу:</label>
            <select id="statusFilter" name="statusFilter" class="bg-white border border-gray-300 rounded-lg py-2 px-4 focus:outline-none" onchange="this.form.submit()">
                <option value="Обработка">Обработка</option>
                <option value="Одобрено">Одобрено</option>
                <option value="Отклонено">Отклонено</option>
            </select>
        </div>
    </form>
    <table class="min-w-full divide-y divide-gray-300">
        <thead>
        <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ФИО</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Паспортные данные</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Код-подразделения</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Адрес регистрации</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Категория товара</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Наименование (марка и модель)</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Моя цена</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Номер заявки</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Статус</th>
        </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-300">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<tr>';

                echo "<td class='px-6 py-4 whitespace-nowrap'>" . $row["full_name"] . "</td>";
                echo "<td class='px-6 py-4 whitespace-nowrap'>" . $row["passport_number"] . "</td>";
                echo "<td class='px-6 py-4 whitespace-nowrap'>" . $row["division_code"] . "</td>";
                echo "<td class='px-6 py-4 whitespace-nowrap'>" . $row["registration_address"] . "</td>";
                echo "<td class='px-6 py-4 whitespace-nowrap'>" . $row["category"] . "</td>";
                echo "<td class='px-6 py-4 whitespace-nowrap'>" . $row["product_name"] . "</td>";
                echo "<td class='px-6 py-4 whitespace-nowrap'>" . $row["selling_price"] . "</td>";
                echo "<td class='px-6 py-4 whitespace-nowrap'>" . $row["application_number"] . "</td>";
                // Добавление столбца "Действия" с кнопкой "Удалить"
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
                echo '<form method="post" action="alogin.php">';
                echo '<input type="hidden" name="delete_application_id" value="' . $row['id'] . '">';
                echo '<button type="submit" class="bg-red-500 text-white py-2 px-4 rounded-lg hover:bg-red-600">Удалить</button>';
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
