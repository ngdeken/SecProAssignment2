<?php
ini_set('session.cookie_httponly', 1);
ini_set('session.gc_maxlifetime', 3600);
session_set_cookie_params(3600);
session_start();
require 'db_connection.php';
require 'login.php';
// IF USER LOGGED IN
if(isset($_SESSION['user_email'])){
header('Location: home.php');
exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css" media="all" type="text/css">
</head>

<body>

    <form action="" method="post">
        <h2>Assignment 1 Login by Ng De Ken A20EC0106</h2>

        <div class="container">
            <label for="email"><b>Email</b></label>
            <input type="email" placeholder="Enter email" id="email" name="user_email" required>

            <label for="password"><b>Password</b></label>
            <input type="password" placeholder="Enter password" id="password" name="user_password" required>

            <button type="submit">Login</button>
            <small class="link">
                <a href="forgotpwd.php" style="text-decoration: none;
    cursor: pointer;">Forgot password?</a>
            </small>
        </div>
        <?php
if(isset($success_message)){
echo '<div class="success_message">'.$success_message.'</div>'; 
}
if(isset($error_message)){
echo '<div class="error_message">'.$error_message.'</div>'; 
}
?>
        <div class="container" style="background-color: black">
            <a href="signup.php"><button type="button" class="Regbtn" style="border-radius: 25px;">Create an account</button></a>
        </div>
    </form>
</body>

</html>