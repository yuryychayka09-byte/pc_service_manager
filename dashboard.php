<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="uk">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>

<body>

<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <span class="navbar-brand">
            PC Service Manager
        </span>

        <a href="auth/logout.php"
           class="btn btn-danger">
            Вийти
        </a>
    </div>
</nav>

<div class="container mt-4">

    <h1>Головна панель</h1>

    <p>
        Користувач:
        <strong><?= $_SESSION['fullname']; ?></strong>
    </p>

    <p>
        Роль:
        <strong><?= $_SESSION['role']; ?></strong>
    </p>

    <div class="row mt-4">

        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5>Клієнти</h5>
                    <h2>0</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5>Техніка</h5>
                    <h2>0</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-warning text-dark">
                <div class="card-body">
                    <h5>Ремонти</h5>
                    <h2>0</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <h5>Майстри</h5>
                    <h2>0</h2>
                </div>
            </div>
        </div>
        <div class="mt-4">
    <a href="clients/index.php"
       class="btn btn-primary">
        Клієнти
    </a>
        </div>
    </div>

</div>

</body>
</html>