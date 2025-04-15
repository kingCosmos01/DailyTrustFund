<?php

require '../App/bootstrap.php';
// require 'save_transaction.php';

error_reporting(E_ALL);

ini_set('display_errors', 1);

if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['userID']);
}


?>

<?php

// if user is not registered, redirect to signup page
if (!isset($_SESSION['userID'])) {
    header("location: ./login.php");
    exit;
}

$TransactionsOBJ  = new Transactions;
$transactions = $TransactionsOBJ->getAllTransactions();

$user = $_SESSION['userID']; //current user that is logged in

$BalanceManager = new BalanceManager;
$data = $BalanceManager->getAccountBalance($user);

$totalSavings = $data[0]['total'];

if ($totalSavings != null) {
    $totalSavings = number_format($totalSavings, 2);
} else {
    $totalSavings = 0;
    $totalSavings = number_format($totalSavings, 2);
}


if (isset($_POST['make_deposit'])) {
    $amount = htmlentities($_POST['amount']);
    $transaction_type = "savings";
    $user_id = $_SESSION['userID'];
    $reference = empty($_POST['reference']) ? uniqid() : $_SESSION['userID'];

    $TransactionsOBJ->makeDeposit($reference, $user_id, $amount, $transaction_type);

    header("location: http://localhost/DailyTrustFund/public/dashboard.php?msg=" . urlencode("Deposit Successful!"));
    exit;
}


if (isset($_POST['make_withdrawal'])) {
    $amount = htmlentities($_POST['w_amount']);
    $password = htmlentities($_POST['w_password']);
    $user = $_SESSION['userID'];

    $ref = uniqid();
    $type = "withdrawal";

    var_dump($amount, $password, $user);

    if ($TransactionsOBJ->makeWithdrawal($amount, $user, $ref, $type, $password) == true) {
        $msg = "Withdrawal Successful!";
        header("Location: http://localhost/dailytrustfund/public/dashboard.php?msg=" . urlencode($msg));
        exit;
    } else {
        $msg = "Wrong Credentials!";
        header("Location: http://localhost/dailytrustfund/public/dashboard.php?msg=" . urlencode($msg));
        exit;
    }
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> <?= APPNAME; ?> - Dashboard</title>
    <link rel="stylesheet" href="../Public/css/dashboard.css">
    <script src="https://js.paystack.co/v1/inline.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
</head>

<body>

    <div class="navbar">
        <div class="left">
            <h2>
                <a href="<?= URLROOT; ?>"><?= APPNAME; ?></a>
            </h2>
        </div>
        <div class="right">
            <ul>
                <li><a href="?balance"><i class="fa-solid fa-wallet"></i> NGN <?= $totalSavings; ?></a></li>
                <li id="gear"><a><i class="fa-solid fa-user"></i> Hi, <?= $_SESSION['first_name']; ?>, <?= $_SESSION['last_name']; ?> </a></li>
                <li><a href="?profile">
                        <img src="../Public/images/leo-4.jpg" alt="">
                    </a></li>
            </ul>
        </div>
    </div>

    <div class="popUp" id="popUp">
        <div class="wrapper">
            <div class="row">
                <h2>Notification</h2>
                <div class="n-close-btn" id="nCloseBtn">&times;</div>
            </div>
            <p class="text">
                2% Fee Applied to all Transactions (Deposits/Withdrawals)
            </p>
        </div>
    </div>

    <ul class="gearBox" id="gearBox">
        <li><a href="?profile">Profile</a></li>
        <li><a href="?logout">Logout</a></li>
    </ul>

    <?php if (isset($_GET['msg'])): ?>
        <div class="alert" id="alertModal"><?= $_GET['msg']; ?></div>
    <?php endif; ?>

    <?php if (count($TransactionsOBJ->error) > 0): ?>
        <div class="alert" id="alertModal"><?= $TransactionsOBJ->error['msg']; ?></div>
    <?php endif; ?>

    <div class="fin-cards">
        <a onclick="openAmountModal()" class="card">
            <h2>Deposit</h2>
        </a>

        <a href="" class="card">
            <h2><i class="fa-solid fa-wallet"></i> NGN <?= $totalSavings; ?></h2>
        </a>

        <a class="card" id="withdrawBtn">
            <h2><i class="fa-solid fa-money-bill-transfer"></i>Withdraw</h2>
        </a>
    </div>

    <div class="amountModal" id="amountModal">
        <div class="wrapper">
            <h2>Enter Amount</h2>
            <form action="" id="paymentForm" method="post">
                <input type="number" name="amount" id="amountInput" placeholder="NGN 200" value="" />
                <input type="email" name="email" id="email" placeholder="someone@mail.com">
                <div class="cta-group">
                    <button type="submit" name="make_deposit">Continue to Save</button>
                    <button onclick="closeAmountModal()" class="cancelBtn">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <div class="withdrawContainer" id="withdrawContainer">
        <div class="wrapper">
            <h2>Enter Withdrawal Amount</h2>
            <form action="" id="paymentForm_" method="post">
                <input type="number" name="w_amount" id="amountInput_" placeholder="NGN 200" required />
                <input type="text" name="w_account_name" id="" placeholder="Enter Account Name" required />
                <input type="number" name="w_account_no" id="" placeholder="Enter Account Number" required />
                <input type="password" name="w_password" id="password_" placeholder="Enter Password" required />
                <div class="cta-group">
                    <button type="submit" name="make_withdrawal">Withdraw</button>
                    <button onclick="closeWithdrawalModal()" class="cancelBtn">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <div class="recents" id="recents">
        <h2>Recent Transactions</h2>

        <ul class="head-row">
            <li>Trans ID</li>
            <li>Type</li>
            <li>Amount</li>
            <li>Date</li>
            <li></li>
        </ul>
        <hr>

        <!-- trans_list -->

        <?php if (empty($transactions)) { ?>
            <ul class="trans_list">
                <p>You have no Transaction History, <b><?= $_SESSION['first_name'] . " " . $_SESSION['last_name']; ?></b> <a href="#">Try Saving a Kobo Today</a></p>
            </ul>
        <?php } else { ?>
            <?php foreach ($transactions as $key => $data): ?>
                <ul class="trans_list">
                    <li><?= $data['trans_id']; ?></li>
                    <li><?= $data['trans_type']; ?></li>
                    <li><?= $data['trans_amount']; ?></li>
                    <li><?= $data['trans_date']; ?></li>
                    <li class="expand" id="expand"><b>...</b></li>
                </ul>
            <?php endforeach; ?>
        <?php } ?>
    </div>



    <!-- 
    <div class="spinner" id="spinner">
        <span class="loader">Loading...</span>
    </div> -->




    <div class="cta bottom">
        <ul>
            <li><a href=""><i class="fa-solid fa-house"></i> Home</a></li>
            <li><a href="#"><i class="fa-solid fa-wallet"></i> Finance</a></li>
            <li><a href="#"><i class="fa-solid fa-compass"></i> Summary</a></li>
        </ul>
    </div>

    <script src="./js/paystack.js"></script>
    <script src="./js/main.js"></script>

</body>

</html>