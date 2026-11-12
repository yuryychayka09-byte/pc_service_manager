<?php

session_start();
require_once '../config/auth.php';

requireLogin();

requireAdminOrOperator();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../dashboard.php");
    exit;
}

require_once '../config/database.php';

$id = $_GET['id'];

$stmt = $db->prepare("
    SELECT *
    FROM users
    WHERE id = ?
");

$stmt->execute([$id]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $stmt = $db->prepare("
        UPDATE users
        SET
            username = ?,
            password = ?,
            fullname = ?,
            role = ?
        WHERE id = ?
    ");

    $stmt->execute([
        $_POST['username'],
        $_POST['password'],
        $_POST['fullname'],
        $_POST['role'],
        $id
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

<title>Редагування користувача</title>

</head>

<body>

<?php require_once '../templates/navbar.php'; ?>

<div class="container mt-4">

<h1>Редагування користувача</h1>

<form method="POST">

<div class="mb-3">

<label>Логін</label>

<input
    type="text"
    name="username"
    class="form-control"
    value="<?= $user['username'] ?>">

</div>

<div class="mb-3">

<label>Пароль</label>

<input
    type="text"
    name="password"
    class="form-control"
    value="<?= $user['password'] ?>">

</div>

<div class="mb-3">

<label>ПІБ</label>

<input
    type="text"
    name="fullname"
    class="form-control"
    value="<?= $user['fullname'] ?>">

</div>

<div class="mb-3">

<label>Роль</label>

<select
    name="role"
    class="form-control">

<option
    value="admin"
    <?= $user['role'] === 'admin' ? 'selected' : '' ?>>
    Адміністратор
</option>

<option
    value="operator"
    <?= $user['role'] === 'operator' ? 'selected' : '' ?>>
    Оператор
</option>

<option
    value="master"
    <?= $user['role'] === 'master' ? 'selected' : '' ?>>
    Майстер
</option>

</select>

</div>

<button class="btn demon-btn">

Зберегти зміни

</button>

</form>

</div>

</body>
</html>