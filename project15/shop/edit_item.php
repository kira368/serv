<?php
require_once 'db.php';
if (!isset($_SESSION['user'])) {
    header("Location: auth/login.php");
    exit;
}
$user_id = $_SESSION['user']['id'];
$id = $_GET['id'] ?? 0;
$stmt = $content_db->prepare("SELECT * FROM items WHERE id = ? AND user_id = ?");
$stmt->execute([$id, $user_id]);
$item = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$item) {
    header("Location: my_items.php");
    exit;
}

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $price = (int)$_POST['price'];
    $type = $_POST['type'];
    $image = $item['image'];

    if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $filename = 'item_' . time() . '_' . $user_id . '.' . $ext;
        move_uploaded_file($_FILES['image']['tmp_name'], 'img/items/' . $filename);
        $image = $filename;
    }

    $stmt = $content_db->prepare("UPDATE items SET title=?, description=?, price=?, type=?, image=? WHERE id=?");
    $stmt->execute([$title, $description, $price, $type, $image, $id]);
    header("Location: my_items.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Редактирование товара</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'header.php'; ?>
<main class="container">
    <div class="form-card">
        <h2>✏️ Редактирование</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Название</label>
                <input type="text" name="title" value="<?= htmlspecialchars($item['title']) ?>" required>
            </div>
            <div class="form-group">
                <label>Описание</label>
                <textarea name="description" rows="5" required><?= htmlspecialchars($item['description']) ?></textarea>
            </div>
            <div class="form-group">
                <label>Цена</label>
                <input type="number" name="price" value="<?= $item['price'] ?>" required>
            </div>
            <div class="form-group">
                <label>Тип</label>
                <select name="type" required>
                    <option value="product" <?= $item['type'] === 'product' ? 'selected' : '' ?>>Товар</option>
                    <option value="service" <?= $item['type'] === 'service' ? 'selected' : '' ?>>Услуга</option>
                </select>
            </div>
            <div class="form-group">
                <label>Изображение</label>
                <input type="file" name="image" accept="image/*">
                <small>Текущее: <?= htmlspecialchars($item['image']) ?></small>
            </div>
            <button type="submit" class="btn">Сохранить</button>
        </form>
    </div>
</main>
</body>
</html>