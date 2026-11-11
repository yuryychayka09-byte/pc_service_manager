<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

require_once '../config/database.php';

$devices = $db->query("
    SELECT
        devices.*,
        clients.fullname AS client_name
    FROM devices
    LEFT JOIN clients
        ON devices.client_id = clients.id
    ORDER BY devices.id DESC
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

    <title>Техніка</title>
</head>

<body>

<?php require_once '../templates/navbar.php'; ?>

<div class="container mt-4">

    <h1>Техніка</h1>

    <a href="create.php"
       class="btn demon-btn mb-3">
        Додати техніку
    </a>

    <table class="table">

        <thead>
        <tr>
            <th>ID</th>
            <th>Клієнт</th>
            <th>Тип</th>
            <th>Виробник</th>
            <th>Модель</th>
            <th>Серійний номер</th>
            <th>Дії</th>
        </tr>
        </thead>

        <tbody>

        <?php foreach ($devices as $device): ?>

            <tr>

                <td><?= $device['id'] ?></td>

                <td><?= $device['client_name'] ?></td>

                <td><?= $device['type'] ?></td>

                <td><?= $device['manufacturer'] ?></td>

                <td><?= $device['model'] ?></td>

                <td><?= $device['serial_number'] ?></td>

                <td>

                    <a href="edit.php?id=<?= $device['id'] ?>"
                       class="btn btn-warning btn-sm">
                        Змінити
                    </a>

                    <a href="delete.php?id=<?= $device['id'] ?>"
                       class="btn btn-danger btn-sm">
                        Видалити
                    </a>

                </td>

            </tr>

        <?php endforeach; ?>

        </tbody>

    </table>

</div>

</body>
</html>