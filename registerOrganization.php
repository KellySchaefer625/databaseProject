<?php
session_start();
if($_SESSION["validlogin"] !== true){
  header("location: login.php");
  exit;
 }
 require('connect-db.php');
 require('database_functions.php');
  $submitted = false;
  $addExec = false;
  $orgName = '';
 if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   try{
      if(!empty($_POST['btnAction']) && $_POST['btnAction'] == "Register") { 
        registerOrg($_POST['org_name'], $_POST['org_email'], $_POST['org_description']);
        $submitted = true;
        $orgName = $_POST['org_name'];
      }
     
  }

    catch(Exception $except){
      throw new Exception("Error registering organization page");
    }
 }


 ?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8">

    <!-- 2. include meta tag to ensure proper rendering and touch zooming -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--
    Bootstrap is designed to be responsive to mobile.
    Mobile-first styles are part of the core framework.
    width=device-width sets the width of the page to follow the screen-width
    initial-scale=1 sets the initial zoom level when the page is first loaded
    -->

    <meta name="author" content="Kelly Schaefer">
    <meta name="description" content="This is a subpage to register organizations">

    <title>Register Organization Page</title>

    <!-- 3. link bootstrap -->
    <!-- if you choose to use CDN for CSS bootstrap -->
    <!--
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>


    <!-- you may also use W3's formats -->
    <!--  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css"> -->
    <!--
    Use a link tag to link an external resource.
    A rel (relationship) specifies relationship between the current document and the linked resource.
    -->
    <!-- If you choose to use a favicon, specify the destination of the resource in href -->
    <link rel="icon" type="image/png" href="http://www.cs.virginia.edu/~up3f/cs4750/images/db-icon.png" />

    <!-- if you choose to download bootstrap and host it locally -->
    <!-- <link rel="stylesheet" href="path-to-your-file/bootstrap.min.css" /> -->
    <!-- include your CSS -->
    <!-- <link rel="stylesheet" href="custom.css" />  -->
</head>
<body>
    <div class="container">
        <h1>Register Organization</h1>
<form name="mainForm" action="registerOrganization.php" method="post">
 <div visibility: <?php if ($submitted == true) echo 'hidden'; ?>>
  <div class="row mb-3 mx-3">
 Organization Name:
 <input type="text" class="form-control" name="org_name" required />
 </div>

 <div class="row mb-3 mx-3">
 Email:
 <input type="text" class="form-control" name="org_email" required />
 </div>

 <div class="row mb-3 mx-3">
  Description of Organization:
 <input type="text" class="form-control" name="org_description" required />
 </div>
  
<input type="submit" value="Register" name="btnAction" class="btn btn-dark"
        title = "Register Organization" />
   </div>
  </form>
</div>
  
  
   <form name="subForm" action="registerOrganization.php" method="post">
     
     <div class="row mb-3 mx-3">
                &nbsp
            </div>
     
         <div class="row mb-3 mx-3">
                &nbsp
            </div>
     
     <div visibility: <?php if ($submitted == false || $addExec == true) echo 'hidden'; ?>>
                  <div class="row mb-3 mx-3">
                      <button type="submit" value="AddExec" name="btnAction" class="btn btn-dark btn-block"
                        title = "Add Executive Member?" /> Add Executive Member </button>
                   </div>
            </div>

<div class="row mb-3 mx-3">
   &nbsp
</div>
  
 <div class="row mb-3 mx-3">
   <div visibility: <?php if ($addExec == false) echo 'hidden'; ?>>
      Executive Member Username:
      <input type="text" class="form-control" name="execName"  />
   </div>
 </div>
     
 <div class="row mb-3 mx-3">
   &nbsp
 </div>
  
 <div>
  <input type="hidden" id="orgName" name="orgName" value=<?php echo $orgName; ?> >
 </div>
  
  <div class="row mb-3 mx-3">
   &nbsp
</div>
  
<div class="row mb-3 mx-3">
  <div visibility: <?php if ($addExec == false) echo 'hidden'; ?>>
   <button type="submit" value="execAdd" name="btnAction" class="btn btn-dark"
        title = "Add Exec" /> Add Executive Member </button>
  </div>
 </div>

<div visibility: <?php if ($submitted == false || $addExec == true) echo 'hidden'; ?>>
   <div class="row mb-3 mx-3">
   <a href="viewEventsPage.php">
  <input href="viewEventsPage.php"  type="button" value="Done" name="btnAction" class="btn btn-dark btn-block"
        title = "Done" />
   </a>
  </div>
  </div>

</body>
</div>
</html>
