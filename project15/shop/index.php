<?php
require_once 'db.php';

$type_filter = $_GET['type'] ?? '';
$price_sort = $_GET['price_sort'] ?? '';

$sql = "SELECT * FROM items WHERE 1=1";
$params = [];

if ($type_filter && in_array($type_filter, ['product', 'service'])) {
    $sql .= " AND type = ?";
    $params[] = $type_filter;
}

if ($price_sort === 'asc') {
    $sql .= " ORDER BY price ASC";
} elseif ($price_sort === 'desc') {
    $sql .= " ORDER BY price DESC";
} else {
    $sql .= " ORDER BY id DESC";
}

$stmt = $content_db->prepare($sql);
$stmt->execute($params);
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MarketPlace — лучшие товары и услуги</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'header.php'; ?>

<main class="container">
    <div class="hero-section">
        <h1>Добро пожаловать в Магазин</h1>
        <p>Лучшие товары и услуги по выгодным ценам от проверенных продавцов</p>
        <div class="hero-stats">
            <div class="stat">
                <span class="stat-number">500+</span>
                <span class="stat-label">Товаров</span>
            </div>
            <div class="stat">
                <span class="stat-number">200+</span>
                <span class="stat-label">Услуг</span>
            </div>
            <div class="stat">
                <span class="stat-number">1000+</span>
                <span class="stat-label">Довольных клиентов</span>
            </div>
        </div>
    </div>

    <div class="filters">
        <form method="GET" class="filters-form">
            <div class="filter-group">
                <label>📂 Тип</label>
                <select name="type" onchange="this.form.submit()">
                    <option value="">Все</option>
                    <option value="product" <?= $type_filter === 'product' ? 'selected' : '' ?>>📦 Товары</option>
                    <option value="service" <?= $type_filter === 'service' ? 'selected' : '' ?>>🔧 Услуги</option>
                </select>
            </div>
            <div class="filter-group">
                <label>💰 Цена</label>
                <select name="price_sort" onchange="this.form.submit()">
                    <option value="">По умолчанию</option>
                    <option value="asc" <?= $price_sort === 'asc' ? 'selected' : '' ?>>Сначала дешёвые</option>
                    <option value="desc" <?= $price_sort === 'desc' ? 'selected' : '' ?>>Сначала дорогие</option>
                </select>
            </div>
        </form>
    </div>

    <?php if (count($items) > 0): ?>
        <div class="items-grid">
            <?php foreach ($items as $item): ?>
                <div class="item-card">
                    <img src="img/items/<?= htmlspecialchars($item['image'] ?: 'placeholder.jpg') ?>" 
                         alt="<?= htmlspecialchars($item['title']) ?>" class="item-image">
                    <div class="item-info">
                        <h3 class="item-title"><?= htmlspecialchars($item['title']) ?></h3>
                        <p class="item-price"><?= number_format($item['price'], 0, ',', ' ') ?> ₽</p>
                        <span class="item-type"><?= $item['type'] === 'product' ? '📦 Товар' : '🔧 Услуга' ?></span>
                        <div class="item-actions">
                            <a href="item.php?id=<?= $item['id'] ?>" class="btn">Подробнее</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="empty-state">
            <p>😕 Ничего не найдено</p>
            <p>Попробуйте изменить фильтры или <a href="add_item.php">добавьте свой товар</a></p>
        </div>
    <?php endif; ?>
</main>

<footer>
    <div class="footer-content">
        <div class="footer-section">
            <h4>MarketPlace</h4>
            <p>Площадка для продажи товаров и услуг</p>
        </div>
        <div class="footer-section">
            <h4>Контакты</h4>
            <p>📧 support@marketplace.ru</p>
            <p>📞 +7 (999) 123-45-67</p>
        </div>
        <div class="footer-section">
            <h4>Мы в соцсетях</h4>
            <p>📱 Telegram | VK | WhatsApp</p>
        </div>
    </div>
</footer>
</body>
</html>