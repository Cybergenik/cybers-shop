<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">
    <link rel="stylesheet" href="css/main.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <title>Login</title>
</head>
<body id="bg">
<?php 
session_start();
?>
<?php if(empty($_POST)) :?>
<h2 style="border-bottom: 2px solid; width: 40%; color: #ff7a7a; margin-bottom: 2%">Edit Account:</h2>

<div id="accordion" class="flex-container">
  <div class="card">
    <div class="card-header" id="headingUser">
        <button class="mybutton" data-toggle="collapse" data-target="#collapseUser" aria-expanded="true" aria-controls="collapseUser">
          Change Username
        </button>
    </div>

    <div id="collapseUser" class="collapse" aria-labelledby="headingUser" data-parent="#accordion">
    <div class="card-body">  
      <form class="flex-container" method="POST">
      <input class="myin" name="user" type="text" placeholder="Current Username">
      <input class="myin" name="new_user" type="text" placeholder="New Username">
      <input class="mybutton"  type="submit" value="Submit">
      </form>
    </div>
    </div>
  </div>

  <div class="card">
    <div class="card-header" id="headingPass">
        <button class="mybutton" data-toggle="collapse" data-target="#collapsePass" aria-expanded="true" aria-controls="collapsePass">
          Change Password
        </button>
    </div>

    <div id="collapsePass" class="collapse" aria-labelledby="headingPass" data-parent="#accordion">
    <div class="card-body">
      <form class="flex-container" method="POST">
      <input class="myin" name="pass" type="text" placeholder="Password">
      <input class="myin" name="new_pass" type="text" placeholder="Password">
      <input class="mybutton"  type="submit" value="Submit">
      </form>
    </div>
    </div>
  </div>

</div>
<?php else :?>
<?php
  if (!empty($_POST['user']) && !empty($_POST['new_user'])){
      $conn = new Conn();
      include_once('includes/hash.php');
      $user_auth = $conn->prepare("SELECT * FROM users WHERE username=?");
      $user = str_replace(' ', '', $_POST['user']);
      $user_auth->bind_param("s", $user);
      //Assign variables
      //Execute SQL
      $user_auth->execute();
      $result = $user_auth->get_result();
      $auth = $result->num_rows; 
  }
?>

<?php endif; ?>
</body>
</html>