<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

require_once '../config/database.php';

$repairs = $db->query("
    SELECT id
    FROM repair_requests
    ORDER BY id DESC
")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $stmt = $db->prepare("
        INSERT INTO repair_operations
        (
            request_id,
            operation_name,
            description,
            cost
        )
        VALUES (?, ?, ?, ?)
    ");

    $stmt->execute([
        $_POST['request_id'],
        $_POST['operation_name'],
        $_POST['description'],
        $_POST['cost']
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

<title>Додати роботу</title>

</head>

<body>

<?php require_once '../templates/navbar.php'; ?>

<div class="container mt-4">

<h1>Додати виконану роботу</h1>

<form method="POST">

<div class="mb-3">

<label>Заявка</label>

<select
    name="request_id"
    class="form-control">

<?php foreach($repairs as $repair): ?>

<option value="<?= $repair['id'] ?>">

Заявка #<?= $repair['id'] ?>

</option>

<?php endforeach; ?>

</select>

</div>

<div class="mb-3">

<label>Назва роботи</label>

<input
    type="text"
    name="operation_name"
    class="form-control"
    required>

</div>

<div class="mb-3">

<label>Опис роботи</label>

<textarea
    name="description"
    class="form-control"
    rows="4"></textarea>

</div>

<div class="mb-3">

<label>Вартість</label>

<input
    type="number"
    step="0.01"
    name="cost"
    class="form-control"
    required>

</div>

<button class="btn demon-btn">

Зберегти

</button>

</form>

</div>

</body>
</html>