<?php
require_once '../db.php';
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

$users = $users_db->query("SELECT id, login, email, role FROM users")->fetchAll(PDO::FETCH_ASSOC);
$items = $content_db->query("SELECT * FROM items")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Админ-панель</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<?php include '../header.php'; ?>
<main class="container">
    <h1>⚙️ Админ-панель</h1>
    <section style="margin-top:20px;">
        <h2>Пользователи (<?= count($users) ?>)</h2>
        <table style="width:100%; background:white; border-radius:10px; overflow:hidden;">
            <tr style="background:#eee;"><th>ID</th><th>Логин</th><th>Email</th><th>Роль</th><th>Действие</th></tr>
            <?php foreach ($users as $u): ?>
            <tr>
                <td><?= $u['id'] ?></td>
                <td><?= htmlspecialchars($u['login']) ?></td>
                <td><?= htmlspecialchars($u['email']) ?></td>
                <td><?= $u['role'] ?></td>
                <td><a href="delete_user.php?id=<?= $u['id'] ?>" class="btn btn-danger" onclick="return confirm('Удалить?')">Удалить</a></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </section>
    <section style="margin-top:40px;">
        <h2>Все товары (<?= count($items) ?>)</h2>
        <table style="width:100%; background:white; border-radius:10px; overflow:hidden;">
            <tr style="background:#eee;"><th>ID</th><th>Название</th><th>Цена</th><th>Тип</th><th>Действие</th></tr>
            <?php foreach ($items as $it): ?>
            <tr>
                <td><?= $it['id'] ?></td>
                <td><?= htmlspecialchars($it['title']) ?></td>
                <td><?= number_format($it['price'], 0, ',', ' ') ?> ₽</td>
                <td><?= $it['type'] ?></td>
                <td><a href="delete_item.php?id=<?= $it['id'] ?>" class="btn btn-danger" onclick="return confirm('Удалить?')">Удалить</a></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </section>
</main>
</body>
</html>