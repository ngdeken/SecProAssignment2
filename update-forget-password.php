<?php
if(isset($_POST['passwordreset'], $_POST['reset_link_token'], $_POST['user_email']))
{
    require 'db_connection.php';
    $emailId = $_POST['user_email'];
    $token = $_POST['reset_link_token'];
    $password = $_POST['passwordreset'];
  
    $hashedpassword = password_hash($password, PASSWORD_DEFAULT);

    $loginpage = 'http://localhost/spasg1/index.php';
    $reset = 'http://localhost/spasg1/reset-password.php';

    $stmt = $db_connection->prepare("SELECT * FROM `users` WHERE `reset_link_token`=? AND `user_email`=?");
    $stmt->bind_param("ss", $token, $emailId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->num_rows;

    $exp = "0000-00-00";
    if($row){
        // Prepare SQL statement with parameterized query
        $stmt = $db_connection->prepare("UPDATE `users` SET `user_password`=?, `reset_link_token`=NULL, `exp_date`=? WHERE `user_email`=?");
        // Bind parameters
        $stmt->bind_param("sss", $hashedpassword, $exp, $emailId);
        // Execute the statement
        $stmt->execute();
        echo "<p style='text-align: center; color:green;'>Your password is updated.<a href='$loginpage'>Login</a></p>";
    }else{
        echo "<h1 style='text-align: center; color:red; height: 100%; width: 100%; display: flex; position: fixed; align-items: center; justify-content: center;'><a href='$reset' style='color:red;'>Please try again.</a></h1>";
    }
}

