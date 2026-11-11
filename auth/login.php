<?php

session_start();

require_once '../config/database.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $db->prepare("
        SELECT *
        FROM users
        WHERE username = ?
    ");

    $stmt->execute([$username]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && $password === $user['password']) {

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['fullname'] = $user['fullname'];
        $_SESSION['role'] = $user['role'];

        header("Location: ../dashboard.php");
        exit;
    }

    $error = "Невірний логін або пароль";
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>

<h2>PC Service Manager</h2>

<?php if ($error): ?>
    <p style="color:red;">
        <?= $error ?>
    </p>
<?php endif; ?>

<form method="POST">

    <div>
        <label>Логін</label>
        <br>
        <input type="text" name="username" required>
    </div>

    <br>

    <div>
        <label>Пароль</label>
        <br>
        <input type="password" name="password" required>
    </div>

    <br>

    <button type="submit">
        Увійти
    </button>

</form>

</body>
</html>