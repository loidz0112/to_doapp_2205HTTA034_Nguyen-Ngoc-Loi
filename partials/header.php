<?php
if (!isset($pageTitle)) {
    $pageTitle = "To-Do App";
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
  <div class="container">
    <a class="navbar-brand" href="index.php">To-Do</a>
    <div class="d-flex">
      <?php if (!empty($_SESSION['user_id'])): ?>
        <span class="navbar-text text-white me-3">
          Xin chào, <?= htmlspecialchars($_SESSION['username'] ?? '') ?>
        </span>
        <a class="btn btn-outline-light btn-sm" href="logout.php">Đăng xuất</a>
      <?php else: ?>
        <a class="btn btn-outline-light btn-sm me-2" href="login.php">Đăng nhập</a>
        <a class="btn btn-success btn-sm" href="register.php">Đăng ký</a>
      <?php endif; ?>
    </div>
  </div>
</nav>
<div class="container">
