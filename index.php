<?php

// الاتصال بقاعدة البيانات
include 'config.php';

// التأكد من أن المستخدم مسجّل دخول (اختياري حسب نظامك)
if (!isset($_SESSION['user_id'])) {
    // header('Location: login.php');
    // exit;
}

// جلب المهام الخاصة بالمستخدم
$stmt = $conn->prepare("SELECT * FROM tasks WHERE user_id = ? ORDER BY id DESC");
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
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>

<header>
    <nav class="navbar navbar-dark bg-primary shadow">
        <div class="container-fluid d-flex justify-content-between align-items-center px-4">
            <span class="navbar-brand mb-0 h1 fw-bold">To Do List App</span>
            <a href="logout.php" id="logoutBtn" class="btn btn-warning fw-bold">
                Log out
            </a>
        </div>
    </nav>
</header>

<main class="container py-5" style="max-width: 820px;">
    <div class="card mb-3">
        <div class="card-header bg-primary text-white fw-bold">
            To Do List
        </div>

        <?php if ($result->num_rows === 0): ?>
            <div class="p-4 text-center text-muted">The List is Empty</div>
        <?php else: ?>
            <ul class="list-group list-group-flush">
                <?php while ($row = $result->fetch_assoc()): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span class="<?= !empty($row['completed']) ? 'text-decoration-line-through text-muted' : '' ?>">
                            <?= htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8') ?>
                        </span>
                        <div class="d-flex gap-2">
                            <a href="actions.php?action=update&id=<?= (int)$row['id'] ?>" class="btn btn-sm btn-success" title="Switch Status"></a>
                            <a href="actions.php?action=delete&id=<?= (int)$row['id'] ?>" class="btn btn-sm btn-danger" title="Delete"></a>
                        </div>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php endif; ?>
    </div>

    <div class="text-center">
        <form action="actions.php?action=add" method="POST" class="d-flex justify-content-center gap-2 mt-2" style="max-width: 640px; margin: 0 auto;">
            <input type="text" name="title" class="form-control" placeholder="Add New Task" required>
            <button type="submit" class="btn btn-success fw-bold">
                Add
            </button>
        </form>
    </div>
</main>

<footer>
    Developed by: Omar Abd alRahaman Yosuf alJamal - <strong>1320225259</strong></footer>

</body>
</html>
