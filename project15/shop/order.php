<?php
require_once 'db.php';
session_start();
$data = json_decode(file_get_contents("php://input"), true);
$user_id = $_SESSION['user']['id'] ?? 0;
$total = 0;
foreach ($data as $i) {
    $stmt = $content_db->prepare("SELECT price FROM items WHERE id = ?");
    $stmt->execute([$i['id']]);
    $p = $stmt->fetch();
    $total += $p['price'] * ($i['qty'] ?? 1);
}
$stmt = $content_db->prepare("INSERT INTO orders (user_id, total) VALUES (?, ?)");
$stmt->execute([$user_id, $total]);
$order_id = $content_db->lastInsertId();
foreach ($data as $i) {
    $stmt = $content_db->prepare("INSERT INTO order_items (order_id, product_id, quantity) VALUES (?, ?, ?)");
    $stmt->execute([$order_id, $i['id'], $i['qty'] ?? 1]);
}
echo json_encode(['success' => true]);
