<?php

function requireLogin()
{
    if (!isset($_SESSION['user_id'])) {

        header("Location: ../auth/login.php");
        exit;
    }
}

function requireAdmin()
{
    if ($_SESSION['role'] !== 'admin') {

        header("Location: ../dashboard.php");
        exit;
    }
}

function requireAdminOrOperator()
{
    if (
        $_SESSION['role'] !== 'admin' &&
        $_SESSION['role'] !== 'operator'
    ) {

        header("Location: ../dashboard.php");
        exit;
    }
}