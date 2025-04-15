<?php

require '../App/bootstrap.php';

if (isset($_SESSION['userID'])) {
    header("Location: dashboard.php");
    exit;
}

if (isset($_POST['dtf_login'])) {

    $email = htmlentities($_POST['email']);
    $password = htmlentities($_POST['password']);

    $userLoginOBJ = new Login($email, $password);
}




?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="./css/main.css">

    <title><?= APPNAME; ?> - Login </title>
</head>

<body>

    <?php include './Components/navbar.php'; ?>

    <div class="login-container">
        <div class="wrapper">
            <div class="head">
                <h2>Login to Dashboard</h2>
            </div>
            <hr>

            <?php if (isset($userLoginOBJ->error)) { ?>
                <div class="err" id="err"><?= $userLoginOBJ->error['err']; ?></div>
            <?php } ?>

            <form action="" method="post">
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" id="email" placeholder="Someone@mail.com" required />
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" id="password" placeholder="Enter Password" required />
                </div>
                <div class="cta">
                    <button type="submit" name="dtf_login">Login</button>
                    <p><a href="">Forgotten Password?</a></p>
                </div>
            </form>
        </div>
    </div>


    <?php include './Components/footer.php'; ?>

</body>

</html>