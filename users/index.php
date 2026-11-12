<?php

session_start();
if ($_SESSION['role'] !== 'admin') {

    header("Location: ../dashboard.php");

    exit;
}
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

require_once '../config/database.php';

$users = $db->query("
    SELECT *
    FROM users
    ORDER BY id DESC
")->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="uk">

<head>

<meta charset="UTF-8">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet">

<link rel="stylesheet"
      href="/pc_service_manager/assets/css/theme.css">

<title>Користувачі</title>

</head>

<body>

<?php require_once '../templates/navbar.php'; ?>

<div class="container mt-4">

<h1>Користувачі</h1>

<a href="create.php"
   class="btn demon-btn mb-3">

Додати користувача

</a>

<table class="table">

<thead>

<tr>

<th>ID</th>
<th>Логін</th>
<th>ПІБ</th>
<th>Роль</th>
<th>Дії</th>

</tr>

</thead>

<tbody>

<?php foreach ($users as $user): ?>

<tr>

<td><?= $user['id'] ?></td>

<td><?= $user['username'] ?></td>

<td><?= $user['fullname'] ?></td>

<td><?= $user['role'] ?></td>

<td>

<a href="edit.php?id=<?= $user['id'] ?>"
   class="btn btn-warning btn-sm">

Змінити

</a>

<?php if ($_SESSION['role'] === 'admin'): ?>

<a href="delete.php?id=<?= $client['id'] ?>"
   class="btn btn-danger btn-sm">

    Видалити

</a>

<?php endif; ?>


</td>

</tr>

<?php endforeach; ?>

</tbody>

</table>

</div>

</body>
</html>