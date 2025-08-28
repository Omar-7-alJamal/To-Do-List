<?php
session_start();

// connect to database
$host = "localhost";
$user = "root";
$password = "";
$database = "todo_app";

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die("connection failed " . $conn->connect_error);
}

// check if user is logged in
$page = basename($_SERVER['PHP_SELF']);
$public = ['login.php', 'signup.php'];
if (!isset($_SESSION['user_id']) && !in_array($page, $public)) {
    header("Location: login.php");
    exit();
}
?>
