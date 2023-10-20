<?php
session_start(); // Начать сессию

// Уничтожить сессию
session_destroy();

// Перенаправление на страницу входа или другую страницу
header("Location: ./index.php");
?>