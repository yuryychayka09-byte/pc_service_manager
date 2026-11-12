<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit;
}
require_once 'config/database.php';

$clientsCount = $db->query("
    SELECT COUNT(*) FROM clients
")->fetchColumn();

$devicesCount = $db->query("
    SELECT COUNT(*) FROM devices
")->fetchColumn();

$repairsCount = $db->query("
    SELECT COUNT(*) FROM repair_requests
")->fetchColumn();
$chartData = $db->query("
    SELECT
        statuses.name,
        COUNT(repair_requests.id) as total

    FROM statuses

    LEFT JOIN repair_requests
        ON repair_requests.status_id = statuses.id

    GROUP BY statuses.id
")->fetchAll(PDO::FETCH_ASSOC);
$mastersCount = $db->query("
    SELECT COUNT(*)
    FROM users
    WHERE role = 'master'
")->fetchColumn();
$latestRepairs = $db->query("
    SELECT
        repair_requests.id,
        statuses.name AS status_name,
        clients.fullname AS client_name

    FROM repair_requests

    LEFT JOIN clients
        ON clients.id = repair_requests.client_id

    LEFT JOIN statuses
        ON statuses.id = repair_requests.status_id

    ORDER BY repair_requests.id DESC

    LIMIT 5
")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="uk">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet">

<link rel="stylesheet"
      href="/pc_service_manager/assets/css/theme.css">
      <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard</title>

    
</head>

<body>

<?php require_once 'templates/navbar.php'; ?>

<div class="container mt-4">

    <h1>Головна панель</h1>

    <p>
        Користувач:
        <strong><?= $_SESSION['fullname']; ?></strong>
    </p>

    <p>
        Роль:
        <strong><?= $_SESSION['role']; ?></strong>
    </p>

    <div class="row mt-4">

        <div class="col-md-3">

    <a href="clients/index.php"
       class="text-decoration-none">

        <div class="card demon-card">

            <div class="card-body">

                <h5>Клієнти</h5>
                <h2><?= $clientsCount ?></h2>

            </div>

        </div>

    </a>

</div>

        <div class="col-md-3">

    <a href="devices/index.php"
       class="text-decoration-none">

        <div class="card demon-card">

            <div class="card-body">

                <h5>Техніка</h5>

                <h2><?= $devicesCount ?></h2>

            </div>

        </div>

    </a>

</div>

        <div class="col-md-3">

    <a href="repairs/index.php"
       class="text-decoration-none">

        <div class="card demon-card">

            <div class="card-body">

                <h5>Ремонти</h5>

                <h2><?= $repairsCount ?></h2>

            </div>

        </div>

    </a>

</div>

        <div class="col-md-3">

    <a href="#"
       class="text-decoration-none">

        <div class="card demon-card">

            <div class="card-body">

                <h5>Майстри</h5>

                <h2><?= $mastersCount ?></h2>

            </div>

        </div>

    </a>

</div>


</div>
<div class="card demon-card mt-4">

    <div class="card-body">

        <h4>Останні заявки</h4>

        <table class="table">

            <thead>

                <tr>
                    <th>ID</th>
                    <th>Клієнт</th>
                    <th>Статус</th>
                </tr>

            </thead>

            <tbody>

            <?php foreach ($latestRepairs as $repair): ?>

                <tr>

                    <td>
                        #<?= $repair['id'] ?>
                    </td>

                    <td>
                        <?= $repair['client_name'] ?>
                    </td>

                    <td>
                        <?= $repair['status_name'] ?>
                    </td>

                </tr>

            <?php endforeach; ?>

            </tbody>

        </table>

    </div>

</div>
<div class="row mt-4">

    <div class="col-md-4">

        <a href="clients/create.php"
           class="text-decoration-none">

            <div class="card demon-card">

                <div class="card-body">

                    <h4> Новий клієнт</h4>

                </div>

            </div>

        </a>

    </div>

    <div class="col-md-4">

        <a href="devices/create.php"
           class="text-decoration-none">

            <div class="card demon-card">

                <div class="card-body">

                    <h4> Нова техніка</h4>

                </div>

            </div>

        </a>

    </div>

    <div class="col-md-4">

        <a href="repairs/create.php"
           class="text-decoration-none">

            <div class="card demon-card">

                <div class="card-body">

                    <h4> Нова заявка</h4>

                </div>

            </div>

        </a>

    </div>

</div>
<div class="card demon-card mt-4">

    <div class="card-body">

        <h3>Статистика заявок</h3>

        <canvas id="repairChart"></canvas>

    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const labels = [
<?php
foreach($chartData as $item){
    echo "'" . $item['name'] . "',";
}
?>
];

const data = [
<?php
foreach($chartData as $item){
    echo $item['total'] . ",";
}
?>
];

new Chart(
    document.getElementById('repairChart'),
    {
        type: 'bar',

        data: {

            labels: labels,

            datasets: [{

                label: 'Кількість заявок',

                data: data,

                backgroundColor: [
                    '#2563eb',
                    '#3b82f6',
                    '#60a5fa',
                    '#1d4ed8',
                    '#1e40af',
                    '#0ea5e9'
                ]

            }]
        }
    }
);

</script>

</body>
</html>