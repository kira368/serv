<?php
require "../db.php";

if($_SESSION['user']['role'] != 'admin') die('no access');

$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM products WHERE id=?");
$stmt->execute([$id]);
$product = $stmt->fetch();

if($_POST){
$name = $_POST['name'];
$price = $_POST['price'];

if(!empty($_FILES['img']['name'])){
$img = time() . "_" . $_FILES['img']['name'];
$img = str_replace([' ', '(', ')'], '_', $img);

move_uploaded_file($_FILES['img']['tmp_name'], "../img/" . $img);

$pdo->prepare("UPDATE products SET name=?, price=?, image=? WHERE id=?")
->execute([$name, $price, $img, $id]);
} else {
$pdo->prepare("UPDATE products SET name=?, price=? WHERE id=?")
->execute([$name, $price, $id]);
}

header("Location: dashboard.php");
}
?>
<<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
	<link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body>
	<form method="POST" enctype="multipart/form-data">
	<input name="name" value="<?= $product['name'] ?>">
	<input name="price" value="<?= $product['price'] ?>">

	<p>Текущая картинка:</p>
	<img src="../img/<?= $product['image'] ?>" width="100">

	<input type="file" name="img">
	<button>Сохранить</button>
	</form>


</body>
</html>

