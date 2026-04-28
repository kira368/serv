<?php
require_once 'db.php';

$id = $_GET['id'] ?? 0;
$stmt = $content_db->prepare("SELECT * FROM items WHERE id = ?");
$stmt->execute([$id]);
$item = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$item) {
    header("Location: index.php");
    exit;
}

$stmt_user = $users_db->prepare("SELECT login FROM users WHERE id = ?");
$stmt_user->execute([$item['user_id']]);
$author = $stmt_user->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($item['title']) ?> — Магазин</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'header.php'; ?>

<main class="container">
    <div class="item-detail" style="background:white; border-radius:16px; padding:30px; margin:20px 0;">
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:30px;">
            <img src="img/items/<?= htmlspecialchars($item['image'] ?: 'placeholder.jpg') ?>" 
                 style="width:100%; border-radius:12px; object-fit:cover;">
            <div>
                <h1><?= htmlspecialchars($item['title']) ?></h1>
                <p style="font-size:24px; color:#4f46e5; font-weight:bold;">
                    <?= number_format($item['price'], 0, ',', ' ') ?> ₽
                </p>
                <p><strong>Тип:</strong> <?= $item['type'] === 'product' ? 'Товар' : 'Услуга' ?></p>
                <p><strong>Автор:</strong> <?= htmlspecialchars($author['login'] ?? 'Неизвестно') ?></p>
                <p style="margin-top:20px; line-height:1.6;"><?= nl2br(htmlspecialchars($item['description'])) ?></p>
            </div>
        </div>
    </div>
</main>
</body>
</html>