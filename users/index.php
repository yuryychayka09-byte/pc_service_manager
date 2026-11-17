<?php

session_start();

// Перевірка авторизації
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

// Перевірка прав адміністратора
if ($_SESSION['role'] !== 'admin') {
    header("Location: ../dashboard.php");
    exit;
}

require_once '../config/database.php';

// Отримання користувачів
$users = $db->query("
    SELECT *
    FROM users
    ORDER BY id DESC
")->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="uk">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link rel="stylesheet"
          href="/pc_service_manager/assets/css/theme.css">

    <title>Користувачі</title>

</head>

<body class="users-page">

    <?php require_once '../templates/navbar.php'; ?>

    <div class="container mt-4">

        <!-- Пошук -->
        <input
            type="text"
            id="searchInput"
            class="form-control mb-4 search-box"
            placeholder="Пошук користувача..."
        >

        <!-- Заголовок -->
        <h1>Користувачі</h1>

        <!-- Додавання користувача -->
        <a href="create.php" class="btn demon-btn mb-3">
            Додати користувача
        </a>

        <!-- Таблиця користувачів -->
        <table class="table users-table">

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Логін</th>
                    <th>ПІБ</th>
                    <th>Роль</th>
                    <th>Дії</th>
                </tr>
            </thead>

            <tbody>

                <?php foreach ($users as $user): ?>

                    <tr>

                        <td><?= htmlspecialchars($user['id']) ?></td>

                        <td><?= htmlspecialchars($user['username']) ?></td>

                        <td><?= htmlspecialchars($user['fullname']) ?></td>

                        <td><?= htmlspecialchars($user['role']) ?></td>

                        <td>

                            <a href="edit.php?id=<?= (int)$user['id'] ?>"
                               class="btn btn-warning btn-sm">

                                Змінити

                            </a>

                            <a href="delete.php?id=<?= (int)$user['id'] ?>"
                               class="btn btn-danger btn-sm">

                                Видалити

                            </a>

                        </td>

                    </tr>

                <?php endforeach; ?>

            </tbody>

        </table>

    </div>


    <!-- Пошук користувачів -->
    <script>

        document.getElementById('searchInput').addEventListener('keyup', function () {

            let value = this.value.toLowerCase();

            let rows = document.querySelectorAll('.users-table tbody tr');

            rows.forEach(function (row) {

                let text = row.textContent.toLowerCase();

                row.style.display = text.includes(value) ? '' : 'none';

            });

        });

    </script>

</body>
</html>