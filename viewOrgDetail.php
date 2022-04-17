<?php
session_start(); 
if($_SESSION["validlogin"] !== true){
  header("location: login.php");
  exit;
}
 require('connect-db.php');
 

 require('database_functions.php');

 $org_details = getOrgDetail($_POST['org_to_display']);
 $orgName = "";
 $orgEmail = "";
 $orgDesc = "";

//  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//    try{
//       if(!empty($_POST['btnAction']) && $_POST['btnAction'] == "ShowDetails") {
        

//       }
//      }

//     catch(Exception $except){
//       throw new Exception("Error loading event detail page");
//     }
//  }
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
    <meta name="description" content="This is a template from class that I am using to understand how to make a webpage">

    <title>Bootstrap example</title>

    <!-- 3. link bootstrap -->
    <!-- if you choose to use CDN for CSS bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!-- you may also use W3's formats -->
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

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
<header>
    <div style="float:right;">
    <form action="logoutUser.php" method="post">
      <button class="btn btn-primary">Logout</a></button>
    </form>
    </div>
</header>
<?php foreach ($org_details as $org): ?>
  <?php $orgName=$org['org_name']; ?>
  <?php $orgEmail=$org['email']; ?>
  <?php $orgDesc=$org['description']; ?>
<?php endforeach; ?>
<?php if ($org_details!=null):?>
  <table class="table">
    <thead>
      <tr>
        <th scope="col">Category</th>
        <th scope="col">Information</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">Name</th>
        <td><?php echo $orgName?></td>
      </tr>
  </tbody>
  <tbody>
      <tr>
        <th scope="row">Contact Email</th>
        <td><?php echo $orgEmail?></td>
      </tr>
  </tbody>
  <tbody>
      <tr>
        <th scope="row">Description</th>
        <td><?php echo $orgDesc?></td>
      </tr>
  </tbody>
  <tbody>
    <a href="viewEventsPage.php">Return to Full Events List</a>
 </tbody>
  </table>
  <?php endif; ?>
</body>
</html>
