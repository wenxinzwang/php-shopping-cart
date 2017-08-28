<?php
session_start();
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
                <a class="navbar-brand" href="index.php">Shopping Cart</a>
            </div>
        
            <ul class="nav navbar-nav">
                <li><a href="index.php">VAT 0%</a></li>
                <li><a href="vat6.php">VAT 6%</a></li>
                <li><a href="vat21.php">VAT 21%</a></li>
            </ul>
            
            <ul class="nav navbar-nav navbar-right">
                <li class="active"><a href="#" title="View Cart"><i class="glyphicon glyphicon-shopping-cart"></i></a></li>
            </ul>
        </div>
    </nav>
</header>
<?php    
if(!empty($_GET["vat"])){
    $vat = substr($_GET["vat"], 3);

    if(!empty($_GET["action"]) && $_GET["action"] == "add") {
        if(!empty($_POST["quantity"])) {
            $productByCode = $db_handle->runQuery("SELECT * FROM product WHERE code='" . $_GET["code"] . "'");
            $itemArray = array($productByCode[0]["code"]=>array('name'=>$productByCode[0]["name"], 
            'code'=>$productByCode[0]["code"], 'quantity'=>$_POST["quantity"], 
            'price'=>$productByCode[0]["price"] * (1 + $vat / 100)));

            switch($vat){
            case 0:     //add vat 0% item to session               
                if(!empty($_SESSION["vat0_cart_item"])) {
                    if(in_array($productByCode[0]["code"],array_keys($_SESSION["vat0_cart_item"]))) {
                        foreach($_SESSION["vat0_cart_item"] as $k => $v) {
                                if($productByCode[0]["code"] == $k) {
                                    if(empty($_SESSION["vat0_cart_item"][$k]["quantity"])) {
                                        $_SESSION["vat0_cart_item"][$k]["quantity"] = 0;
                                    }
                                    $_SESSION["vat0_cart_item"][$k]["quantity"] += $_POST["quantity"];
                                }
                        }
                    } else {
                        $_SESSION["vat0_cart_item"] = array_merge($_SESSION["vat0_cart_item"],$itemArray);
                    }
                } else {
                    $_SESSION["vat0_cart_item"] = $itemArray;
                }
                break;
            case 6://add vat 6% item to session
                if(!empty($_SESSION["vat6_cart_item"])) {
                    if(in_array($productByCode[0]["code"],array_keys($_SESSION["vat6_cart_item"]))) {
                        foreach($_SESSION["vat6_cart_item"] as $k => $v) {
                                if($productByCode[0]["code"] == $k) {
                                    if(empty($_SESSION["vat6_cart_item"][$k]["quantity"])) {
                                        $_SESSION["vat6_cart_item"][$k]["quantity"] = 0;
                                    }
                                    $_SESSION["vat6_cart_item"][$k]["quantity"] += $_POST["quantity"];
                                }
                        }
                    } else {
                        $_SESSION["vat6_cart_item"] = array_merge($_SESSION["vat6_cart_item"],$itemArray);
                    }
                } else {
                    $_SESSION["vat6_cart_item"] = $itemArray;
                }
                break;
            case 21:    //add vat 21% item to session            
                if(!empty($_SESSION["vat21_cart_item"])) {
                    if(in_array($productByCode[0]["code"],array_keys($_SESSION["vat21_cart_item"]))) {
                        foreach($_SESSION["vat21_cart_item"] as $k => $v) {
                                if($productByCode[0]["code"] == $k) {
                                    if(empty($_SESSION["vat21_cart_item"][$k]["quantity"])) {
                                        $_SESSION["vat21_cart_item"][$k]["quantity"] = 0;
                                    }
                                    $_SESSION["vat21_cart_item"][$k]["quantity"] += $_POST["quantity"];
                                }
                        }
                    } else {
                        $_SESSION["vat21_cart_item"] = array_merge($_SESSION["vat21_cart_item"],$itemArray);
                    }
                } else {
                    $_SESSION["vat21_cart_item"] = $itemArray;
                }           
                break; 
            }
        }
    }
}
?>
<div class="container-fluid">
<h1>Shopping Cart</h1>
<table class="table table-condensed">
<tbody>
<?php
if(isset($_SESSION["vat0_cart_item"]) || isset($_SESSION["vat6_cart_item"]) || isset($_SESSION["vat21_cart_item"])){
    $_SESSION["item_total"] = 0;

    if(isset($_SESSION["vat0_cart_item"])){//show vat 0% item shopping cart
        $vat0_item_total = 0;
?>	
    <tr><th colspan="4" class="txt-heading">VAT 0%</th></tr>
    <tr>
    <th style="text-align:left;"><strong>Name</strong></th>
    <th style="text-align:left;"><strong>Code</strong></th>
    <th style="text-align:right;"><strong>Quantity</strong></th>
    <th style="text-align:right;"><strong>Price</strong></th>
    </tr>	
        <?php		
        foreach ($_SESSION["vat0_cart_item"] as $item){
	    ?>
    <tr>
    <td style="text-align:left;border-bottom:#F0F0F0 1px solid;"><strong><?php echo $item["name"]; ?></strong></td>
    <td style="text-align:left;border-bottom:#F0F0F0 1px solid;"><?php echo $item["code"]; ?></td>
    <td style="text-align:right;border-bottom:#F0F0F0 1px solid;"><?php echo $item["quantity"]; ?></td>
    <td style="text-align:right;border-bottom:#F0F0F0 1px solid;"><?php echo "EUR ".$item["price"]; ?></td>
    </tr>
		<?php
            $vat0_item_total += ($item["price"]*$item["quantity"]);
        }
        $_SESSION["item_total"] += $vat0_item_total;
		?>
    <tr>
    <td colspan="4" align=right><strong>Subtotal:</strong> <?php echo "EUR ".$vat0_item_total; ?></td>
    </tr>	
    <?php 
    }

    if(isset($_SESSION["vat6_cart_item"])){//show vat 6% item shopping cart
        $vat6_item_total = 0;
    ?>	
    <tr><th colspan="4" class="txt-heading">VAT 6%</th></tr>
    <tr>
    <th style="text-align:left;"><strong>Name</strong></th>
    <th style="text-align:left;"><strong>Code</strong></th>
    <th style="text-align:right;"><strong>Quantity</strong></th>
    <th style="text-align:right;"><strong>Price</strong></th>
    </tr>	
        <?php		
        foreach ($_SESSION["vat6_cart_item"] as $item){
		?>
    <tr>
    <td style="text-align:left;border-bottom:#F0F0F0 1px solid;"><strong><?php echo $item["name"]; ?></strong></td>
    <td style="text-align:left;border-bottom:#F0F0F0 1px solid;"><?php echo $item["code"]; ?></td>
    <td style="text-align:right;border-bottom:#F0F0F0 1px solid;"><?php echo $item["quantity"]; ?></td>
    <td style="text-align:right;border-bottom:#F0F0F0 1px solid;"><?php echo "EUR ".$item["price"]; ?></td>
    </tr>
        <?php
            $vat6_item_total += ($item["price"]*$item["quantity"]);
        }
        $_SESSION["item_total"] += $vat6_item_total;
		?>
    <tr>
    <td colspan="4" align=right><strong>Subtotal:</strong> <?php echo "EUR ".$vat6_item_total; ?></td>
    </tr>
    <?php
    }

    if(isset($_SESSION["vat21_cart_item"])){//show vat 21% item shopping cart
        $vat21_item_total = 0;
    ?>	

    <tr><th colspan="4" class="txt-heading">VAT 21%</th></tr>
    <tr>
    <th style="text-align:left;"><strong>Name</strong></th>
    <th style="text-align:left;"><strong>Code</strong></th>
    <th style="text-align:right;"><strong>Quantity</strong></th>
    <th style="text-align:right;"><strong>Price</strong></th>
    </tr>	
        <?php		
        foreach ($_SESSION["vat21_cart_item"] as $item){
        ?>
    <tr>
    <td style="text-align:left;border-bottom:#F0F0F0 1px solid;"><strong><?php echo $item["name"]; ?></strong></td>
    <td style="text-align:left;border-bottom:#F0F0F0 1px solid;"><?php echo $item["code"]; ?></td>
    <td style="text-align:right;border-bottom:#F0F0F0 1px solid;"><?php echo $item["quantity"]; ?></td>
    <td style="text-align:right;border-bottom:#F0F0F0 1px solid;"><?php echo "EUR ".$item["price"]; ?></td>
    </tr>
        <?php
            $vat21_item_total += ($item["price"]*$item["quantity"]);
        }
        $_SESSION["item_total"] += $vat21_item_total;
		?>

    <tr>
    <td colspan="4" align=right><strong>Subtotal:</strong> <?php echo "EUR ".$vat21_item_total; ?></td>
    </tr>		
    <?php
    }   
    ?>
    <tr><td colspan="4" align=right><strong>Total: <?php echo "EUR ".$_SESSION["item_total"]; ?></strong></td></tr>
<?php
}
else{
?>
<tr><td colspan="4">No items in your cart......</td></tr>
<?php
}
?>
</tbody>
<tfoot>
    <tr>
    <td><a href="javascript:history.go(-1)" class="btn btn-warning"><i class="glyphicon glyphicon-menu-left"></i> Continue Shopping</a></td>
    <td colspan="2"></td>
    <?php if(isset($_SESSION["item_total"])){ ?>
    <td class="text-right"><a href="checkout.php" class="btn btn-success">Checkout <i class="glyphicon glyphicon-menu-right"></i></a></td>
    <?php } ?>
    </tr>
</tfoot>
</table>
</div>
</body>
</html>