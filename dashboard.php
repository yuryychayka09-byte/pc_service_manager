<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit;
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>

<h1>Головна панель</h1>

<p>
    Користувач:
    <?= $_SESSION['fullname']; ?>
</p>

<p>
    Роль:
    <?= $_SESSION['role']; ?>
</p>

<a href="auth/logout.php">
    Вийти
</a>

</body>
</html>
