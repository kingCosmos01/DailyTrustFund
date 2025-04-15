<?php

$savingsManager = new Transactions();
$savingsTransactions = $savingsManager->selectAllSavingsTransactions();


?>

<div class="savingsContainer">
    <div class="x-wrapper">
        <div class="head">
            <h2>Savings Transactions</h2>
        </div>

        <div class="t-head-row">
            <ul class="t-head">
                <li>S/No.</li>
                <li>Transaction ID</li>
                <li>User ID</li>
                <li>Amount</li>
                <li>Type</li>
                <li>Date</li>
                <li>Status</li>
            </ul>
        </div>
        <div class="t-body-row">
            <?php if (!empty($savingsTransactions)) { ?>
                <?php foreach ($savingsTransactions as $key => $transaction): ?>
                    <ul class="t-body">
                        <li><?= ++$key; ?></li>
                        <li>#<?= $transaction['trans_id']; ?></li>
                        <li>#<?= $transaction['user_id']; ?></li>
                        <li><?= number_format($transaction['trans_amount'], 2); ?></li>
                        <li><?= $transaction['trans_type']; ?></li>
                        <li><?= $transaction['trans_date']; ?></li>
                        <li class="status">complete</li>
                    </ul>
                <?php endforeach; ?>
            <?php } ?>
        </div>
    </div>
</div>