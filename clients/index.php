<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

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

<div class="container mt-4">

    <h1>Клієнти</h1>

    <a href="create.php"
       class="btn btn-success mb-3">
        Додати клієнта
    </a>

</div>

</body>
</html>