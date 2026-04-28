<?php
if (!isset($_SESSION)) session_start();
$current_user = $_SESSION['user'] ?? null;
?>
<header class="main-header">
    <div class="header-content">
        <div class="logo">
            <a href="/shop/index.php">Магазин</a>
        </div>
        <nav class="nav-links">
            <a href="/shop/index.php">Главная</a>
            <?php if ($current_user): ?>
                <a href="/shop/add_item.php">➕ Добавить</a>
                <a href="/shop/my_items.php">📦 Мои товары</a>
                <a href="/shop/profile.php">👤 Профиль</a>
                <?php if ($current_user['role'] === 'admin'): ?>
                    <a href="/shop/admin/admin.php">⚙️ Админка</a>
                    <a href="/shop/admin/dashboard.php">📊 Статистика</a>
                <?php endif; ?>
                <a href="/shop/auth/logout.php">🚪 Выйти</a>
            <?php else: ?>
                <a href="/shop/auth/login.php">🔐 Войти</a>
                <a href="/shop/auth/register.php">📝 Регистрация</a>
            <?php endif; ?>
        </nav>
    </div>
</header>