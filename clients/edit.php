<?php

session_start();
require_once '../config/auth.php';

requireLogin();

requireAdminOrOperator();
require_once '../config/database.php';

$id = $_GET['id'];

$stmt = $db->prepare("
    SELECT *
    FROM clients
    WHERE id = ?
");

$stmt->execute([$id]);

$client = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $stmt = $db->prepare("
        UPDATE clients
        SET
            fullname = ?,
            phone = ?,
            email = ?,
            address = ?
        WHERE id = ?
    ");

    $stmt->execute([
        $_POST['fullname'],
        $_POST['phone'],
        $_POST['email'],
        $_POST['address'],
        $id
    ]);

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="uk">
    
<head>
<link rel="stylesheet"
      href="/pc_service_manager/assets/css/theme.css">
    <meta charset="UTF-8">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <title>Редагування клієнта</title>

</head>

<body>

<?php require_once '../templates/navbar.php'; ?>

<div class="container mt-4">

    <h1>Редагування клієнта</h1>

    <form method="POST">

        <div class="mb-3">
            <label>ПІБ</label>

            <input
                type="text"
                name="fullname"
                class="form-control"
                value="<?= $client['fullname'] ?>"
                required>
        </div>

        <div class="mb-3">
            <label>Телефон</label>

            <input
                type="text"
                name="phone"
                class="form-control"
                value="<?= $client['phone'] ?>">
        </div>

        <div class="mb-3">
            <label>Email</label>

            <input
                type="email"
                name="email"
                class="form-control"
                value="<?= $client['email'] ?>">
        </div>

        <div class="mb-3">
            <label>Адреса</label>

            <input
                type="text"
                name="address"
                class="form-control"
                value="<?= $client['address'] ?>">
        </div>

        <button class="btn btn-success">
            Зберегти
        </button>

    </form>

</div>

</body>
</html>