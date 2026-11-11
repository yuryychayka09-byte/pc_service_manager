<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $fullname = $_POST['fullname'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    $stmt = $db->prepare("
        INSERT INTO clients
        (fullname, phone, email, address)
        VALUES (?, ?, ?, ?)
    ");

    $stmt->execute([
        $fullname,
        $phone,
        $email,
        $address
    ]);

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
    
<head>
<link rel="stylesheet"
      href="/pc_service_manager/assets/css/theme.css">
    <meta charset="UTF-8">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <title>Новий клієнт</title>

</head>

<body>
<?php require_once '../templates/navbar.php'; ?>
<div class="container mt-4">
<a href="index.php"
       class="btn btn-secondary mb-3">
        ← До списку клієнтів
    </a>
    <h1>Додати клієнта</h1>

    <form method="POST">

        <div class="mb-3">
            <label>ПІБ</label>
            <input
                type="text"
                name="fullname"
                class="form-control"
                required>
        </div>

        <div class="mb-3">
            <label>Телефон</label>
            <input
                type="text"
                name="phone"
                class="form-control">
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input
                type="email"
                name="email"
                class="form-control">
        </div>

        <div class="mb-3">
            <label>Адреса</label>
            <input
                type="text"
                name="address"
                class="form-control">
        </div>

        <button class="btn btn-success">
            Зберегти
        </button>

    </form>

</div>

</body>


</html>