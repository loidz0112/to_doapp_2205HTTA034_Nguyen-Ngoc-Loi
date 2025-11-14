<?php
require 'auth_check.php';

$id     = $_GET['id'] ?? null;
$status = $_GET['status'] ?? null;

if ($id && $status) {
    $stmt = $pdo->prepare("UPDATE tasks SET status = :st WHERE id = :id AND user_id = :uid");
    $stmt->execute([
        ':st'  => $status,
        ':id'  => $id,
        ':uid' => $_SESSION['user_id']
    ]);
}

header('Location: index.php');
exit;
