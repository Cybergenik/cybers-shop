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
    <title>Cart</title>
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
<?php if(!isset($_SESSION['auth'])) :?>
    <div class="flex-container">
    <br><br><h2 style="border-bottom: 2px solid;">Please Log in before adding items to your Cart</h2><br>
    <a class="mybutton" style="color: #151D21;" href="index.php">Login</a>  
</div>
<?php else :?>
    <h2 style="border-bottom: 2px solid; width: 15%; color: #ff7a7a; margin-bottom: 2%;">Cart</h2>
<?php
if(!empty($_POST) && !isset($_POST['purchase'])){
    echo '<br>';
    foreach($_POST as $id=>$val){   
        if($val != 0){
            $_SESSION['qty'][$id] = $val;
        }
        else{
            unset($_SESSION['prodid'][$id]);
            unset($_SESSION['name'][$id]);
            unset($_SESSION['price'][$id]);
            unset($_SESSION['qty'][$id]);
            if(empty($_SESSION['prodid'])){
                unset($_SESSION['prodid']);
                unset($_SESSION['name']);
                unset($_SESSION['price']);
                unset($_SESSION['qty']);
            }
        }
    }
}
if(!isset($_POST['purchase'])){
    if(isset($_SESSION['prodid'])){
    echo '
    <form class="flex-container" action="cart.php" method="POST">
    <table>
        <tr>
        <th>Product</th>
        <th>Price</th>
        <th>Total Price</th>
        <th>Qty</th>
        </tr>
    ';
        $total= 0.00;
        foreach($_SESSION['prodid'] as $i=>$val){
            echo '
                <tr>
                <th>'.$_SESSION['name'][$i].'</th>
                <th>$'.$_SESSION['price'][$i].'</th>
                <th>$'.$_SESSION['price'][$i] * $_SESSION['qty'][$i].'</th>
                <th><input id="qty" style="width: 65px;" class="myin" type="number" min="0" name="'.$i.'" step="1" value="'.$_SESSION['qty'][$i].'"></th>
                </tr>
            ';
            $total += $_SESSION['price'][$i] * $_SESSION['qty'][$i];
        }
        echo'
            <tr>
            <th></th>
            <th>Total:</th>
            <th>$'.$total.'</th>
            <th><input class="mybutton" type="submit" value="Update Cart"></th>
            </tr>
            </table>
            </form>

            <form action="cart.php" method="POST">
            <div class="flex-container2">
            <input type="hidden" name="purchase" value="true">           
            <input class="mybutton" type="submit" value="Place Order">
            </div>
            </form>

        ';
    }
    elseif(!isset($_SESSION['prodid']) || empty($_SESSION['prodid'])){
        echo '
        <div class="flex-container">
        <br><br><h2 style="border-bottom: 2px solid;">Your Cart is Empty</h2><br>
        <a class="mybutton" style="color: #151D21;" href="catalog.php">Products</a> 
        </div>
        ';
    }
}
else{
    echo '
    <br><br><h2 style="border-bottom: 2px solid; width: 30%; color: #ff7a7a;">Thank you!</h2>
    <h2>Your Order:</h2>
    <div class="flex-container">
    <table>
        <tr>
        <th>Product</th>
        <th>Price</th>
        <th>Total Price</th>
        <th>Qty</th>
        </tr>';
    $total= 0.00;
    foreach($_SESSION['prodid'] as $i=>$val){
        echo '
            <tr>
            <th>'.$_SESSION['name'][$i].'</th>
            <th>$'.$_SESSION['price'][$i].'</th>
            <th>$'.$_SESSION['price'][$i] * $_SESSION['qty'][$i].'</th>
            <th>'.$_SESSION['qty'][$i].'</th>
            </tr>
        ';
        $total += $_SESSION['price'][$i] * $_SESSION['qty'][$i];
    }
    echo'
    <tr>
    <th></th>
    <th></th>
    <th>Total:</th>
    <th>$'.$total.'</th>
    </tr>
    </table>
    </div>
    <div class="flex-container">
    <a class="mybutton" style="color: #151D21;" href="index.php">Home</a> 
    </div>
    ';
    unset($_SESSION['prodid']);
    unset($_SESSION['name']);
    unset($_SESSION['price']);
    unset($_SESSION['qty']);
}
    ?>
<?php endif;?>
</body>
</html>