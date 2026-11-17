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
<html lang="uk">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>PC Service Manager</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet">

<link rel="stylesheet"
      href="/pc_service_manager/assets/css/theme.css">

</head>

<body class="login-page">

<div class="login-card">

    <div class="text-center mb-4">

        <h1>PC Service Manager</h1>

        <p class="mb-0">
            Система управління сервісним центром
        </p>

    </div>

    <?php if ($error): ?>

        <div class="alert alert-danger">

            <?= $error ?>

        </div>

    <?php endif; ?>

    <form method="POST">

        <div class="mb-3">

            <label class="form-label">

                Логін

            </label>

            <input
                type="text"
                name="username"
                class="form-control"
                required>

        </div>

        <div class="mb-3">

            <label class="form-label">

                Пароль

            </label>

            <input
                type="password"
                name="password"
                class="form-control"
                required>

        </div>

        <button
            type="submit"
            class="btn demon-btn w-100">

            Увійти

        </button>

    </form>

</div>

</body>

</html>