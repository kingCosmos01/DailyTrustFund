<div class="navbar" id="navbar">
    <div class="wrapper">
        <div class="left">
            <a href="<?= URLROOT; ?>">
                <h2><?= APPNAME; ?></h2>
            </a>
        </div>
        <div class="right">
            <ul>
                <li><a href="?save">Save Now</a></li>
                <?php if (!isset($_SESSION['current_user_id'])): ?>
                    <li><a href="<?= PUBLICROOT; ?>login.php">Login</a></li>
                    <li><a href="<?= PUBLICROOT; ?>register.php">Sign Up</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>