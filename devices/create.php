<?php

session_start();

require_once '../config/database.php';

$clients = $db->query("
    SELECT *
    FROM clients
    ORDER BY fullname
")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $stmt = $db->prepare("
        INSERT INTO devices
        (
            client_id,
            type,
            manufacturer,
            model,
            serial_number,
            notes
        )
        VALUES (?, ?, ?, ?, ?, ?)
    ");

    $stmt->execute([
        $_POST['client_id'],
        $_POST['type'],
        $_POST['manufacturer'],
        $_POST['model'],
        $_POST['serial_number'],
        $_POST['notes']
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

    <title>Додати техніку</title>

</head>

<body>

<?php require_once '../templates/navbar.php'; ?>

<div class="container mt-4">

    <h1>Додати техніку</h1>

    <form method="POST">

        <div class="mb-3">

            <label>Клієнт</label>

            <select name="client_id"
                    class="form-control">

                <?php foreach ($clients as $client): ?>

                    <option value="<?= $client['id'] ?>">

                        <?= $client['fullname'] ?>

                    </option>

                <?php endforeach; ?>

            </select>

        </div>

        <div class="mb-3">

            <label>Тип пристрою</label>

            <input type="text"
                   name="type"
                   class="form-control">

        </div>

        <div class="mb-3">

            <label>Виробник</label>

            <input type="text"
                   name="manufacturer"
                   class="form-control">

        </div>

        <div class="mb-3">

            <label>Модель</label>

            <input type="text"
                   name="model"
                   class="form-control">

        </div>

        <div class="mb-3">

            <label>Серійний номер</label>

            <input type="text"
                   name="serial_number"
                   class="form-control">

        </div>

        <div class="mb-3">

            <label>Примітки</label>

            <textarea name="notes"
                      class="form-control"></textarea>

        </div>

        <button class="btn demon-btn">
            Зберегти
        </button>

    </form>

</div>

</body>
</html>