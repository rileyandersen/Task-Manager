<?php
session_start();
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <link rel="stylesheet" href="../styles/main/styles.css">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Logout Page</title>
    </head>
    <body>
        <?php
        include('../components/header.php');
        ?>
        <div class="default-page">
            <?php


            if (isset($_SESSION['email'])) {
                setcookie(session_name(), '', 100);
                session_unset();
                session_destroy();
                $_SESSION = array();
                header("Location: login.php");

            } else {
                echo "
    <h1 class = 'mar-bottom-8'> You are not currently logged in </h1>
    <p>Feel free to click the login page</p>
    ";
            }
            ?>
        </div>
    </body>
</html>
