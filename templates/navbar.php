<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<nav class="navbar navbar-expand-lg navbar-dark">

    <div class="container-fluid">

        <a class="navbar-brand"
           href="/pc_service_manager/dashboard.php">
            PC Service Manager
        </a>

        <ul class="navbar-nav me-auto">

            <li class="nav-item">
                <a class="nav-link"
                   href="/pc_service_manager/dashboard.php">
                    Головна
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link"
                   href="/pc_service_manager/clients/index.php">
                    Клієнти
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link"
                   href="/pc_service_manager/devices/index.php">
                    Техніка
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link"
                   href="/pc_service_manager/repairs/index.php">
                    Заявки
                </a>
            </li>

            <?php if ($_SESSION['role'] === 'admin'): ?>

            <li class="nav-item">
                <a class="nav-link"
                   href="/pc_service_manager/users/index.php">
                    Користувачі
                </a>
            </li>

            <?php endif; ?>
<li class="nav-item">
    <a class="nav-link"
       href="/pc_service_manager/operations/index.php">
         Роботи
    </a>
    
</li>
        </ul>

        <span class="navbar-user me-3">

         <?= $_SESSION['fullname'] ?>

        </span>

<button
    id="themeToggle"
    class="btn demon-btn me-2">

     Тема

</button>
        <a href="/pc_service_manager/auth/logout.php"
           class="btn btn-danger">
            Вийти
        </a>

    </div>

</nav>