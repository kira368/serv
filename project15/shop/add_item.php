<?php
require_once 'db.php';

if (!isset($_SESSION['user'])) {
    header("Location: auth/login.php");
    exit;
}

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $price = (int)$_POST['price'];
    $type = $_POST['type'];
    $user_id = $_SESSION['user']['id'];

    if (empty($title) || empty($description) || $price <= 0 || !in_array($type, ['product', 'service'])) {
        $message = 'Пожалуйста, заполните все поля корректно.';
    } else {
        $image = 'placeholder.jpg';
        if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $filename = 'item_' . time() . '_' . $user_id . '.' . $ext;
            move_uploaded_file($_FILES['image']['tmp_name'], 'img/items/' . $filename);
            $image = $filename;
        }

        $stmt = $content_db->prepare("INSERT INTO items (title, description, price, type, image, user_id) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$title, $description, $price, $type, $image, $user_id]);
        header("Location: my_items.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Добавить товар</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'header.php'; ?>
<main class="container">
    <div class="form-card">
        <h2>Добавить товар / услугу ➕</h2>
        <?php if ($message): ?>
            <div class="message error"><?= $message ?></div>
        <?php endif; ?>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Название</label>
                <input type="text" name="title" required>
            </div>
            <div class="form-group">
                <label>Описание</label>
                <textarea name="description" rows="5" required></textarea>
            </div>
            <div class="form-group">
                <label>Цена</label>
                <input type="number" name="price" min="1" required>
            </div>
            <div class="form-group">
                <label>Тип</label>
                <select name="type" required>
                    <option value="product">Товар</option>
                    <option value="service">Услуга</option>
                </select>
            </div>
            <div class="form-group">
                <label>Изображение</label>
                <input type="file" name="image" accept="image/*">
            </div>
            <button type="submit" class="btn">Добавить</button>
        </form>
    </div>
</main>
</body>
</html>