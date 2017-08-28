<?php
require_once("dbcontroller.php");
$db_handle = new DBController();
?>
<!DOCTYPE html>
<HEAD>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script><!-- jQuery library -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 

<TITLE>PHP Shopping Cart</TITLE>
<link href="style.css" type="text/css" rel="stylesheet" />
</HEAD>
<BODY>
<header>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<a class="navbar-brand" href="#">Shopping Cart</a>
			</div>
		
			<ul class="nav navbar-nav">
				<li class="active"><a href="#">VAT 0%</a></li>
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
	<h1>Products</h1>
	<?php
	$product_array = $db_handle->runQuery("SELECT * FROM product ORDER BY id ASC");
	if (!empty($product_array)) { 
		foreach($product_array as $key=>$value){
	?>
		<div class="product-item">
			<form method="post" action="viewCart.php?action=add&vat=vat0&code=<?php echo $product_array[$key]["code"]; ?>">
			<div class="product-image"><img src="<?php echo $product_array[$key]["image"]; ?>"></div>
			<div><strong><?php echo $product_array[$key]["name"]; ?></strong></div>
			<div class="product-price"><?php echo "EUR ".$product_array[$key]["price"]; ?></div>
			<div><input type="text" name="quantity" value="1" size="2" /><input type="submit" value="Add to cart" class="btnAddAction" /></div>
			</form>
		</div>
	<?php
		}
	}
	?>
</div>
</BODY>
</HTML>