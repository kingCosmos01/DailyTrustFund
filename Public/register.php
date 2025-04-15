<?php require_once '../App/bootstrap.php'; ?>


<?php

if (isset($_SESSION['userID'])) {
    header("location: ./dashboard.php");
    exit;
}

?>


<?php

if (isset($_POST['create_account'])) {

    $data = [
        'first_name' => htmlentities($_POST['first_name']),
        'last_name' => htmlentities($_POST['last_name']),
        'email' => htmlentities($_POST['email']),
        'password' => htmlentities($_POST['password']),
        'confirm_password' => htmlentities($_POST['confirm_password'])
    ];

    $RegisterOBJ = new Register($data);
    header("location: ./register.php");
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="./css/main.css">

    <title><?= APPNAME; ?> - Sign Up </title>
</head>

<body>

    <?php include './Components/navbar.php'; ?>

    <div class="login-container signup">
        <div class="wrapper">
            <div class="head">
                <h2>Create Account</h2>
            </div>
            <hr>

            <?php if (isset($_SESSION['userID'])): ?>
                <?= $_SESSION['userID']; ?> <br>
                <?= $_SESSION['email']; ?>
            <?php endif; ?>

            <form action="" method="post">
                <div class="form-group">
                    <label>First Name</label>
                    <input type="text" name="first_name" placeholder="John" required />
                </div>
                <div class="form-group">
                    <label>Last Name</label>
                    <input type="text" name="last_name" placeholder="Doe" required />
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" id="email" placeholder="Someone@mail.com" required />
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" id="password" placeholder="Enter Password" required />
                </div>
                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" name="confirm_password" placeholder="Confirmm Password" required />
                </div>
                <div class="cta">
                    <button type="submit" name="create_account">Sign Up</button>
                </div>
            </form>
        </div>
    </div>


    <?php include './Components/footer.php'; ?>

</body>

</html>