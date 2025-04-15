<?php

require '../../App/bootstrap.php';

if (isset($_GET['view'])) {
    $view = $_GET['view'];

    new ViewManager($view);
}

$transactionManager = new Transactions;
$totalSavingsByUsers = $transactionManager->totalSavingsByUsers();

$totalWithdrawalsByUsers = $transactionManager->totalWithdrawalsByUsers();

$userManager = new Users();
$users = $userManager->getUsers();
$totalUsers = $userManager->getTotalUsers();

$totalSavingsByUsers = $totalSavingsByUsers[0]['total'];
$totalWithdrawalsByUsers = $totalWithdrawalsByUsers[0]['total'];

$income = $transactionManager->getTotalIncome();
$income = $income[0]['total'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= APPNAME; ?> - Admin Dashboard</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>

<body>

    <div class="navbar">
        <div class="left">
            <a href="">Admin Dashboard</a>
        </div>
        <div class="right">
            <ul>
                <li><a href="">Call to Action</a></li>
                <li><a href="?logout">Logout</a></li>
            </ul>
        </div>
    </div>

    <div class="sidebar">
        <div class="wrapper">
            <ul class="links" id="navLinks">
                <li><a href="<?= ADMIN; ?>dashboard.php">Dashboard</a></li>
                <li><a href="?view=transactions">Transactions</a></li>
                <!-- <li><a href="">Exceptions</a></li> -->
                <li><a href="?view=users">Users</a></li>
            </ul>
        </div>
    </div>

    <div class="cards">
        <ul>
            <li>
                <a href="?view=users">
                    <h3>Users</h3>
                    <h2><?= $totalUsers; ?></h2>
                </a>
            </li>
            <li>
                <a href="?view=savings">
                    <h3>Total Savings</h3>
                    <h2>
                        <?php if (!empty($totalSavingsByUsers)) { ?>
                            NGN <?php echo number_format($totalSavingsByUsers, 2); ?>
                        <?php } else {
                            echo "NGN 0.00";
                        } ?>
                    </h2>
                </a>
            </li>
            <li>
                <a href="?view=withdrawal">
                    <h3>Total Withdrawal</h3>
                    <h2>
                        <?php if (!empty($totalWithdrawalsByUsers)) { ?>
                            NGN <?= number_format($totalWithdrawalsByUsers, 2); ?>
                        <?php } else {
                            echo "NGN 0.00";
                        } ?>
                    </h2>
                </a>
            </li>
            <li>
                <a href="?view=income">
                    <h3>Income</h3>
                    <h2>
                        <?php if (!empty($income)) { ?>
                            NGN <?= $income; ?>
                        <?php } else {
                            echo "NGN 0.00";
                        } ?>

                    </h2>
                </a>
            </li>
        </ul>
    </div>

    <script src="../js/main.js"></script>

</body>

</html>