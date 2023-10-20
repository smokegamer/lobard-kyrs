<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
<div class="bg-white p-8 rounded-lg shadow-lg w-1/4">
    <h1 class="text-2xl font-semibold mb-4">Вход в личный кабинет</h1>
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
    </form>
</div>
</body>
</html>
