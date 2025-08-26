<?php
include 'config.php';

$userId = $_SESSION['user_id'] ?? null;
$action = $_GET['action'] ?? '';
$id = isset($_GET['id']) ? intval($_GET['id']) : null;

if (!$userId) {
    header("Location: login.php");
    exit();
}

switch ($action) {
    case 'add':
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty(trim($_POST['title']))) {
            $title = trim($_POST['title']);
            $stmt = $conn->prepare("INSERT INTO tasks (title, user_id) VALUES (?, ?)");
            $stmt->bind_param("si", $title, $userId);
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
