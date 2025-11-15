<?php
require 'auth_check.php';

$userId = $_SESSION['user_id'];

$statusFilter = $_GET['status'] ?? '';
$order        = $_GET['order'] ?? 'asc';

$query = "SELECT * FROM tasks WHERE user_id = :uid";
$params = [':uid' => $userId];

if ($statusFilter !== '') {
    $query .= " AND status = :status";
    $params[':status'] = $statusFilter;
}

$query .= " ORDER BY due_date " . ($order === 'desc' ? 'DESC' : 'ASC');

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

$pageTitle = "Danh sách công việc";
require 'partials/header.php';
?>

<div class="row">
  <div class="col-md-4">
    <h4>Thêm công việc mới</h4>
    <form method="post" action="add_task.php">
      <div class="mb-3">
        <label class="form-label">Tiêu đề</label>
        <input name="title" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Mô tả</label>
        <textarea name="description" class="form-control" rows="3"></textarea>
      </div>
      <div class="mb-3">
        <label class="form-label">Ngày hết hạn</label>
        <input type="date" name="due_date" class="form-control">
      </div>
      <button class="btn btn-success">Thêm</button>
    </form>
  </div>

  <div class="col-md-8">
    <h4>Công việc của bạn</h4>

    <form class="row g-2 mb-3">
      <div class="col-auto">
        <select name="status" class="form-select">
          <option value="">Tất cả trạng thái</option>
          <option value="pending"      <?= $statusFilter==='pending'?'selected':'' ?>>Đang chờ</option>
          <option value="in_progress"  <?= $statusFilter==='in_progress'?'selected':'' ?>>Đang hoàn thành</option>
          <option value="completed"    <?= $statusFilter==='completed'?'selected':'' ?>>Hoàn Thành</option>
        </select>
      </div>
      <div class="col-auto">
        <select name="order" class="form-select">
          <option value="asc"  <?= $order==='asc'?'selected':'' ?>>Hạn gần trước</option>
          <option value="desc" <?= $order==='desc'?'selected':'' ?>>Hạn xa trước</option>
        </select>
      </div>
      <div class="col-auto">
        <button class="btn btn-primary">Lọc / Sắp xếp</button>
      </div>
    </form>

    <table class="table table-striped">
      <thead>
        <tr>
          <th>Tiêu đề</th>
          <th>Hết hạn</th>
          <th>Trạng thái</th>
          <th>Hành động</th>
        </tr>
      </thead>
      <tbody>
          
        <?php $statusVN = [
    'pending'     => 'Đang chờ',
    'in_progress' => 'Đang làm',
    'completed'   => 'Hoàn thành'
];
 foreach  ($tasks as $task): ?>
          <tr>
            
            <td><?= htmlspecialchars($task['title']) ?></td>
            <td>
    <?php
        if ($task['due_date']) {
            echo date('d/m/Y', strtotime($task['due_date']));
        } else {
            echo "-";
        }
    ?>
</td>
            <td><?= $statusVN[$task['STATUS']] ?? $task['STATUS'] ?></td>
            <td>
  <a class="btn btn-sm btn-outline-primary" href="edit_task.php?id=<?= $task['id'] ?>">Sửa</a>

  <?php if ($task['STATUS'] !== 'completed'): ?>
    <a class="btn btn-sm btn-success" 
       href="update_status.php?id=<?= $task['id'] ?>&status=completed">
       ✔ Hoàn thành
    </a>
  <?php else: ?>
    <span class="badge bg-success">Đã xong</span>
  <?php endif; ?>

  <a class="btn btn-sm btn-outline-danger" href="delete_task.php?id=<?= $task['id'] ?>"
     onclick="return confirm('Xóa công việc này?');">Xóa</a>
</td>

          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php require 'partials/footer.php'; ?>
