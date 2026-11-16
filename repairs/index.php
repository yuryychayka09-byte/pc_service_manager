<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

require_once '../config/database.php';

$repairs = $db->query("
    SELECT
        repair_requests.*,
        clients.fullname AS client_name,
        devices.model AS device_model,
        users.fullname AS master_name,
        statuses.name AS status_name
    FROM repair_requests

    LEFT JOIN clients
        ON repair_requests.client_id = clients.id

    LEFT JOIN devices
        ON repair_requests.device_id = devices.id

    LEFT JOIN users
        ON repair_requests.master_id = users.id

    LEFT JOIN statuses
        ON repair_requests.status_id = statuses.id

    ORDER BY repair_requests.id DESC
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

<title>Заявки</title>

</head>

<body>

<?php require_once '../templates/navbar.php'; ?>

<div class="container mt-4">
<input
    type="text"
    id="searchInput"
    class="form-control mb-4 search-box"
    placeholder=" Пошук клієнта...">
<h1>Заявки на ремонт</h1>

<a href="create.php"
   class="btn demon-btn mb-3">

    Створити заявку

</a>

<table class="table">

<thead>

<tr>

<th>ID</th>
<th>Клієнт</th>
<th>Техніка</th>
<th>Майстер</th>
<th>Статус</th>
<th>Дії</th>

</tr>

</thead>

<tbody>

<?php foreach ($repairs as $repair): ?>

<tr>

<td><?= $repair['id'] ?></td>

<td><?= $repair['client_name'] ?></td>

<td><?= $repair['device_model'] ?></td>

<td><?= $repair['master_name'] ?></td>

<td>

<?php if ($repair['status_name'] === 'Нова'): ?>

<span class="badge bg-primary">
    Нова
</span>

<?php elseif ($repair['status_name'] === 'Діагностика'): ?>

<span class="badge bg-warning text-dark">
    Діагностика
</span>

<?php elseif ($repair['status_name'] === 'В роботі'): ?>

<span class="badge bg-info text-dark">
    В роботі
</span>

<?php elseif ($repair['status_name'] === 'Готово'): ?>

<span class="badge bg-success">
    Готово
</span>

<?php elseif ($repair['status_name'] === 'Видано'): ?>

<span class="badge bg-secondary">
    Видано
</span>

<?php else: ?>

<span class="badge bg-dark">
    <?= $repair['status_name'] ?>
</span>

<?php endif; ?>

</td>

<td>

<a href="edit.php?id=<?= $repair['id'] ?>"
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
<script>

document
.getElementById('searchInput')
.addEventListener('keyup', function () {

    let value = this.value.toLowerCase();

    let rows = document.querySelectorAll('tbody tr');

    rows.forEach(function(row){

        let text = row.textContent.toLowerCase();

        row.style.display =
            text.includes(value)
            ? ''
            : 'none';

    });

});

</script>
<?php require_once '../templates/footer.php'; ?>
</body>
</html>