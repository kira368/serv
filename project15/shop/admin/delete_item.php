<?php
require_once 'db.php';
if (!isset($_SESSION['user'])) exit;
$id = $_GET['id'] ?? 0;
$user_id = $_SESSION['user']['id'];

$stmt = $content_db->prepare("DELETE FROM items WHERE id = ? AND user_id = ?");
$stmt->execute([$id, $user_id]);
header("Location: my_items.php");
exit;