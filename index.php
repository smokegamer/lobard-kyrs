<?php
include("./modules/session.php"); // Подключаем session.php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ломбард</title>
    <link href="assets/tailwind.css" rel="stylesheet">
    <link href="./assets/modal.css" rel="stylesheet">
    <style>
        .chart {
            width: 100%;
            height: 10px
            background-color: #a4a89e;
            position: relative;
            transition: width 1s ease-in-out;
        }

        li {
            margin-bottom: 10px;
        }

    </style>



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
        <a href="#" class="bg-green-500 px-4 py-2 rounded-lg hover:bg-green-600" id="openModal">Создать заявку</a>
    </div>
</nav>



<!-- Основная информация о ломбарде -->
<div class="container mx-auto mt-8 flex">
    <div class="w-2/3 p-8 bg-white rounded-lg shadow-lg">
        <h1 class="text-4xl font-bold text-green-500 mb-4" id="welcome-text"></h1>


        <p class="text-gray-700">Местоположение: <span class="text-gray-900">Сердце города</span></p>
        <p class="text-gray-700">Описание: "Лучший из лучших Ломбард" - это идеальное место для ваших финансовых потребностей. Мы предоставляем широкий спектр услуг и гарантируем лучшие условия для наших клиентов. Наш ломбард обладает более чем 20-летним опытом в области золота, серебра, драгоценных камней и других ценностей.</p>

        <h2 class="text-xl font-semibold mt-4">Услуги:</h2>
        <ul class="list-disc ml-6 text-gray-700">
            <li>Оценка и залог ювелирных изделий</li>
            <li>Продажа и покупка драгоценных металлов</li>
            <li>Займы под залог</li>
            <li>Продажа ювелирных изделий</li>
        </ul>

        <h2 class="text-xl font-semibold mt-4">Наши преимущества:</h2>
        <ul class="list-disc ml-6 text-gray-700">
            <li>Курсы обмена, которые невозможно превзойти</li>
            <li>Профессиональные оценщики с многолетним опытом</li>
            <li>Конфиденциальность и безопасность сделок</li>
            <li>Быстрое оформление займов</li>
            <li>Уютная атмосфера и приветливый персонал</li>
        </ul>

        <p class="text-gray-700 mt-4">Мы гордимся тем, что являемся лучшим ломбардом в мире, и всегда готовы помочь вам в решении ваших финансовых вопросов. Приходите к нам сегодня и убедитесь сами в нашей выдающейся службе:</p>
        <p class="text-gray-700 mt-4">Готовы предоставить займ под залог ваших ценных вещей всего от 0.27%  день.</p>
        <p class="text-gray-700 mt-4 font-semibold">P.s. Личный кабинет автоматически заводится , при создании заявки , не забудьте записать ваш логин и пароль!</p>
    </div>


    <div class="w-1/3 p-8 bg-white ml-4">
        <h2 class="text-2xl font-bold">Курсы</h2>
        <ul class="mt-4" id="exchange-rates">
            <li>
                Золото: 1000 руб./грамм
                <div class="chart" data-value="322"></div>
            </li>
            <li>
                Серебро: 210 руб./грамм
                <div class="chart" data-value="210"></div>
            </li>
            <li>
                Ювелирка: 1540 руб./грамм
                <div class="chart" data-value="450"></div>
            </li>
            <li>
                Доллар: 75 руб.
                <div class="chart" data-value="75"></div>
            </li>
            <li>
                Евро: 90 руб.
                <div class="chart" data-value="90"></div>
            </li>

        </ul>
        <p class="mt-4">Краткая информация о процессе получения займа в ломбарде.</p>
        <br>
        <br>
        <p class="text-center text-gray-700">
            Вся представленная на этой странице информация является вымышленной и используется исключительно в демонстрационных целях. Никакие реальные данные или события не связаны с этим контентом.
        </p>
    </div>


<!--// модальное окно-->

    <div id="myModal" class="modal">
        <div class="modal-content bg-white p-4 rounded shadow-lg max-w-md">
            <span class="close absolute top-2 right-2 text-gray-600 cursor-pointer text-2xl" id="closeModal">×</span>
            <form id="applicationForm" action="process_application.php" method="post" class="space-y-4">

                <div class="space-y-2">
                    <label for="full_name" class="text-gray-700 font-semibold">ФИО</label>
                    <input type="text" id="full_name" name="full_name" required class="w-full border rounded p-2">
                </div>

                <div class="space-y-2">
                    <label for="passport_number" class="text-gray-700 font-semibold">Номер паспорта</label>
                    <input type="text" id="passport_number" name="passport_number" required class="w-full border rounded p-2">
                </div>

                <div class="space-y-2">
                    <label for="division_code" class="text-gray-700 font-semibold">Код подразделения</label>
                    <input type="text" id="division_code" name="division_code" required class="w-full border rounded p-2">
                </div>

                <div class="space-y-2">
                    <label for="registration_address" class="text-gray-700 font-semibold">Адрес регистрации</label>
                    <input type="text" id="registration_address" name="registration_address" required class="w-full border rounded p-2">
                </div>

                <div class="space-y-2">
                    <label for="category" class="text-gray-700 font-semibold">Категория техники</label>
                    <select id="category" name="category" class="w-full border rounded p-2">
                        <option>Телефоны/смартфоны</option>
                        <option>Техника для дачи</option>
                        <option>Техника для дома</option>
                        <option>Техника для ремонта</option>
                        <option>ПК/Ноутбуки/Оборудование</option>
                        <option>Товары для спорта</option>
                        <option>Часы и прочее</option>
                        <option>Другое*</option>
                    </select>
                </div>

                <div class="space-y-2">
                    <label for="product_name" class="text-gray-700 font-semibold">Наименование и модель</label>
                    <input type="text" id="product_name" name="product_name" required class="w-full border rounded p-2">
                </div>

                <div class="space-y-2">
                    <label for="selling_price" class="text-gray-700 font-semibold">Планируемая цена продажи</label>
                    <input type="number" id="selling_price" name="selling_price" required class="w-full border rounded p-2">
                </div>
                <div class="text-gray-700">руб.</div>

                <div class="button-container space-x-4 mt-4">
                    <input type="submit" class="btn-green-500 py-2 px-4 rounded-full bg-green-500 hover:bg-green-600 cursor-pointer" value="Отправить">
                    <button class="btn-red py-2 px-4 rounded-full bg-red-500 hover:bg-red-600 text-white cursor-pointer" id="closeModalForm">Закрыть</button>
                </div>
                <div id="message" class="bg-blue-100 p-4 rounded border border-blue-300 " style="display: none;"></div>
            </form>
        </div>
    </div>









    <script src="./modules/typewriter.js"></script>
    <script src="./modules/modal.js"></script>



<script>
    const chartElements = document.querySelectorAll('.chart');

    chartElements.forEach((chart) => {
        const value = chart.getAttribute('data-value');
        chart.style.width = value + 'px';

        // Имитируем анимацию с изменением значения
        setTimeout(() => {
            chart.style.width = (value * 1.02) + 'px'; // Можете настроить коэффициент анимации
        }, 5000); // 1000 миллисекунд (1 секунда) - время анимации
    });

</script>

</body>
</html>
