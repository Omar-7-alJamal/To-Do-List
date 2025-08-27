<?php include 'config.php'; ?>
<?php
$message = '';
$alertType = 'danger';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // التحقق من صيغة اسم المستخدم
    if (!preg_match('/^[a-zA-Z][a-zA-Z0-9_]{3,19}$/', $username)) {
        $message = "Username must start with a letter and be 4 or above characters using letters, numbers, or underscores only.";
    }
    // التحقق من طول كلمة المرور
    elseif (strlen($password) < 8) {
        $message = "Password must be at least 8 characters.";
    } else {
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
                $message = "Wrong password.";
            }
        } else {
            $message = "Username not found.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Log in </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>

<header>
    <nav class="navbar navbar-dark bg-primary shadow fixed-top">
        <div class="container-fluid d-flex justify-content-between align-items-center px-4">
            <span class="navbar-brand mb-0 h1 fw-bold">To Do List App</span>
        </div>
    </nav>
</header>

<main class="container full-height-center">
    <div class="card w-100" style="max-width: 400px;">
        <h4 class="text-center mb-4 text-primary">Log in</h4>

        <?php if ($message): ?>
            <div class="alert alert-<?= $alertType ?> text-center"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <form method="POST">
            <input type="text" name="username" class="form-control mb-3" placeholder="Username"
            pattern="^[a-zA-Z][a-zA-Z0-9_]{3,19}$"
            title="Username must start with a letter and be 4-20 characters with letters, numbers, or underscores" required>
            <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>
            <button type="submit" class="btn btn-primary w-100">Log in</button>
        </form>

        <p class="text-center mt-3 text-muted">You don't have an account? <a href="signup.php">Sign up</a></p>
    </div>
</main>

<footer>
    Developed by: Omar Abd alRahaman Yosuf alJamal - <strong>1320225259</strong>
</footer>

</body>
</html>
