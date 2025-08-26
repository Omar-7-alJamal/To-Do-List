<?php include 'config.php'; ?>
<?php
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if ($username && $password) {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $hashed);

        if ($stmt->execute()) {
            header("Location: login.php");
            exit();
        } else {
            $message = "هذا المستخدم موجود مسبقًا.";
        }
    } else {
        $message = "يرجى إدخال بيانات صحيحة.";
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إنشاء حساب</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>

<header>
    <nav class="navbar navbar-dark bg-primary shadow">
        <div class="container-fluid d-flex justify-content-between align-items-center px-4">
            <span class="navbar-brand mb-0 h1 fw-bold">تطبيق قائمة المهام</span>
        </div>
    </nav>
</header>

<main class="container full-height-center">
    <div class="card w-100" style="max-width: 400px;">
        <h4 class="text-center mb-4 text-primary">إنشاء حساب جديد</h4>

        <?php if ($message): ?>
            <div class="alert alert-warning text-center"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <form method="POST">
            <input type="text" name="username" class="form-control mb-3" placeholder="البريد الإلكتروني" required>
            <input type="password" name="password" class="form-control mb-3" placeholder="كلمة المرور" required>
            <button type="submit" class="btn btn-primary w-100">إنشاء الحساب</button>
        </form>

        <p class="text-center mt-3 text-muted">لديك حساب؟ <a href="login.php">تسجيل الدخول</a></p>
    </div>
</main>

<footer>
    تم التطوير بواسطة الطالب: عمر عبد الرحمن يوسف الجمل - <strong>1320225259</strong>
</footer>

</body>
</html>
