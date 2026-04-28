<?php
require_once 'db.php';
if (!isset($_SESSION['user'])) {
    header("Location: auth/login.php");
    exit;
}
$user_id = $_SESSION['user']['id'];
$stmt = $content_db->prepare("SELECT * FROM items WHERE user_id = ? ORDER BY id DESC");
$stmt->execute([$user_id]);
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Мои товары</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'header.php'; ?>
<main class="container">
    <h1 style="margin-bottom:20px;">📦 Мои товары и услуги</h1>
    <?php if ($items): ?>
        <div class="items-grid">
            <?php foreach ($items as $item): ?>
                <div class="item-card">
                    <img src="img/items/<?= htmlspecialchars($item['image']) ?>" class="item-image">
                    <div class="item-info">
                        <h3><?= htmlspecialchars($item['title']) ?></h3>
                        <p class="item-price"><?= number_format($item['price'], 0, ',', ' ') ?> ₽</p>
                        <div class="item-actions">
                            <a href="edit_item.php?id=<?= $item['id'] ?>" class="btn">✏️ Изменить</a>
                            <a href="delete_item.php?id=<?= $item['id'] ?>" class="btn btn-danger" onclick="return confirm('Удалить?')">❌ Удалить</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="empty-state">
            <p>У вас пока нет товаров.</p>
            <a href="add_item.php" class="btn">Добавить первый товар</a>
        </div>
    <?php endif; ?>
</main>
</body>
</html>