<?php
session_start();
require 'db_connection.php';

// Check if user is logged in
if(!isset($_SESSION['user_email']) || empty($_SESSION['user_email'])){
    header('Location: logout.php');
    exit;
}

// Retrieve user data from the database
$user_email = $_SESSION['user_email'];
$stmt = $db_connection->prepare("SELECT * FROM `users` WHERE user_email = ?");
$stmt->bind_param("s", $user_email);
$stmt->execute();
$result = $stmt->get_result();
$userData = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/fontawesome.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/regular.css" rel="stylesheet">
    <title>Home</title>
</head>
<body>
    <nav class="navbar  fixed-top navbar-light bg-success">
        <span class="navbar-brand mb-0 h1">Hello, <?php echo $userData['username'];?>!</span>
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link text-white"  href="logout.php">Logout</a>
            </li>
        </ul>
    </nav>
    

</body>
</html>