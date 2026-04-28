<?php
session_start();

try {
    $pdo = new PDO('mysql:host=MySQL-8.4;dbname=content_db;charset=utf8', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $users_db = $pdo;
    $content_db = $pdo;
} catch (PDOException $e) {
    die('Ошибка подключения к базе данных: ' . $e->getMessage());
}
?>