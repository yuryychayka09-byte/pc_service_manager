<?php

session_start();
require_once '../config/auth.php';

requireLogin();

requireAdmin();
if ($_SESSION['role'] !== 'admin') {

    header("Location: ../dashboard.php");
    exit;
}
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../dashboard.php");
    exit;
}

require_once '../config/database.php';

$id = $_GET['id'];

/* не даємо видалити самого себе */

if ($id == $_SESSION['user_id']) {

    header("Location: index.php");
    exit;
}

$stmt = $db->prepare("
    DELETE FROM users
    WHERE id = ?
");

$stmt->execute([$id]);

header("Location: index.php");
exit;