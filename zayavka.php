<?php
include("./modules/session.php"); // Подключаем session.php


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
        <a href="#" class="bg-green-500 px-4 py-2 rounded-lg hover:bg-green-600" id="openModal">Создать заявку</a>
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
<!--Если заявка не найдена-->
    <div id="infoBlock" class="hidden bg-red-500 text-white p-2 rounded mt-4">
        Заявка не найдена
    </div>
    <!-- Карточка для отображения информации о заявке -->
    <div id="infoCard" class="mt-8 hidden">
        <div class="p-6 max-w-sm mx-auto bg-white rounded-xl shadow-md flex items-center space-x-4">
            <!-- Ваши данные о заявке, пример: -->
            <div class="flex-shrink-0">
                <!-- Ваша иконка или изображение (при необходимости) -->
            </div>
            <div>
                <div class="text-xl font-medium text-black" id="appNumber">Заявка №</div>
                <p class="text-gray-500">ID: <span id="appID"></span></p>
                <p class="text-gray-500">ФИО: <span id="appFullName"></span></p>
                <p class="text-gray-500">Номер паспорта: <span id="appPassportNumber"></span></p>
                <p class="text-gray-500">Код подразделения: <span id="appDivisionCode"></span></p>
                <p class="text-gray-500">Адрес регистрации: <span id="appRegistrationAddress"></span></p>
                <p class="text-gray-500">Категория техники: <span id="appCategory"></span></p>
                <p class="text-gray-500">Наименование и модель: <span id="appProductName"></span></p>
                <p class="text-gray-500">Планируемая цена продажи: <span id="appSellingPrice"></span> руб.</p>
                <!-- Статус -->
                <p class="text-xl font-medium" id="appStatus"></p>
            </div>
        </div>
    </div>

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
