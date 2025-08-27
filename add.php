<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="UTF-8">
  <title>Add New Task</title>
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
      <h4 class="text-center">Add New Task</h4>

      <form action="actions.php?action=add" method="POST">
        <input type="text" name="title" class="form-control mb-3" placeholder="Task Title" required>

        <textarea name="description" class="form-control mb-3" placeholder="Description"></textarea>

        <select name="importance" class="form-control mb-3">
          <option value="Low">Low</option>
          <option value="Medium" selected>Medium</option>
          <option value="High">High</option>
        </select>

        <input type="date" name="due_date" class="form-control mb-3">

        <input type="text" name="category" class="form-control mb-3" placeholder="Category (e.g., Work, Personal)">

        <button type="submit" class="btn btn-primary w-100 fw-bold">Add Task</button>
      </form>
    </div>
  </main>

  <!-- Footer -->
  <footer>
    Developed by: Omar Abd alRahaman Yosuf alJamal - <strong>1320225259</strong>
  </footer>

</body>
</html>
