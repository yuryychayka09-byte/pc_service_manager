<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}
require_once '../config/database.php';

$clients = $db->query("
    SELECT *
    FROM clients
    ORDER BY id DESC
")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="uk">

<head>
    <meta charset="UTF-8">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <title>Clients</title>
</head>

<body>
<?php require_once '../templates/navbar.php'; 
$clients = $db->query("
    SELECT *
    FROM clients
    ORDER BY id DESC
")->fetchAll(PDO::FETCH_ASSOC);?>
<div class="container mt-4">

    <h1>Клієнти</h1>

    <a href="create.php"
       class="btn btn-success mb-3">
        Додати клієнта
    </a>

    <table class="table table-striped">

        <thead>

        <tr>
            <th>ID</th>
            <th>ПІБ</th>
            <th>Телефон</th>
            <th>Email</th>
            <th>Адреса</th>
            <th>Дії</th>
        </tr>

        </thead>

        <tbody>

        <?php foreach ($clients as $client): ?>

            <tr>

                <td><?= $client['id'] ?></td>

                <td><?= $client['fullname'] ?></td>

                <td><?= $client['phone'] ?></td>

                <td><?= $client['email'] ?></td>

                <td><?= $client['address'] ?></td>

                <td>

                    <a href="edit.php?id=<?= $client['id'] ?>"
                       class="btn btn-warning btn-sm">
                        Змінити
                    </a>

                    <a href="delete.php?id=<?= $client['id'] ?>"
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