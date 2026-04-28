<?php require "db.php";
session_start();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Корзина - MarketPlace</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
<div class="container">
    <div class="top-nav">
        <a href="index.php" class="back-link"><i class="fas fa-arrow-left"></i> Назад в магазин</a>
        <h1><i class="fas fa-shopping-cart"></i> Моя корзина</h1>
        <div></div>
    </div>

    <div class="cart-wrapper">
        <div id="cart" class="cart-items"></div>
        <div class="cart-summary">
            <div class="total-price" id="totalPrice">Итого: 0 ₽</div>
            <button onclick="order()" class="btn-order">
                <i class="fas fa-check-circle"></i> Оформить заказ
            </button>
            <button onclick="clearCart()" class="btn-clear">
                <i class="fas fa-trash"></i> Очистить корзину
            </button>
        </div>
    </div>
</div>

<script src="js/cart.js"></script>
</body>
</html>