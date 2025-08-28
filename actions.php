<?php
include 'config.php';
// get data from database
$userId = $_SESSION['user_id'] ?? null;
$action = $_GET['action'] ?? '';
$id = isset($_GET['id']) ? intval($_GET['id']) : null;

// check if user is logged in
if (!$userId) {
    header("Location: login.php");
    exit();
}
// perform action
switch ($action) {
   case 'add':
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty(trim($_POST['title']))) {
        $userId = $_SESSION['user_id'];
        $title = trim($_POST['title']);
        $description = trim($_POST['description']);
        $importance = $_POST['importance'];
        $due_date = $_POST['due_date'];
        $category = trim($_POST['category']);

        $stmt = $conn->prepare("INSERT INTO tasks (title, description, importance, due_date, category, user_id) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssi", $title, $description, $importance, $due_date, $category, $userId);
        $stmt->execute();
    }
    break;

    case 'edit':
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty(trim($_POST['title']))) {
        $id = intval($_GET['id']);
        $userId = $_SESSION['user_id'];
        $title = trim($_POST['title']);
        $description = trim($_POST['description']);
        $importance = $_POST['importance'];
        $due_date = $_POST['due_date'];
        $category = trim($_POST['category']);
        $stmt = $conn->prepare("
            UPDATE tasks 
            SET title = ?, description = ?, importance = ?, due_date = ?, category = ? 
            WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ssssssi", $title, $description, $importance, $due_date, $category, $id, $userId);
        $stmt->execute();
    }
    break;

    case 'update':
        if ($id !== null) {
            $stmt = $conn->prepare("UPDATE tasks SET completed = NOT completed WHERE id = ? AND user_id = ?");
            $stmt->bind_param("ii", $id, $userId);
            $stmt->execute();
        }
        break;

    case 'delete':
        if ($id !== null) {
            $stmt = $conn->prepare("DELETE FROM tasks WHERE id = ? AND user_id = ?");
            $stmt->bind_param("ii", $id, $userId);
            $stmt->execute();
        }
        break;
}

header("Location: index.php");
exit();

