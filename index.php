<?php

require "./App/bootstrap.php";


if (isset($_GET['save'])) {
    $saveOBJ = new save;
}




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="./Public/css/main.css">

    <title><?= APPNAME; ?></title>
</head>

<body>

    <div class="hero">
        <h2>
            It's Never Too Late To Start Saving Anytime!
            <br><br>
            <button class="cta"><a href="http://localhost/DailyTrustFund/public/register.php">Try Saving a Kobo Today</a></button>
        </h2>
        <div class="img-box">
            <img src="./Public/images/leo-1.png" alt="leo-1">
        </div>
    </div>

    <?php include_once './Public/Components/navbar.php'; ?>


</body>

</html>