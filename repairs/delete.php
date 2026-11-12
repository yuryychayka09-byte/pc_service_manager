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

require_once '../config/database.php';

$id = $_GET['id'];

$stmt = $db->prepare("
    DELETE FROM repair_requests
    WHERE id = ?
");

$stmt->execute([$id]);

header("Location: index.php");
exit;