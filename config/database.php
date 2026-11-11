<?php

try {
    $db = new PDO(
        'sqlite:' . __DIR__ . '/../database/service_center.db'
    );

    $db->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );

} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
