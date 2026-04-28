<?php require "../db.php";
session_start();
if($_SESSION['user']['role']!='admin') die('no access');

if($_POST){
    $img=$_FILES['img']['name'];
    move_uploaded_file($_FILES['img']['tmp_name'],"../img/".$img);
    $pdo->prepare("INSERT INTO products(name,price,image) VALUES(?,?,?)")
    ->execute([$_POST['name'],$_POST['price'],$img]);
    header("Location: dashboard.php");
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавить товар</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<div class="container">
    <div class="top-nav">
        <a href="dashboard.php" class="back-link">← Назад</a>
        <h1>➕ Новый товар</h1>
        <div></div>
    </div>

    <div class="form-wrapper">
        <form method="POST" enctype="multipart/form-data">
            <input name="name" placeholder="Название товара" required>
            <input name="price" type="number" step="0.01" placeholder="Цена" required>
            <div class="file-input">
                <label for="img">📷 Изображение</label>
                <input type="file" name="img" id="img" accept="image/*" required>
            </div>
            <button type="submit">➕ Добавить товар</button>
        </form>
    </div>
</div>
</body>
</html>