<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

require_once '../config/database.php';

$id = $_GET['id'];

$clients = $db->query("
    SELECT *
    FROM clients
    ORDER BY fullname
")->fetchAll(PDO::FETCH_ASSOC);

$stmt = $db->prepare("
    SELECT *
    FROM devices
    WHERE id = ?
");

$stmt->execute([$id]);

$device = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $stmt = $db->prepare("
        UPDATE devices
        SET
            client_id = ?,
            type = ?,
            manufacturer = ?,
            model = ?,
            serial_number = ?,
            notes = ?
        WHERE id = ?
    ");

    $stmt->execute([
        $_POST['client_id'],
        $_POST['type'],
        $_POST['manufacturer'],
        $_POST['model'],
        $_POST['serial_number'],
        $_POST['notes'],
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

<title>Редагування техніки</title>

</head>

<body>

<?php require_once '../templates/navbar.php'; ?>

<div class="container mt-4">

<h1>Редагування техніки</h1>

<form method="POST">

<div class="mb-3">

<label>Клієнт</label>

<select name="client_id"
        class="form-control">

<?php foreach ($clients as $client): ?>

<option
value="<?= $client['id'] ?>"
<?= $client['id'] == $device['client_id'] ? 'selected' : '' ?>>

<?= $client['fullname'] ?>

</option>

<?php endforeach; ?>

</select>

</div>

<div class="mb-3">

<label>Тип</label>

<input type="text"
       name="type"
       value="<?= $device['type'] ?>"
       class="form-control">

</div>

<div class="mb-3">

<label>Виробник</label>

<input type="text"
       name="manufacturer"
       value="<?= $device['manufacturer'] ?>"
       class="form-control">

</div>

<div class="mb-3">

<label>Модель</label>

<input type="text"
       name="model"
       value="<?= $device['model'] ?>"
       class="form-control">

</div>

<div class="mb-3">

<label>Серійний номер</label>

<input type="text"
       name="serial_number"
       value="<?= $device['serial_number'] ?>"
       class="form-control">

</div>

<div class="mb-3">

<label>Примітки</label>

<textarea
name="notes"
class="form-control"><?= $device['notes'] ?></textarea>

</div>

<button class="btn demon-btn">

Зберегти

</button>

</form>

</div>

</body>
</html>