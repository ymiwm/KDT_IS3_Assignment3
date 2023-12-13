<p style='text-align:right'>            
    <?php
    if (isset($_SESSION) === false){
        session_start();
    }

    if (isset($_SESSION['id']) === false){
        ?>
        <a href="register.php">Create Account</a>
        <a href="login.php">Sign In</a>
        <?php
    }
    else{
        ?>
        <a href="logout.php">Sign Out</a>
        <?php
    }
    ?>
</p>
