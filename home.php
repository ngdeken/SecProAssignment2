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
    <link rel="stylesheet" href="style.css" media="all" type="text/css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/fontawesome.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/regular.css" rel="stylesheet"
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
    <div class="container">
        <h2>Order Your Pizza</h2>
        <form action="order.php" method="post">
            <label for="menu">Menu:</label>
            <select name="menu" id="menu">
                <option value="1">Hawaii Chicken RM30</option>
                <option value="2">Chicken Pepperoni RM25</option>
                <option value="3">Deluxe Cheese RM20</option>
            </select><br>
			<label for="user_id">User ID:</label>
			<input type="text" name="user_id" id="user_id" value="<?php echo $userData['user_id']; ?>"><br>
            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" id="quantity" min="1" value="1"><br>

			<label for="contact">Contact number:</label>
            <input type="number" name="contact" id="contact"><br>

            <label for="address">Delivery Address:</label>
            <textarea name="address" id="address" rows="3"></textarea><br>

            <button type="submit">Place Order</button>
        </form>
    </div>

	<script>
        var orderCount = 1;

        function addOrder() {
            orderCount++;
            var ordersDiv = document.getElementById('orders');

            var newOrder = document.createElement('div');
            newOrder.className = 'order';
            newOrder.innerHTML = '<h3>Order ' + orderCount + '</h3>' +
                '<label for="menu_1' + orderCount + '">Pizza Type:</label>' +
                '<select name="menu[]" id="menu_1' + orderCount + '">' +
                '<option value="1">Hawaii Chicken RM30</option>' +
                '<option value="2">Chicken Pepperoni RM25</option>' +
                '<option value="3">Deluxe Cheese RM20</option>' +
                '</select><br>' +
                '<label for="quantity_' + orderCount + '">Quantity:</label>' +
                '<input type="number" name="quantity[]" id="quantity_' + orderCount + '" min="1" value="1"><br>';

            ordersDiv.appendChild(newOrder);
        }
    </script>

</body>
</html>