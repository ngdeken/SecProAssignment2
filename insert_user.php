<?php
if(isset($_POST['username'], $_POST['user_email'], $_POST['user_password'])){

    // CHECK IF FIELDS ARE NOT EMPTY
    if(!empty(trim($_POST['username'])) && !empty(trim($_POST['user_email'])) && !empty($_POST['user_password']) && !strlen($_POST["user_password"] < 8)){

        // Escape special characters.
        $username = mysqli_real_escape_string($db_connection, htmlspecialchars($_POST['username']));
        $user_email = mysqli_real_escape_string($db_connection, htmlspecialchars($_POST['user_email']));

        // IF EMAIL IS VALID
        if (filter_var($user_email, FILTER_VALIDATE_EMAIL)) {  

            // CHECK IF EMAIL IS ALREADY REGISTERED
            $stmt = $db_connection->prepare("SELECT `user_email` FROM `users` WHERE user_email = ?");
            $stmt->bind_param("s", $user_email);
            $stmt->execute();
            $result = $stmt->get_result();

            if($result->num_rows > 0){    
                $error_message = "This Email Address is already registered. Please Try another.";
            } else {
                // IF EMAIL IS NOT REGISTERED
                $user_hash_password = password_hash($_POST['user_password'], PASSWORD_DEFAULT);

                // INSERT USER INTO THE DATABASE
                $stmt = $db_connection->prepare("INSERT INTO `users` (username, user_email, user_password) 
                VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $username, $user_email, $user_hash_password);
                $stmt->execute();

                if($stmt->affected_rows === 1){
                    $success_message = "You have successfully signed up.";
                } else {
                    $error_message = "You have failed to sign up.";
                }
            }    
        } else {
            // IF EMAIL IS INVALID
            $error_message = "Invalid email address";
        }
    } else {
        // IF FIELDS ARE EMPTY
        $error_message = "Please fill in all the required fields and password must contain at least 8 or more characters.";
    }
}
?>