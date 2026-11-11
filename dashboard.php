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
    <link rel="stylesheet"
      href="/pc_service_manager/assets/css/theme.css">
      <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>

<body>

<?php require_once 'templates/navbar.php'; ?>

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

    <a href="clients/index.php"
       class="text-decoration-none">

        <div class="card demon-card">

            <div class="card-body">

                <h5>Клієнти</h5>
                <h2>0</h2>

            </div>

        </div>

    </a>

</div>

        <div class="col-md-3">
            <div class="card demon-card">
                <div class="card-body">
                    <h5>Техніка</h5>
                    <h2>0</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card demon-card">
                <div class="card-body">
                    <h5>Ремонти</h5>
                    <h2>0</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card demon-card">
                <div class="card-body">
                    <h5>Майстри</h5>
                    <h2>0</h2>
                </div>
            </div>
        </div>
        
    </div>


</div>


</body>
</html>