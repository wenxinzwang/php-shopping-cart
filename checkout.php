<?php
session_start();
require_once("dbcontroller.php");
$db_handle = new DBController();

// set customer ID in session
$_SESSION['sessCustomerID'] = 1;

$customer = $db_handle->runQuery("SELECT * FROM customers WHERE id='".$_SESSION['sessCustomerID'] . "'");
?>
<!DOCTYPE html>
<head>
<title>PHP Shopping Cart</title>
<meta charset="utf-8">
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>    
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
<div class="container-fluid">
<h1>Order Preview</h1>
<table class="table table-condensed">
<tbody>
<?php
    if(isset($_SESSION['item_total'])){
?>
<tr>
<th style="text-align:left;"><strong>Name</strong></th>
<th style="text-align:left;"><strong>Code</strong></th>
<th style="text-align:right;"><strong>Quantity</strong></th>
<th style="text-align:right;"><strong>Price</strong></th>
<th style="text-align:right;"><strong>Incl. VAT</strong></th>
</tr>	
<?php		
if(isset($_SESSION["vat0_cart_item"])){
    foreach ($_SESSION["vat0_cart_item"] as $item){
?>
<tr>
<td style="text-align:left;border-bottom:#F0F0F0 1px solid;"><strong><?php echo $item["name"]; ?></strong></td>
<td style="text-align:left;border-bottom:#F0F0F0 1px solid;"><?php echo $item["code"]; ?></td>
<td style="text-align:right;border-bottom:#F0F0F0 1px solid;"><?php echo $item["quantity"]; ?></td>
<td style="text-align:right;border-bottom:#F0F0F0 1px solid;"><?php echo "EUR ".$item["price"]; ?></td>
<td style="text-align:right;border-bottom:#F0F0F0 1px solid;">0%</td>
<?php
    }
}		
if(isset($_SESSION["vat6_cart_item"])){
    foreach ($_SESSION["vat6_cart_item"] as $item){
?>
<tr>
<td style="text-align:left;border-bottom:#F0F0F0 1px solid;"><strong><?php echo $item["name"]; ?></strong></td>
<td style="text-align:left;border-bottom:#F0F0F0 1px solid;"><?php echo $item["code"]; ?></td>
<td style="text-align:right;border-bottom:#F0F0F0 1px solid;"><?php echo $item["quantity"]; ?></td>
<td style="text-align:right;border-bottom:#F0F0F0 1px solid;"><?php echo "EUR ".$item["price"]; ?></td>
<td style="text-align:right;border-bottom:#F0F0F0 1px solid;">6%</td>
</tr>
<?php
    }
}		
if(isset($_SESSION["vat21_cart_item"])){
    foreach ($_SESSION["vat21_cart_item"] as $item){
?>
<tr>
<td style="text-align:left;border-bottom:#F0F0F0 1px solid;"><strong><?php echo $item["name"]; ?></strong></td>
<td style="text-align:left;border-bottom:#F0F0F0 1px solid;"><?php echo $item["code"]; ?></td>
<td style="text-align:right;border-bottom:#F0F0F0 1px solid;"><?php echo $item["quantity"]; ?></td>
<td style="text-align:right;border-bottom:#F0F0F0 1px solid;"><?php echo "EUR ".$item["price"]; ?></td>
<td style="text-align:right;border-bottom:#F0F0F0 1px solid;">21%</td>
</tr>
<tr><td colspan="5" align=right><strong>Total: <?php echo "EUR ".$_SESSION["item_total"]; ?></strong></td></tr>
<?php
    }
}
}
else{
?>
<tr><td colspan="5">No items in your cart......</td></tr>
<?php
}
?>
</tbody>
</table>
<div>
    <h4>Shipping Details</h4>
    <p><?php echo $customer[0]['name']; ?></p>
    <p><?php echo $customer[0]['email']; ?></p>
    <p><?php echo $customer[0]['phone']; ?></p>
    <p><?php echo $customer[0]['address']; ?></p>
</div>
<div>
    <a href="javascript:history.go(-2)" class="btn btn-warning"><i class="glyphicon glyphicon-menu-left"></i> Continue Shopping</a>
    <a href="orderSuccess.php?action=placeOrder" class="btn btn-success orderBtn text-right">Place Order <i class="glyphicon glyphicon-menu-right"></i></a>
</div>
</div>
</body>
</html>