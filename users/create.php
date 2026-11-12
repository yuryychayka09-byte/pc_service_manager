<?php

session_start();
require_once '../config/auth.php';

requireLogin();

requireAdminOrOperator();
if ($_SESSION['role'] !== 'admin') {

    header("Location: ../dashboard.php");

    exit;
}
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $stmt = $db->prepare("
        INSERT INTO users
        (
            username,
            password,
            fullname,
            role
        )
        VALUES (?, ?, ?, ?)
    ");

    $stmt->execute([
        $_POST['username'],
        $_POST['password'],
        $_POST['fullname'],
        $_POST['role']
    ]);

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="uk">

<head>

<meta charset="UTF-8">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet">

<link rel="stylesheet"
      href="/pc_service_manager/assets/css/theme.css">

<title>Новий користувач</title>

</head>

<body>

<?php require_once '../templates/navbar.php'; ?>

<div class="container mt-4">

<h1>Новий користувач</h1>

<form method="POST">

<div class="mb-3">
<label>Логін</label>
<input type="text"
       name="username"
       class="form-control">
</div>

<div class="mb-3">
<label>Пароль</label>
<input type="text"
       name="password"
       class="form-control">
</div>

<div class="mb-3">
<label>ПІБ</label>
<input type="text"
       name="fullname"
       class="form-control">
</div>

<div class="mb-3">

<label>Роль</label>

<select name="role"
        class="form-control">

<option value="admin">
Адміністратор
</option>

<option value="operator">
Оператор
</option>

<option value="master">
Майстер
</option>

</select>

</div>

<button class="btn demon-btn">

Створити

</button>

</form>

</div>

</body>
</html>