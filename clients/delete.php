<?php

session_start();
session_start();

require_once '../config/auth.php';

requireLogin();

requireAdmin();

require_once '../config/database.php';

$id = $_GET['id'];

$stmt = $db->prepare("
    DELETE FROM clients
    WHERE id = ?
");

$stmt->execute([$id]);

header("Location: index.php");
exit;