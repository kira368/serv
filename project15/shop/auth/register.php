<?php require "../db.php";
if($_POST){
    $login = $_POST['login'];
    $email = $_POST['email'];
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $pdo->prepare("INSERT INTO users(login,email,password) VALUES(?,?,?)")
        ->execute([$login,$email,$pass]);

    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<div class="container">
    <div class="auth-wrapper">
        <div class="auth-card">
            <h2>Создать аккаунт</h2>
            <form method="POST">
                <input name="login" placeholder="Логин" required>
                <input name="email" type="email" placeholder="Email" required>
                <input name="password" type="password" placeholder="Пароль" required>
                <button type="submit">Зарегистрироваться</button>
            </form>
            <div class="auth-footer">
                Уже есть аккаунт? <a href="login.php">Войти</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>