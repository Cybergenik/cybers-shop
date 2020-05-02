<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="css/main.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="text/javascript" src="js/search.js"></script>
    <title>Catalog</title>
</head>
<body id="bg">
<h1 class="banner"><span>Cyber's Gaming Store</span></h1>
<div class="banner-nav">
<?php if(!isset($_SESSION['auth'])) :?>
    <a href="index.php">Login</a>
    <a href="create-account.php">Create-Account</a>
<?php else:?>
    <a href="index.php">Home</a>
<?php endif;?>
    <a href="catalog.php">Products</a>
<?php if(isset($_SESSION['auth'])) :?>
    <a href="logout.php">Logout</a>
    <div class="cart-number">
    <a href="cart.php" style="padding: 0rem 0rem 1rem 0rem;"><img src="img/cart.png" alt="Cart" height="35" width="35"></a>
    <?php
    if(isset($_SESSION['prodid'])){
        print '<p style="padding-bottom: 2rem">'.sizeof($_SESSION['prodid']).'</p>';
    }
    ?>
    </div>
<?php endif;?>
</div>
<h2 style="border-bottom: 2px solid; width: 15%; color: #ff7a7a;">Catalog</h2>
<div class="flex-container2" style="margin-top: 5%">
<input class="myin" type="text" id="searchTerm" onkeyup ="nameSearch()">
<input class="mybutton" type="button" onclick="nameSearch()" value="Search">
</div>
<div class="flex-catalog" id="catalog">
<?php
include_once('includes/product.php');
    $total = new Product(1);
    for($i = 1; $i <= $total->getTotal();$i++) {
        $product = new Product($i);
        echo '
        <div class="card" id="prod'.$i.'" style="width: 30%; height: 30%; margin-bottom: 10%;">
        <h5 class="card-title" id="prodname'.$i.'" style="color: black; text-align: center; font-size: 25px; border-bottom: 2px solid;">'.$product->getName().'</h5>
        <img class="card-img-top" id="prod-img" src="'.$product->getImg().'" alt="Product">
        <div class="card-body">
            <p class="card-text" id="prodid'.$i.'" style="color: black; font-size: 17px;" hidden>'.$product->getDesc().'</p>
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item" style="color: black; text-align: center;">Price: $'.$product->getPrice().'</li>
        </ul>
        <div class="card-body">
            <a href="product.php?prodId='.$i.'" class="mybutton" class="card-link" style="margin-left: 13%;">View product details</a>
        </div>
        </div>
        ';
    }
?>
</div>
</body>
</html>