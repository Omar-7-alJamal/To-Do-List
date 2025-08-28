<?php
include 'config.php';

// check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// git id
$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: index.php');
    exit;
}

// get data from database
$stmt = $conn->prepare("SELECT * FROM tasks WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $id, $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header('Location: index.php');
    exit;
}

$task = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Task</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap & CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="style.css" rel="stylesheet">
</head>
<body>

  <!-- Header -->
  <header>
    <nav class="navbar navbar-dark bg-primary shadow fixed-top">
      <div class="container-fluid d-flex justify-content-between align-items-center">
        <span class="navbar-brand mb-0 h1">To Do List App</span>
        <a href="index.php" class="btn btn-warning fw-bold" id="logoutBtn">Back</a>
      </div>
    </nav>
  </header>

  <!-- Main Content -->
  <main class="container full-height-center">
    <div class="card">
      <h4 class="text-center">Edit Task</h4>

      <form action="actions.php?action=edit&id=<?= (int)$task['id'] ?>" method="POST">
        <input type="text" name="title" class="form-control mb-3" placeholder="Task Title" required value="<?= htmlspecialchars($task['title']) ?>">

        <textarea name="description" class="form-control mb-3" placeholder="Description (optional)"><?= htmlspecialchars($task['description']) ?></textarea>

        <select name="importance" class="form-control mb-3">
          <option value="Low" <?= $task['importance'] === 'Low' ? 'selected' : '' ?>>Low</option>
          <option value="Medium" <?= $task['importance'] === 'Medium' ? 'selected' : '' ?>>Medium</option>
          <option value="High" <?= $task['importance'] === 'High' ? 'selected' : '' ?>>High</option>
        </select>

        <input type="date" name="due_date" class="form-control mb-3" value="<?= htmlspecialchars($task['due_date']) ?>">

        <input type="text" name="category" class="form-control mb-3" placeholder="Category" value="<?= htmlspecialchars($task['category']) ?>">

        <button type="submit" class="btn btn-primary w-100 fw-bold">Save Changes</button>
      </form>
    </div>
  </main>

  <!-- Footer -->
  <footer>
    Developed by: Omar Abd alRahaman Yosuf alJamal - <strong>1320225259</strong>
  </footer>

</body>
</html>
