<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">

        <a class="navbar-brand"
           href="/pc_service_manager/dashboard.php">

            PC Service Manager

        </a>

        <div class="collapse navbar-collapse">

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
                    <a class="nav-link" href="#">
                         Техніка
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">
                         Заявки
                    </a>
                </li>

            </ul>

            <span class="text-white me-3">
                <?= $_SESSION['fullname'] ?>
            </span>

            <a href="/pc_service_manager/auth/logout.php"
               class="btn btn-danger">
                Вийти
            </a>

        </div>

    </div>
</nav>