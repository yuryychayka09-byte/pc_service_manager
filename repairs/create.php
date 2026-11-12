<?php

session_start();
require_once '../config/auth.php';

requireLogin();

requireAdminOrOperator();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

require_once '../config/database.php';

$clients = $db->query("
    SELECT *
    FROM clients
")->fetchAll(PDO::FETCH_ASSOC);

$devices = $db->query("
    SELECT *
    FROM devices
")->fetchAll(PDO::FETCH_ASSOC);

$masters = $db->query("
    SELECT *
    FROM users
    WHERE role = 'master'
")->fetchAll(PDO::FETCH_ASSOC);

$statuses = $db->query("
    SELECT *
    FROM statuses
")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $stmt = $db->prepare("
        INSERT INTO repair_requests
        (
            client_id,
            device_id,
            master_id,
            problem_description,
            status_id
        )
        VALUES (?, ?, ?, ?, ?)
    ");

    $stmt->execute([

        $_POST['client_id'],
        $_POST['device_id'],
        $_POST['master_id'],
        $_POST['problem_description'],
        $_POST['status_id']

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

<title>Нова заявка</title>

</head>

<body>

<?php require_once '../templates/navbar.php'; ?>

<div class="container mt-4">

<h1>Створення заявки</h1>

<form method="POST">

<div class="mb-3">

<label>Клієнт</label>

<select name="client_id"
        class="form-control">

<?php foreach($clients as $client): ?>

<option value="<?= $client['id'] ?>">

<?= $client['fullname'] ?>

</option>

<?php endforeach; ?>

</select>

</div>

<div class="mb-3">

<label>Техніка</label>

<select name="device_id"
        class="form-control">

<?php foreach($devices as $device): ?>

<option value="<?= $device['id'] ?>">

<?= $device['manufacturer'] ?>
<?= $device['model'] ?>

</option>

<?php endforeach; ?>

</select>

</div>

<div class="mb-3">

<label>Майстер</label>

<select name="master_id"
        class="form-control">

<?php foreach($masters as $master): ?>

<option value="<?= $master['id'] ?>">

<?= $master['fullname'] ?>

</option>

<?php endforeach; ?>

</select>

</div>

<div class="mb-3">

<label>Статус</label>

<select name="status_id"
        class="form-control">

<?php foreach($statuses as $status): ?>

<option value="<?= $status['id'] ?>">

<?= $status['name'] ?>

</option>

<?php endforeach; ?>

</select>

</div>

<div class="mb-3">

<label>Опис несправності</label>

<textarea
    name="problem_description"
    class="form-control"
    rows="4"></textarea>

</div>

<button class="btn demon-btn">

Створити заявку

</button>

</form>

</div>

</body>
</html>