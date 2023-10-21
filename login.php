<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация</title>
    <link href="assets/tailwind.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
<div class="bg-white p-8 rounded-lg shadow-lg w-1/4">
    <h1 id="loginTitle" class="text-2xl font-semibold mb-4">Вход в личный кабинет</h1>
    <form action="modules/enter.php" method="POST">

        <div class="mb-4">
            <label for="username" class="block text-gray-700 font-semibold">Имя пользователя:</label>
            <input type="text" id="username" name="username" class="w-full border rounded py-2 px-3 focus:outline-none focus:ring focus:border-blue-500" required>
        </div>
        <div class="mb-4">
            <label for="password" class="block text-gray-700 font-semibold">Пароль:</label>
            <input type="password" id="password" name="password" class="w-full border rounded py-2 px-3 focus:outline-none focus:ring focus:border-blue-500" required>
        </div>

        <button type="submit" class="bg-blue-500 text-white font-semibold py-2 px-4 rounded hover:bg-blue-600 focus:outline-none focus:ring focus:ring-blue-200">
            Войти
        </button>

        <button id="registrationButton" class="mt-4 bg-red-500 text-white font-semibold py-2 px-4 rounded hover:bg-green-500 focus:outline-none focus:ring focus:ring-red-200">
            Зарегистрироваться
        </button>
    </form>

    <div id="registrationForm" class="hidden mt-4">
        <h2 class="text-2xl font-semibold mb-4">Регистрация</h2>
        <form action="./modules/register.php" method="POST">
            <div class="mb-4">
                <label for="newUsername" class="block text-gray-700 font-semibold">Создайте логин:</label>
                <input type="text" id="newUsername" name="newUsername" class="w-full border rounded py-2 px-3 focus:outline-none focus:ring focus:border-blue-500" required>
            </div>
            <div class="mb-4">
                <label for="newPassword" class="block text-gray-700 font-semibold">Придумайте пароль:</label>
                <input type="password" id="newPassword" name="newPassword" class="w-full border rounded py-2 px-3 focus:outline-none focus:ring focus:border-blue-500" required>
            </div>
            <button type="submit" class="bg-blue-500 text-white font-semibold py-2 px-4 rounded hover:bg-blue-600 focus:outline-none focus:ring focus:ring-blue-200">
                Создать аккаунт
            </button>
        </form>
    </div>
</div>

<script>
    const registrationButton = document.getElementById('registrationButton');
    const registrationForm = document.getElementById('registrationForm');
    const loginTitle = document.getElementById('loginTitle');
    const loginForm = document.querySelector('form[action="modules/enter.php"]');

    registrationButton.addEventListener('click', () => {
        loginForm.style.display = 'none';
        loginTitle.style.display = 'none';
        registrationForm.style.display = 'block';
    });
</script>

</body>
</html>
