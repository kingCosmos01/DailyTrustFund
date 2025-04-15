<?php

$userManager = new Users();
$users = $userManager->getUsers();

$activeUsers = $userManager->getActiveUsers();
$totalUsers = $userManager->getTotalUsers();

?>

<div class="userContainer" id="userContainer">
    <div class="wrapper">
        <div class="left">
            <div class="head">
                <h2>Active Users</h2>
            </div>
            <ul class="t-head">
                <li>User</li>
                <li>Status</li>
            </ul>
            <ul class="t-body">
                <?php if (!empty($activeUsers)) { ?>
                    <?php foreach ($activeUsers as $key => $activeUser): ?>
                        <li>
                            <p><?= ucwords($activeUser['first_name']); ?>, <?= ucwords($activeUser['last_name']); ?></p>
                            <span class="status"></span>
                        </li>
                    <?php endforeach; ?>
                <?php } else { ?>
                    <li class="info">No User is Active Now</li>
                <?php } ?>
            </ul>
        </div>
        <div class="right">
            <div class="head">
                <h2>
                    All Users
                    <?php if (!empty($totalUsers)) { ?>
                        <?php echo "(" . $totalUsers . ")"; ?>
                    <?php } else {
                        echo "(0)";
                    } ?>
                </h2>
            </div>
            <ul class="t-body">
                <?php if (!empty($users)) { ?>
                    <?php foreach ($users as $key => $user): ?>
                        <li>
                            <p><a href="?view=users&id=<?php echo $user['user_id']; ?>"><?= $user['first_name']; ?>, <?= $user['last_name']; ?> </a></p>
                            <span>...</span>
                        </li>
                    <?php endforeach; ?>
                <?php } else { ?>
                    <li class="info">There are no Users Registered on the Platform Yet!</li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>