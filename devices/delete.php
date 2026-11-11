<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

require_once '../config/database.php';

$id = $_GET['id'];

$stmt = $db->prepare("
    DELETE FROM devices
    WHERE id = ?
");

$stmt->execute([$id]);

header("Location: index.php");
exit;