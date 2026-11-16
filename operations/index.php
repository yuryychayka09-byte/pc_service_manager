<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

require_once '../config/database.php';

$operations = $db->query("
    SELECT
        repair_operations.*,
        repair_requests.id AS repair_id,
        statuses.name AS status_name

    FROM repair_operations

    LEFT JOIN repair_requests
        ON repair_requests.id = repair_operations.request_id

    LEFT JOIN statuses
        ON statuses.id = repair_requests.status_id

    ORDER BY repair_operations.id DESC
")->fetchAll(PDO::FETCH_ASSOC);

$totalMoney = $db->query("
    SELECT COALESCE(SUM(cost),0)
    FROM repair_operations
")->fetchColumn();

?>

<!DOCTYPE html>
<html lang="uk">

<head>

<meta charset="UTF-8">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet">

<link rel="stylesheet"
      href="/pc_service_manager/assets/css/theme.css">

<title>Виконані роботи</title>

</head>

<body>

<?php require_once '../templates/navbar.php'; ?>

<div class="container mt-4">

<h1>Виконані роботи</h1>

<a href="create.php"
   class="btn demon-btn mb-3">

    Додати роботу

</a>

<table class="table">

<thead>

<tr>

<th>ID</th>
<th>Заявка</th>
<th>Статус</th>
<th>Назва роботи</th>
<th>Опис</th>
<th>Вартість</th>
<th>Дії</th>

</tr>

</thead>

<tbody>

<?php foreach($operations as $operation): ?>

<tr>

<td><?= $operation['id'] ?></td>

<td>

#<?= $operation['repair_id'] ?>

</td>

<td>

<?= $operation['status_name'] ?>

</td>

<td>

<?= $operation['operation_name'] ?>

</td>

<td>

<?= $operation['description'] ?>

</td>

<td>

<strong>

<?= $operation['cost'] ?> грн

</strong>

</td>

<td>

<a href="edit.php?id=<?= $operation['id'] ?>"
   class="demon-action">

    Змінити

</a>

<a href="delete.php?id=<?= $operation['id'] ?>"
   class="demon-action"
   onclick="return confirm('Видалити роботу?');">

    Видалити

</a>

</td>

</tr>

<?php endforeach; ?>

</tbody>

</table>



</div>
<?php require_once '../templates/footer.php'; ?>
</body>

</html>