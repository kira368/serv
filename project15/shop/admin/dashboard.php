<?php
require_once '../db.php';
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}
$total_users = $users_db->query("SELECT COUNT(*) FROM users")->fetchColumn();
$total_items = $content_db->query("SELECT COUNT(*) FROM items")->fetchColumn();
$total_products = $content_db->query("SELECT COUNT(*) FROM items WHERE type='product'")->fetchColumn();
$total_services = $content_db->query("SELECT COUNT(*) FROM items WHERE type='service'")->fetchColumn();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Статистика</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<?php include '../header.php'; ?>
<main class="container">
    <h1>📊 Панель статистики</h1>
    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px,1fr)); gap:20px; margin-top:20px;">
        <div class="stat-card" style="background:white; padding:20px; border-radius:12px;">
            <h3>Пользователи</h3>
            <p style="font-size:32px; font-weight:bold; color:#4f46e5;"><?= $total_users ?></p>
        </div>
        <div class="stat-card" style="background:white; padding:20px; border-radius:12px;">
            <h3>Всего позиций</h3>
            <p style="font-size:32px; font-weight:bold; color:#4f46e5;"><?= $total_items ?></p>
        </div>
        <div class="stat-card" style="background:white; padding:20px; border-radius:12px;">
            <h3>Товары</h3>
            <p style="font-size:32px; font-weight:bold; color:#4f46e5;"><?= $total_products ?></p>
        </div>
        <div class="stat-card" style="background:white; padding:20px; border-radius:12px;">
            <h3>Услуги</h3>
            <p style="font-size:32px; font-weight:bold; color:#4f46e5;"><?= $total_services ?></p>
        </div>
    </div>
</main>
</body>
</html>