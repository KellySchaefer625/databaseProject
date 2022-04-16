<?php
  session_start();
  $uName = "";
  $pass = "";
  $wrongUser = "";
  $wrongPass = "";
  $invalidLogin = "";
if(isset($_SESSION["validlogin"]) && $_SESSION["validlogin"]===true){
    header("location: addEventPage.php");
    exit;
}
//continue from here
  require("connect-db.php");
  require('database_functions.php');

if($_SERVER["REQUEST_METHOD"]=="POST"){

  if(empty(trim($_POST["name"]))){
    $wrongUser = "Empty Username field.";
  }
  else{
    $uName = trim($_POST["name"]);
  }
  if(empty(trim($_POST["pwd"]))){
    $wrongPass = "Empty Password field.";
  }
  else{
    $pass = trim($_POST["pwd"]);
  }
  if((empty($uName)==FALSE) && (empty($pass)==FALSE)){
    $userCreds = getUserCredentials($_POST["name"],$_POST["pwd"]);
//get credentials, return as hash, check hash in main function?
//if 0 is returned, error, display invalid username or password
//IF -3, other issue
echo $userCreds;

if($userCreds==-1){
  $invalidLogin = "Invalid usename or password.";
}
if($userCreds==-3){
$invalidLogin = "Invalid usename or password.";
}
else if(password_verify($pass,$userCreds['pword'])){
  //if password is valid then set session to true an log user in
//handle actual login stuff here
echo $pass;
  session_start();
  $_SESSION["validlogin"] = true;
  $_SESSION["uName"] = $userCreds['uName'];
  //redirect to welcome page
  header('location: updateEventPage.php');
}
else{
  echo "Undefined Login Issue.";
}

}
 
//dont forget to navigate users to specific pages
  
}

  ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">   
  <meta http-equiv="X-UA-Compatible" content="IE=edge">  <!-- required to handle IE -->

  
  
  <meta name="viewport" content="width=device-width, initial-scale=1">  
  <title>UVA Calendar Login</title>
 
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
  <style>
    label { display: block; }
    input, textarea { display:inline-block; font-family:arial; margin: 5px 10px 5px 40px; padding: 8px 12px 8px 12px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; width: 90%; font-size: small; }
    div { margin-left: auto; margin-right: auto; width: 60%; }
    h1 { text-align: center; }    
    input[type=submit] { padding:5px 15px; border:0 none; cursor:pointer; border-radius: 5px; }
    input[type=submit]:hover { background-color: #ccceee; }
    .msg { margin-left:40px; font-style: italic; color: red; }    
    html{ height:100%; }
    body{ min-height:100%; padding:0; margin:0; position:relative; }    
    footer { position: absolute; bottom: 0; width: 100%; height: 50px; color: WhiteSmoke; padding: 10px; }
   </style>   
</head>

<body>
  
  <div>  
    <h1>UVA Calendar Login</h1>
    <p>Enter Credentials</p>
    <?php
    if(!empty($invalidLogin)){
      echo '<div class="alert">'. $invalidLogin . '</div>';
    }
    ?>
    <form action="login.php" method="post">
     
      Username: <input type="text" name="name" required /> <br/>
      Password: <input type="password" name="pwd" required /> <br/>
      <input type="submit" value="Submit" class="btn btn-secondary" />
    </form>
  </div>
  
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
    
</body>
</html>