<?php
require_once 'db.php';
$data = json_decode(file_get_contents("php://input"), true);
$res = [];
foreach ($data as $i) {
    $stmt = $content_db->prepare("SELECT * FROM items WHERE id = ?");
    $stmt->execute([$i['id']]);
    $res[] = $stmt->fetch(PDO::FETCH_ASSOC);
}
echo json_encode($res);
