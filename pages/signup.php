
<?php
session_start();
include '../server/db_connection.php';
$conn = OpenCon();
// check if fields are set
if (isset($_REQUEST['email']) && isset($_REQUEST['password'])) {
    // escape special characters
    $email = stripslashes($_REQUEST['email']);
    $email = mysqli_real_escape_string($conn, $email);
    $password = stripslashes($_REQUEST['password']);
    $password = mysqli_real_escape_string($conn, $_REQUEST['password']);

    $query = "INSERT INTO users (email, password)
    VALUES ('$email', '$password')";
    $result = mysqli_query($conn, $query);// or die(mysqli_error($conn));

    if ($result) {
        $_SESSION['email'] = $email;
        header("Location: tasks.php");
        exit();
    } else {
        echo "<div class = 'popup' onclick='deleteElement(this)'> 
                    <div class='flex justify-end '><h5 class ='cursor black-icon'>x</h5></div>
                <p class='bold'>";
        echo mysqli_error($conn);
        echo "       </p>
        </div>";

    }


}

?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <script src="../scripts/forms.js" defer></script>
        <script src='../scripts/functions.js'></script>
        <link rel="stylesheet" href="../styles/main/styles.css">
        <title>Sign Up Page</title>
    </head>
    <body>
        <?php include('../components/header.php') ?>

        <form method='post' action='signup.php' class='input-form' onsubmit="return validateForm()">
            <div class="input-field">
                <label>
                    <h5>
                        Email Address *
                    </h5>
                    <input class='mar-bottom-8' type="text" name='email' id='email'
                           placeholder='johndoe@gmail.com'>
                </label>
                <p id="email-error" class='error'></p>
            </div>

            <div class="input-field">
                <label>
                    <h5>
                        Password *
                    </h5>
                    <input class='mar-bottom-8' type="password" id='password' name='password'
                           placeholder="password">
                </label>
                <p id="password-error" class='error'></p>
            </div>

            <div class="input-field">
                <label>
                    <h5>
                        Password Confirm*
                    </h5>
                    <input class='mar-bottom-8' type="password" id='passwordConfirm'
                           name='passwordConfirm'
                           placeholder="confirm password">
                </label>
                <p id="confirm-password-error" class='error'></p>
            </div>

            <div class="mar-bottom-32">
                <p>Already have an account?
                    <b>
                        <a href="login.php" class='green'>
                            Log in here
                        </a>
                    </b></p>
            </div>
            <button type='submit' class="anti-default-white-btn" onclick="validateForm()">
                <h5>SIGN UP</h5>
            </button>
        </form>

    </body>
</html>