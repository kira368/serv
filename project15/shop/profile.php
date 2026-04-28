<?php
require_once 'db.php';
if (!isset($_SESSION['user'])) {
    header("Location: auth/login.php");
    exit;
}

$user_id = $_SESSION['user']['id'];
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login']);
    $email = trim($_POST['email']);

    // Обновление аватара
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
        $filename = 'avatar_' . $user_id . '_' . time() . '.' . $ext;
        move_uploaded_file($_FILES['avatar']['tmp_name'], 'img/avatars/' . $filename);
        $_SESSION['user']['avatar'] = $filename;
        $stmt = $users_db->prepare("UPDATE users SET avatar = ? WHERE id = ?");
        $stmt->execute([$filename, $user_id]);
    }

    $stmt = $users_db->prepare("UPDATE users SET login = ?, email = ? WHERE id = ?");
    $stmt->execute([$login, $email, $user_id]);
    $_SESSION['user']['login'] = $login;
    $_SESSION['user']['email'] = $email;
    $message = "✅ Профиль обновлён!";
}

$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Мой профиль</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'header.php'; ?>
<main class="container">
    <div class="form-card">
        <h2>👤 Мой профиль</h2>
        <?php if ($message): ?>
            <div class="message success"><?= $message ?></div>
        <?php endif; ?>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Логин</label>
                <input type="text" name="login" value="<?= htmlspecialchars($user['login']) ?>" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
            </div>
            <div class="form-group">
                <label>Аватар</label>
                <?php if (!empty($user['avatar'])): ?>
                    <div style="margin-bottom:10px;">
                        <img src="img/avatars/<?= htmlspecialchars($user['avatar']) ?>" width="80" style="border-radius:50%;">
                    </div>
                <?php endif; ?>
                <input type="file" name="avatar" accept="image/*">
            </div>
            <button type="submit" class="btn">Сохранить изменения</button>
        </form>
    </div>
</main>
</body>
</html>