<?php

session_start(); // Начать сессию
include("./config.php");

// Функция для проверки, аутентифицирован ли пользователь
function isUserAuthenticated() {
    return isset($_SESSION['username']);
}

// Функция для получения имени пользователя
function getUsername() {
    return $_SESSION['username'];
}

// Функция для проверки, является ли пользователь администратором
function isUserAdmin() {
    return isset($_SESSION['admin_level']) && $_SESSION['admin_level'] == 1;
}

// Функция для проверки, является ли пользователь обычным пользователем
function isUserRegular() {
    return isset($_SESSION['admin_level']) && $_SESSION['admin_level'] == 0;
}

// Другие функции и логика, если необходимо

?>
