<?php
session_start();
require_once("dbcontroller.php");
$db_handle = new DBController();
?>

<!DOCTYPE html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script><!-- jQuery library -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 

<TITLE>PHP Shopping Cart</TITLE>
<link href="style.css" type="text/css" rel="stylesheet" />
</head>
<body>
<header>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="index.php">Shopping Cart</a>
            </div>
        
            <ul class="nav navbar-nav">
                <li><a href="index.php">VAT 0%</a></li>
                <li><a href="vat6.php">VAT 6%</a></li>
                <li><a href="vat21.php">VAT 21%</a></li>
            </ul>
            
            <ul class="nav navbar-nav navbar-right">
                <li><a href="viewCart.php" title="View Cart"><i class="glyphicon glyphicon-shopping-cart"></i></a></li>
            </ul>
        </div>
    </nav>
</header>

<?php
// insert order details into database
$orderID = $db_handle->runMultiQuery(
    "INSERT INTO orders (customer_id, total_price, created, modified) 
    VALUES ('".$_SESSION['sessCustomerID']."', '".$_SESSION['item_total']."',
        '".date("Y-m-d H:i:s")."', '".date("Y-m-d H:i:s")."')");

if($orderID){
    $sql = '';
    // get cart items
    if(isset($_SESSION["vat0_cart_item"])){
        foreach ($_SESSION["vat0_cart_item"] as $item){
            $sql .= "INSERT INTO order_items (order_id, product_code, quantity) 
            VALUES ('".$orderID."', '".$item['code']."', '".$item['quantity']."');";
        }
    }
    if(isset($_SESSION["vat6_cart_item"])){
        foreach ($_SESSION["vat6_cart_item"] as $item){
            $sql .= "INSERT INTO order_items (order_id, product_code, quantity) 
            VALUES ('".$orderID."', '".$item['code']."', '".$item['quantity']."');";
        }
    }
    if(isset($_SESSION["vat21_cart_item"])){
        foreach ($_SESSION["vat21_cart_item"] as $item){
            $sql .= "INSERT INTO order_items (order_id, product_code, quantity) 
            VALUES ('".$orderID."', '".$item['code']."', '".$item['quantity']."');";
        }
    }
    // insert order items into database

    $insertOrderItems = $db_handle->runMultiQuery($sql);

    if($insertOrderItems){
        session_destroy();
    }
?>

<div class="container-fluid">
    <h1>Order Status</h1>
<?php

if($insertOrderItems){
?>
    <p>Your order has been submitted successfully. Order ID is #<?php echo $orderID; ?>.</p>
<?php
}
else{
?>    
    <p>Your order has NOT been successfully submitted. Would you please try again?</p>
<?php
}
?>
</div>
</body>
</html>
<?php
}
?>