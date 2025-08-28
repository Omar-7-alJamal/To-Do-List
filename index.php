<?php
include 'config.php';

// check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
// get filter
$filter = $_GET['filter'] ?? 'all';

// chose query based on filter
if ($filter === 'completed') {
    $stmt = $conn->prepare("
        SELECT * FROM tasks 
        WHERE user_id = ? AND completed = 1 
        ORDER BY 
            CASE importance 
                WHEN 'High' THEN 1 
                WHEN 'Medium' THEN 2 
                WHEN 'Low' THEN 3 
                ELSE 4 
            END,
            id DESC
    ");
} elseif ($filter === 'incomplete') {
    $stmt = $conn->prepare("
        SELECT * FROM tasks 
        WHERE user_id = ? AND completed = 0 
        ORDER BY 
            CASE importance 
                WHEN 'High' THEN 1 
                WHEN 'Medium' THEN 2 
                WHEN 'Low' THEN 3 
                ELSE 4 
            END,
            id DESC
    ");
} else {
    // ordering
    $stmt = $conn->prepare("
        SELECT * FROM tasks 
        WHERE user_id = ? 
        ORDER BY 
            completed ASC,
            CASE importance 
                WHEN 'High' THEN 1 
                WHEN 'Medium' THEN 2 
                WHEN 'Low' THEN 3 
                ELSE 4 
            END,
            id DESC
    ");
}

// get data from database
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>To Do List</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap + CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
  <link href="style.css" rel="stylesheet">
</head>
<body>

<!-- Header -->
<header>
  <nav class="navbar navbar-dark bg-primary shadow fixed-top">
    <div class="container-fluid d-flex justify-content-between align-items-center px-4">
      <span class="navbar-brand mb-0 h1 fw-bold">To Do List App</span>
      <a href="logout.php" id="logoutBtn" class="btn btn-warning fw-bold">Log out</a>
    </div>
  </nav>
</header>

<!-- filter buttons -->
<div class="text-center my-4 filter-buttons">
  <a href="index.php?filter=all" class="btn btn-outline-primary mx-1 <?= $filter === 'all' ? 'active' : '' ?>">All</a>
  <a href="index.php?filter=incomplete" class="btn btn-outline-warning mx-1 <?= $filter === 'incomplete' ? 'active' : '' ?>">Incomplete</a>
  <a href="index.php?filter=completed" class="btn btn-outline-success mx-1 <?= $filter === 'completed' ? 'active' : '' ?>">Completed</a>
</div>
<!-- Main content -->
<main class="container py-5" style="max-width: 820px;">

  <div class="card mb-3">
    <div class="card-header bg-primary text-white fw-bold">To Do List</div>

    <?php if ($result->num_rows === 0): ?>
      <div class="p-4 text-center text-muted">The List is Empty</div>
    <?php else: ?>
      <ul class="list-group list-group-flush">
        <?php while ($row = $result->fetch_assoc()): ?>
          <li class="list-group-item">
            <div class="task-header d-flex justify-content-between align-items-center mb-2">
              <h5 class="mb-0 <?= !empty($row['completed']) ? 'text-decoration-line-through text-muted' : '' ?>">
                <?= htmlspecialchars($row['title']) ?>
              </h5>
              <div class="d-flex gap-2">
                <span class="badge bg-<?= $row['importance'] === 'High' ? 'danger' : ($row['importance'] === 'Medium' ? 'warning' : 'secondary') ?>">
                  <?= htmlspecialchars($row['importance']) ?>
                </span>
                <span class="badge bg-info text-dark">
                 <?= htmlspecialchars($row['category']) ?>
                </span>
  </div>
</div>

<!--  -->
<p class="mb-1 <?= !empty($row['completed']) ? 'text-decoration-line-through text-muted' : '' ?>">
  <?= htmlspecialchars($row['description']) ?>
</p>

<p class="task-date <?= !empty($row['completed']) ? 'text-decoration-line-through text-muted' : '' ?>">
  Due: <?= htmlspecialchars($row['due_date']) ?>
</p>
<div class="d-flex justify-content-end gap-2 mt-3">
  <?php if (!empty($row['completed'])): ?>
    <a href="actions.php?action=update&id=<?= (int)$row['id'] ?>" class="badge btn btn-secondary btn-sm" title="Mark as Incomplete">Uncomplete</a>
  <?php else: ?>
    <a href="actions.php?action=update&id=<?= (int)$row['id'] ?>" class="badge btn btn-success btn-sm" title="Mark as Completed">Complete</a>
  <?php endif; ?>

  <!-- edit button -->
  <a href="edit.php?id=<?= (int)$row['id'] ?>" class="badge btn btn-info btn-sm text-dark fw-bold" title="Edit Task">Edit</a>

  <!-- delete button -->
  <a href="actions.php?action=delete&id=<?= (int)$row['id'] ?>" class="badge btn btn-danger btn-sm" title="Delete">Delete</a>
</div>


          </li>
        <?php endwhile; ?>
      </ul>
    <?php endif; ?>
  </div>

  <!-- add task button -->
  <div class="mt-4 d-flex justify-content-end">
    <a href="add.php" class="btn btn-primary fw-bold">Add New Task</a>
  </div>

</main>

<!-- Footer -->
<footer>
  Developed by: Omar Abd alRahaman Yosuf alJamal - <strong>1320225259</strong>
</footer>

</body>
</html>
