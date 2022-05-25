<?php
    session_start();
?>
<!DOCTYPE HTML>  
<html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Home</title>
            </head>
</html>
<?php
    if (!isset($_SESSION['luser'])) {
        echo "Please Login or Register";
        echo "<br>";
        echo "<a href='login.php'> Click Here to Login </a>";
        echo "<br>";
        echo "<a href='Register.php'> Click Here to Register / Add Users </a>";
    }
    else {
        $now = time(); // Checking the time now when home page starts.

        if ($now > $_SESSION['expire']) {
            session_destroy();
            echo "Your session has expired!";
            echo "<br>"; 
            echo "<a href='login.php'> Login here </a>";
        }
        else { //Starting this else one [else1]
?>
                Welcome
                <?php
                    echo $_SESSION['luser'];
                    echo "<br>";
                    echo "<a href='logout.php'> Log out </a>";
                ?>
<?php
        }
    }
?>
