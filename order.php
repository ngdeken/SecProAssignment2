<?php
require 'db_connection.php';

// Query to fetch item prices
$sql = "SELECT id, price FROM menu";
$result = $db_connection->query($sql);
$user_id = $_POST['user_id'];
$_SESSION['user_id'] = $user_id;

$itemPrices = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $itemPrices[$row['id']] = $row['price'];
    }
}

// Retrieve order data from home.php

    
    
    $address = $_POST['address'];
	$contact = $_POST['contact'];
	$menu = $_POST['menu'];
    $quantity = $_POST['quantity'];
    $total = 0;
        
    // Calculate the total price for each item
    $query = "SELECT price FROM `menu` WHERE id=".$menu;
	$query_run = mysqli_query($db_connection,$query);
    while($menu_item = mysqli_fetch_assoc($query_run))
	{
		$price = $menu_item['price'];
		$total = $total + ((int)$menu_item['price'] * (int)$quantity);
	}
    
    echo "Your order total: RM".$total."<br>";
        // Add the item total to the overall order total
    date_default_timezone_set('Asia/Kuala_Lumpur');
    $time = date("d/m/Y h:i:sa");
    

     
    $query = "INSERT INTO `orders` (user_id, order_list, order_quantity, order_total, address, contact, order_time) VALUES (".$_SESSION['user_id'].", '".$menu."', ".$quantity.", ".$total.", '".mysqli_real_escape_string($db_connection, $address)."', '".$contact."', '".$time."')";
    mysqli_query($db_connection, $query);

    echo "Order placed successfully!";
  

?>

<!DOCTYPE html>
<html lang="">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css" media="all" type="text/css">
    <title>Order</title>
</head>
<body>
    <button id="myBtn">Click this to redirect to home page.</button>
        <script>
        var btn = document.getElementById('myBtn');
        btn.addEventListener('click', function() {
            document.location.href = 'index.php';
        });
        </script>
</body>
</html>