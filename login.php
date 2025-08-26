<?php include 'config.php'; ?>
<?php
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($userId, $hashed);
        $stmt->fetch();

        if (password_verify($password, $hashed)) {
            $_SESSION['user_id'] = $userId;
            header("Location: index.php");
            exit();
        } else {
            $message = "كلمة المرور غير صحيحة.";
        }
    } else {
        $message = "اسم المستخدم غير موجود.";
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تسجيل الدخول</title>
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
        <h4 class="text-center mb-4 text-primary">تسجيل الدخول</h4>

        <?php if ($message): ?>
            <div class="alert alert-danger text-center"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <form method="POST">
            <input type="text" name="username" class="form-control mb-3" placeholder="البريد الإلكتروني" required>
            <input type="password" name="password" class="form-control mb-3" placeholder="كلمة المرور" required>
            <button type="submit" class="btn btn-primary w-100">تسجيل الدخول</button>
        </form>

        <p class="text-center mt-3 text-muted">ليس لديك حساب؟ <a href="signup.php">إنشاء حساب</a></p>
    </div>
</main>

<footer>
    تم التطوير بواسطة الطالب: عمر عبد الرحمن يوسف الجمل - <strong>1320225259</strong>
</footer>

</body>
</html>
