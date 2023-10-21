<?php
include("./modules/session.php"); // Подключаем session.php

// Проверяем, авторизован ли пользователь
if (!isUserAuthenticated()) {
    // Если пользователь не авторизован, перенаправляем его на страницу авторизации
    header("Location: login.php");
    exit;
}
// Получите `username` (логин) из сессии
$username = getUsername();

// Получите `user_id` на основе логина пользователя
$user_id = getUserIdFromUsername1($username);

// Получаем user_id из сессии (предполагая, что оно там сохранено)


// Подключаемся к базе данных (замените данными вашей БД)
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "lombard";

// Создаем соединение
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверяем соединение на ошибки
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

// Формируем SQL-запрос для получения заявок текущего пользователя
$sql = "SELECT * FROM applications WHERE user_id = $user_id";
$result = $conn->query($sql);


function getUserIdFromUsername1($username) {
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
            <li><a href="./zayavka.php" class="hover:text-green-500">Заявки</a></li>
            <?php
            if (isUserAuthenticated()) {
                // Отображение кнопки "Выход"
                echo '<li><a href="./logout.php" class="bg-red-500 px-4 py-2 rounded-lg hover:bg-red-600">Выйти</a></li>';
            } else {
                // Отображение кнопки "Личный кабинет" для неаутентифицированных пользователей
                echo '<li><a href="./login.php" class="bg-blue-500 px-4 py-2 rounded-lg hover:bg-blue-600">Личный кабинет</a></li>';
            }
            ?>
        </ul>
<!--        <a href="#" class="bg-green-500 px-4 py-2 rounded-lg hover:bg-green-600" id="openModal">Создать заявку</a>-->
    </div>
</nav>


<div class="container mx-auto mt-8">
    <h1 class="text-3xl font-semibold mb-4">Просмотр заявки</h1>

    <!-- Минималистичный блок с информацией -->
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <p class="text-gray-600">Здесь будет отображаться информация о заявке. Для того чтобы найти свою заявку введите ранее полученный код заявки состоящий из 9 цифр.</p>
    </div>

    <!-- Поиск и кнопка поиска -->
    <div class="mt-8 flex items-center">
        <input id="searchInput" type="text" class="w-2/3 border border-gray-300 rounded-l-lg py-2 px-4 focus:outline-none" placeholder="Номер заявки">
        <button id="searchButton" class="bg-blue-500 text-white py-2 px-4 rounded-r-lg hover:bg-blue-600">Поиск</button>
    </div>
    <br>
    <br>
    <?php if ($result->num_rows == 0) : ?>
        <div id="infoBlock" class="bg-red-500 text-white p-2 rounded mt-4">
            У вас пока нет заявок.
        </div>
    <?php else : ?>
        <!-- Таблица для отображения заявок -->
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
        // Выводим заявки в виде таблицы
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td class='px-6 py-4 whitespace-nowrap'>" . $row["full_name"] . "</td>";
            echo "<td class='px-6 py-4 whitespace-nowrap'>" . $row["passport_number"] . "</td>";
            echo "<td class='px-6 py-4 whitespace-nowrap'>" . $row["division_code"] . "</td>";
            echo "<td class='px-6 py-4 whitespace-nowrap'>" . $row["registration_address"] . "</td>";
            echo "<td class='px-6 py-4 whitespace-nowrap'>" . $row["category"] . "</td>";
            echo "<td class='px-6 py-4 whitespace-nowrap'>" . $row["product_name"] . "</td>";
            echo "<td class='px-6 py-4 whitespace-nowrap'>" . $row["selling_price"] . "</td>";
            echo "<td class='px-6 py-4 whitespace-nowrap'>" . $row["application_number"] . "</td>";
            // Окраска фона столбца статуса
            $statusClass = '';
            if ($row["status"] === "Одобрено") {
                $statusClass = 'bg-green-200 text-green-800';
            } elseif ($row["status"] === "Отклонено") {
                $statusClass = 'bg-red-200 text-red-800';
            } elseif ($row["status"] === "Обработка") {
                $statusClass = 'bg-blue-200 text-blue-800';
            }

            echo "<td class='px-6 py-4 whitespace-nowrap $statusClass'>" . $row["status"] . "</td>";
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>
    <?php endif; ?>

    <script>
        const searchButton = document.getElementById('searchButton');
        const searchInput = document.getElementById('searchInput');
        const infoCard = document.getElementById('infoCard');
        const appNumber = document.getElementById('appNumber');
        const appID = document.getElementById('appID');
        const appFullName = document.getElementById('appFullName');
        const appPassportNumber = document.getElementById('appPassportNumber');
        const appDivisionCode = document.getElementById('appDivisionCode');
        const appRegistrationAddress = document.getElementById('appRegistrationAddress');
        const appCategory = document.getElementById('appCategory');
        const appProductName = document.getElementById('appProductName');
        const appSellingPrice = document.getElementById('appSellingPrice');
        const appStatus = document.getElementById('appStatus');
        const infoBlock = document.getElementById('infoBlock');

        searchButton.addEventListener('click', () => {
            // Выполняем поиск по номеру заявки
            const applicationNumber = searchInput.value;

            // Здесь можно выполнить AJAX-запрос к вашему API (api.php) для получения информации о заявке
            // Пример:
            fetch(`./modules/api.php?applicationNumber=${applicationNumber}`)
                .then(response => response.json())
                .then(data => {
                    if (data.id) {
                        // Если заявка найдена, заполняем карточку данными
                        infoBlock.style.display = 'none';
                        infoCard.style.display = 'block';
                        appNumber.textContent = `Заявка № ${data.application_number}`;
                        appID.textContent = data.id;
                        appFullName.textContent = data.full_name;
                        appPassportNumber.textContent = data.passport_number;
                        appDivisionCode.textContent = data.division_code;
                        appRegistrationAddress.textContent = data.registration_address;
                        appCategory.textContent = data.category;
                        appProductName.textContent = data.product_name;
                        appSellingPrice.textContent = `${data.selling_price} руб.`;

                        // Статус
                        appStatus.textContent = data.status;
                        // Устанавливаем класс в зависимости от значения статуса
                        if (data.status === "Обработка") {
                            appStatus.classList.add('bg-blue-500', 'text-white', 'rounded-full', 'px-2', 'py-1', 'text-xs', 'font-semibold');
                        } else if (data.status === "Одобрено") {
                            appStatus.classList.add('bg-green-500', 'text-white', 'rounded-full', 'px-2', 'py-1', 'text-xs', 'font-semibold');
                        } else if (data.status === "Отказано") {
                            appStatus.classList.add('bg-red-500', 'text-white', 'rounded-full', 'px-2', 'py-1', 'text-xs', 'font-semibold');
                        }
                    } else {
                        // Если заявка не найдена, показываем сообщение об ошибке
                        infoCard.style.display = 'none';
                        infoBlock.style.display = 'block'; // Была ошибка здесь
                    }
                })
                .catch(error => console.error(error));
        });
    </script>


</div>
<br>
<br>
<br>
<p class="text-center text-gray-700">
    Вся представленная на этой странице информация является вымышленной и используется исключительно в демонстрационных целях. Никакие реальные данные или события не связаны с этим контентом.
</p>
</body>
</html>
