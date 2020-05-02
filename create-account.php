<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="css/main.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="text/javascript" src="js/match.js"></script>
    <title>Create Account</title>
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
        <a href="cart.php" style="margin-left: 5%;"><img src="img/cart.png" alt="Cart" height="32" width="32"></a>
        <?php
        if(isset($_SESSION['prodid'])){
            echo sizeof($_SESSION['prodid']);
        }
        ?>
    <?php endif;?>
    </div>
    <h2 style="border-bottom: 2px solid; width: 15%; color: #ff7a7a; margin-bottom: 2%;">Create Account</h2>
    <?php
        //display error messages and missed fields
        $x = false;
        if(!empty($_POST)){
            //Make sure fields are filled
            if(empty($_POST['user']) || empty($_POST['pass']) || empty($_POST['vpass'])){
                echo "<h4 style='text-align: center'>Please fill out all fields</h4>";
            }
            //validate username and password match
            else{
                include_once('includes/create_user.php');
                $user = new User($_POST['user'], $_POST['pass']);

                if(!$user->getUexists()){
                    $user->addUser();
                    $x = true;  
                }
                elseif($user->getUexists()){
                    echo "<h4 style='text-align: center'>That Username is taken<h4>";
                }
            }
        }

        if (isset($_POST['user'])) $uvalue = $_POST['user']; else $uvalue = '';
        if (isset($_POST['pass'])) $pvalue = $_POST['pass']; else $pvalue = '';
        if (isset($_POST['vpass'])) $vpvalue = $_POST['vpass']; else $vpvalue = '';
        //Display Form
        if (!$x){
            echo '
            <form class="flex-container" action="create-account.php" method="post">
            <label for="user">Username:</label>        
                <input class="myin" class="input" name="user" id="user" type="text" placeholder="Username" value="'.$uvalue.'">
            <label for="pass">Password:</label>
                <input class="myin" class="input" name="pass" id="pass" onkeyup="checker()" type="password" autocomplete="new-password" minlength="8" maxlength="25" pattern="(?=.*\d).{8,}" required title="Must contain at least one number and be at least 8 or more characters" placeholder="Password" value="'.$pvalue.'">
            <label for="vpass"> Verify Password:</label>
                <p id="warning" style="color: red; font-size: 18px;" hidden>No Match</p>
                <p id="pass_war" style="color: red; font-size: 18px;" hidden>Password must be at least 8 characters long and contain atleast 1 number</p>
                <input class="myin" class="input" name="vpass" id="vpass" onkeyup="checker()" type="password" placeholder="Password" value="'.$vpvalue.'">   
                <div class="flex-container2">
                <input class="mybutton" onclick="reset_form()" type="reset">
                <input id="submit" class="mybutton" type="submit" value="Create Account">
                </div>
            </form>
            ';
        }
        //Display Access Granted
        elseif ($x){
            header("Location: index.php?acc=1");
        }

    ?>
</body>
</html>