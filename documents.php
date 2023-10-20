<?php
include("./modules/session.php"); // Подключаем session.php


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Моя страница документации</title>
    <link href="assets/tailwind.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
<!-- Навигация -->
<nav class="bg-gray-800 text-white py-4">
    <div class="container mx-auto flex justify-between items-center">
        <ul class="flex space-x-6">
            <li><a href="/" class="hover:text-green-500">Главная</a></li>
            <li><a href="documents.php" class="hover:text-green-500">Документы</a></li>
            <li><a href="zayavka.php" class="hover:text-green-500">Заявки</a></li>
            <?php
            if (isUserAuthenticated()) { // Проверка аутентификации пользователя
                echo '<li><a href="logout.php" class="bg-red-500 px-4 py-2 rounded-lg hover:bg-red-600">Выход</a></li>';
            } else {
                echo '<li><a href="login.php" class="bg-blue-500 px-4 py-2 rounded-lg hover:bg-blue-600">Личный кабинет</a></li>';
            }
            ?>
        </ul>
<!--        <a href="#" class="bg-green-500 px-4 py-2 rounded-lg hover:bg-green-600" id="openModal">Создать заявку</a>-->
    </div>
</nav>

<div class="container mx-auto p-4 mt-8">
    <section class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold mb-4">Документы и договоры</h2>
        <div class="grid grid-cols-2 gap-4">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-gray-300 rounded-full mr-4"></div>
                <div>
                    <h3 class="text-lg font-semibold">Договор</h3>
                    <p class="text-gray-700">Какой-то договор</p>
                </div>
            </div>
            <div class="flex items-center">
                <div class="w-10 h-10 bg-gray-300 rounded-full mr-4"></div>
                <div>
                    <h3 class="text-lg font-semibold">Договор займа</h3>
                    <p class="text-gray-700">Описание займа и типовой договор</p>
                </div>
            </div>
            <div class="flex items-center">
                <div class="w-10 h-10 bg-gray-300 rounded-full mr-4"></div>
                <div>
                    <h3 class="text-lg font-semibold">О ломбарде</h3>
                    <p class="text-gray-700">Правовая информация</p>
                </div>
            </div>
            <div class="flex items-center">
                <div class="w-10 h-10 bg-gray-300 rounded-full mr-4"></div>
                <div>
                    <h3 class="text-lg font-semibold">Согласие на обработку данных</h3>
                    <p class="text-gray-700">ФЗ об обработке данных </p>
                </div>
            </div>
            <div class="flex items-center">
                <div class="w-10 h-10 bg-gray-300 rounded-full mr-4"></div>
                <div>
                    <h3 class="text-lg font-semibold">Что-то еще</h3>
                    <p class="text-gray-700">Информация типо </p>
                </div>
            </div>
            <div class="flex items-center">
                <div class="w-10 h-10 bg-gray-300 rounded-full mr-4"></div>
                <div>
                    <h3 class="text-lg font-semibold">ЧТо то еще из документов</h3>
                    <p class="text-gray-700">Информация </p>
                </div>
            </div>
        </div>
    </section>
</div>
<p class="text-center text-gray-700">
    Вся представленная на этой странице информация является вымышленной и используется исключительно в демонстрационных целях. Никакие реальные данные или события не связаны с этим контентом.
</p>

</body>
</html>

