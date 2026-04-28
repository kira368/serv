<?php 
require "../db.php";
session_start();
if($_POST){
    $stmt = $pdo->prepare("SELECT * FROM users WHERE login=?");
    $stmt->execute([$_POST['login']]);
    $user = $stmt->fetch();

    if($user && password_verify($_POST['password'],$user['password'])){
        $_SESSION['user']=$user;
        header("Location: ../index.php");
    } else echo "Ошибка";
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<div class="container">
    <div class="auth-wrapper">
        <div class="auth-card">
            <h2>Вход в аккаунт</h2>
            <form method="POST">
                <input name="login" placeholder="Логин" required>
                <input name="password" type="password" placeholder="Пароль" required>
                <button type="submit">Войти</button>
            </form>
            <div class="auth-footer">
                Нет аккаунта? <a href="register.php">Зарегистрироваться</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>