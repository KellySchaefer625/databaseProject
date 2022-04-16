<?php
global $db;
 require("connect-db.php");
 require('database_functions.php');

 $desiredUsername = "";
 $desiredPassword = "";
 $confirmPass = "";
 $usernameError = "";
 $passwordError = "";
 $confirmPassError = "";


 if($_SERVER["REQUEST_METHOD"]=="POST"){

    if(empty(trim($_POST["name"]))){
      $usernameError = "Empty Username field.";
    }
    elseif(!preg_match('/^[a-zA-Z0-9_!@*]+$/', trim($_POST["name"]))){
        $usernameError = "Invalid Character. Username contains letters, numbers, underscores, !,@ and *";
    }
    else{
        $query = "SELECT comp_id FROM User_by_id WHERE comp_id = :desiredName";
        $statement = $db->prepare($query);
        $desiredUsername= trim($_POST["name"]);
        //checklater
        $statement-> bindValue(":desiredName",$desiredUsername);


       
        if($statement->execute()){
            if($statement->rowCount()==1){
                $usernameError = "There already exists a user by this name.";
            }
            elseif(strlen(trim($_POST["name"])) > 8){
                $usernameError = "This only accepts 7 letter or less usernames.";
            }
            else{
                $desiredUsername = trim($_POST["name"]);
            }
            unset($statement);
        }
    }
    if(empty(trim($_POST["pwd"]))){
        $passwordError = "Empty password field";
    }
    elseif(strlen(trim($_POST["pwd"])) < 8){
        $passwordError = "Passwords must be at least 8 characters long.";
    }
    else{
        $desiredPassword = trim($_POST["pwd"]);
    }
//vpass
    if(empty(trim($_POST["confirmPW"]))){
        $confirmPassError = "Empty password confirmation field.";
    }
    else{
        $confirmPass = trim($_POST["confirmPW"]);
        if(empty($passwordError)&&($desiredPassword!=$confirmPass)){
            $passwordError = "Password mismatch";
        }
    }
    if(empty($usernameError)&& empty($confirmPassError) && empty($passwordError)){
        $query = "INSERT INTO User_by_id (comp_id,pword) VALUES (:uname,:pwd)";
        $statement = $db->prepare($query);
        if($statement){
            $statement->bindValue(":uname",$desiredUsername);
            echo $desiredUsername;
            $desiredPassword = password_hash($desiredPassword,PASSWORD_DEFAULT);
            echo $desiredPassword;
            $statement->bindValue(":pwd",$desiredPassword);
            echo $query;
            if($statement->execute()){

                header("location: login.php");
            }
            else{
                echo "Registration error";
            }
            unset($statement);
        }
    }
        unset($db);

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">   
  <meta http-equiv="X-UA-Compatible" content="IE=edge">  <!-- required to handle IE -->

  
  
  <meta name="viewport" content="width=device-width, initial-scale=1">  
  <title>UVA Calendar Registration Form</title>
 
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
  
  <div class = "wrapper">  
    <h1>UVA Calendar Registration Form</h1>
    <p>Register Here</p>
    <?php
    if(!empty($invalidLogin)){
      echo '<div class="alert">'. $invalidLogin . '</div>';
    }
    ?>
    <form action="userReg.php" method="post">
        <div class = "form-group">
      Username: <input type="text" name="name" class = "form-control <?php echo (!empty($usernameError)) ? 'is-invalid': ''; ?>" required /> <br/>
      <span class = "invalid-feedback"><?php echo $usernameError;?></span>
    </div> 
    <div class = "form-group">     
      Password: <input type="password" name="pwd" class = "form-control <?php echo (!empty($passwordError))? 'is-invalid': ''; ?>" required /> <br/>
      <span class = "invalid-feedback"><?php echo $passwordError;?></span>
      </div> 

      <div class = "form-group">
      Confirm Password: <input type="password" name="confirmPW" class = "form-control <?php echo (!empty($confirmPassError))? 'is-invalid': ''; ?>" required /> <br/>
      <span class = "invalid-feedback"><?php echo $confirmPassError;?></span>
      </div> 

      <input type="submit" value="Submit" class="btn btn-secondary" />
      <div>
      <p> Click here if you already have an account <a href="login.php"> Login Here</a>.</p>
        </div>
    </form>
  </div>
  
  
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
    
</body>
</html>
