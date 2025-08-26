<?php
session_start();

// إعداد الاتصال بقاعدة البيانات
$host = "localhost";
$user = "root";
$password = "";
$database = "todo_app";

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}

// حماية الصفحات (التي ليست تسجيل أو تسجيل دخول)
$page = basename($_SERVER['PHP_SELF']);
$public = ['login.php', 'signup.php'];
if (!isset($_SESSION['user_id']) && !in_array($page, $public)) {
    header("Location: login.php");
    exit();
}
?>
