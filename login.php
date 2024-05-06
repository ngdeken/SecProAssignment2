<?php
if(isset($_POST['user_email'], $_POST['user_password'])){

    $user_email = trim($_POST['user_email']);
    $user_password = trim($_POST['user_password']);

        // Validate email format
        if(filter_var($user_email, FILTER_VALIDATE_EMAIL)){

            // Validate password length
            if(strlen($user_password) >= 8){
    
                // Sanitize email input
                $user_email = htmlspecialchars($user_email);
    
                // Prepare SQL statement with parameterized query
                $stmt = $db_connection->prepare("SELECT * FROM `users` WHERE user_email = ?");
                
                // Bind parameters
                $stmt->bind_param("s", $user_email);
                
                // Execute the statement
                $stmt->execute();
                
                // Get the result set
                $result = $stmt->get_result();
    
                if($result->num_rows > 0){
    
                    // Fetch the result as an associative array
                    $row = $result->fetch_assoc();
                    $user_db_pass = $row['user_password'];
    
                    if(password_verify($user_password, $user_db_pass)){
    
                        session_regenerate_id(true);
                        $_SESSION['user_email'] = $user_email;  
                        header('Location: home.php');
                        exit;
    
                    }
                    else{
                        $error_message = "Incorrect Email Address or Password.";
                    }
    
                }
                else{
                    $error_message = "Incorrect Email Address or Password.";
                }
    
            }
            else{
                $error_message = "Password must be at least 8 characters long.";
            }
    
        }
        else{
            $error_message = "Invalid email address format.";
        }
    
    }
    ?>