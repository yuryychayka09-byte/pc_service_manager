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

$id = $_GET['id'];

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

$stmt = $db->prepare("
    SELECT *
    FROM repair_requests
    WHERE id = ?
");

$stmt->execute([$id]);

$repair = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $stmt = $db->prepare("
        UPDATE repair_requests
        SET
            client_id = ?,
            device_id = ?,
            master_id = ?,
            problem_description = ?,
            status_id = ?
        WHERE id = ?
    ");

    $stmt->execute([

        $_POST['client_id'],
        $_POST['device_id'],
        $_POST['master_id'],
        $_POST['problem_description'],
        $_POST['status_id'],
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

<title>Редагування заявки</title>

</head>

<body>

<?php require_once '../templates/navbar.php'; ?>

<div class="container mt-4">

<h1>Редагування заявки</h1>

<form method="POST">

<div class="mb-3">

<label>Клієнт</label>

<select name="client_id" class="form-control">

<?php foreach($clients as $client): ?>

<option
value="<?= $client['id'] ?>"
<?= $client['id'] == $repair['client_id'] ? 'selected' : '' ?>>

<?= $client['fullname'] ?>

</option>

<?php endforeach; ?>

</select>

</div>

<div class="mb-3">

<label>Техніка</label>

<select name="device_id" class="form-control">

<?php foreach($devices as $device): ?>

<option
value="<?= $device['id'] ?>"
<?= $device['id'] == $repair['device_id'] ? 'selected' : '' ?>>

<?= $device['manufacturer'] ?>
<?= $device['model'] ?>

</option>

<?php endforeach; ?>

</select>

</div>

<div class="mb-3">

<label>Майстер</label>

<select name="master_id" class="form-control">

<?php foreach($masters as $master): ?>

<option
value="<?= $master['id'] ?>"
<?= $master['id'] == $repair['master_id'] ? 'selected' : '' ?>>

<?= $master['fullname'] ?>

</option>

<?php endforeach; ?>

</select>

</div>

<div class="mb-3">

<label>Статус</label>

<select name="status_id" class="form-control">

<?php foreach($statuses as $status): ?>

<option
value="<?= $status['id'] ?>"
<?= $status['id'] == $repair['status_id'] ? 'selected' : '' ?>>

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
rows="4"><?= $repair['problem_description'] ?></textarea>

</div>

<button class="btn demon-btn">

Зберегти зміни

</button>

</form>

</div>

</body>
</html>