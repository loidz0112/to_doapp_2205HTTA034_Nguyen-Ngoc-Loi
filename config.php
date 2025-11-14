<?php
// config.php
session_start();

$host = 'localhost';
$db   = 'todo_app';
$user = 'root';
$pass = ''; // nếu mày không đặt mật khẩu cho MySQL thì để rỗng

$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
