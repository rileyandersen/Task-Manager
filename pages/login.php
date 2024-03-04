
<?php
session_start();

include '../server/db_connection.php';
$conn = OpenCon();
$error = false;

if (isset($_POST['email'])) {

    // Clean post fields
    $email = $_POST['email'];
    $email = stripslashes($email);
    $email = mysqli_real_escape_string($conn, $email);

    $password = $_POST['password'];
    $password = stripslashes($password);
    $password = mysqli_real_escape_string($conn, $password);

    // create query
    $query = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";

    // fetch query
    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
    $rows = mysqli_num_rows($result);
    $row = mysqli_fetch_assoc($result);
    // close the connection
    CloseCon($conn);
    // redirect if user is found
    if ($rows == 1) {
        // set the session
        $_SESSION['email'] = $email;
        $_SESSION['user_id'] = $row['user_id'];

        header('Location: tasks.php');
    } // output error is user not found
    else {
        $error = true;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel='stylesheet' href='../styles/main/styles.css'>
        <script src='../scripts/login.js' defer></script>
        <title>Login page</title>
    </head>
    <body>
        <main>
            <?php
            include("../components/header.php");
            ?>
            <form method='post' action='login.php' onsubmit='return validateForm()' class='input-form'>
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

                <div class="mar-bottom-32">
                    <p>Don't have an account?
                        <b>
                            <a href="signup.php" class='green'>
                                Sign up here
                            </a>
                        </b></p>
                </div>
                <p id="errorMessage" class="error mar-bottom-8">
                    <?php
                    if ($error) {
                        echo "User could not be found. Please try again.";
                    }
                    ?>
                </p>
                <button class="anti-default-white-btn">
                    <h5>LOG IN</h5>
                </button>
            </form>
        </main>

    </body>
</html>