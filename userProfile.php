<?php
session_start(); 
if($_SESSION["validlogin"] !== true){
  header("location: userReg.php");
  exit;
}
 require('connect-db.php');
 require('database_functions.php');

 $user_orgs = getUserOrgs($_SESSION['uName']);
//  print "<pre>";
//  print_r($user_orgs);
// print "</pre>";
 $user_interests = getUserInterests($_SESSION['uName']);
//  print "<pre>";
//  print_r($user_interests);
// print "</pre>";
$user_subs = getUserSubs($_SESSION['uName']);
// print "<pre>";
//  print_r($user_subs);
// print "</pre>";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try{
       if(!empty($_POST['btnAction']) && $_POST['btnAction'] == "Leave Org") {
        removeUserOrg($_SESSION['uName'], $_POST['org_to_leave']);
        $user_orgs = getUserOrgs($_SESSION['uName']);
       }
       else if(!empty($_POST['btnAction']) && $_POST['btnAction'] == "Remove Interest") {
        removeUserInterest($_SESSION['uName'], $_POST['interest_to_remove']);
        $user_interests = getUserInterests($_SESSION['uName']);
       }
       else if(!empty($_POST['btnAction']) && $_POST['btnAction'] == "Unsubscribe") {
        removeFromSub($_POST['event_to_unsubscribe'], $_SESSION['uName']);
        $user_subs = getUserSubs($_SESSION['uName']);
       }
    }
     catch(Exception $except){
       throw new Exception('Error posting to server during view Events');
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

    <meta name="author" content="Database Group">
    <meta name="description" content="This is a list view of events in our UVA calendar">

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
    <style>
    h1 {text-align: center;}
    </style>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->
</head>
<body>



<div class="container">
  <header>
  <form action="viewEventsPage.php" method="post">
    
    <button class="btn btn-primary">Go Back</a></button>
   
    </form>
    <div style="float:right;">
  <div style="float:left;">
    <form action="logoutUser.php" method="post">
    
    <button class="btn btn-primary">Logout</a></button>
   
    </form>
  </div>
    </div>
  </header>
  <div class="header">
      <table style="margin-left:auto;margin-right:auto;">
        <tr>
          <td> 
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/d/dd/University_of_Virginia_Rotunda_logo.svg/1200px-University_of_Virginia_Rotunda_logo.svg.png" style="vertical-align: middle" width="100" height="100"/>
          </td>
          <td>
            <h1>UVA Calendar</h1>
          </td>
          <td>
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/d/dd/University_of_Virginia_Rotunda_logo.svg/1200px-University_of_Virginia_Rotunda_logo.svg.png" style="vertical-align: middle" width="100" height="100"/>
          </td>
        </tr>
      </table>
  </div>

<h2> <?php echo "Welcome, {$_SESSION['uName']} "?> </h2>
<table class="w3-table w3-bordered w3-card-4" style="width:90%">
<thead>
<tr style="background-color:#b0b0b0">
<th width="40%">Organizations</th>
<th width="40%">Is Exec</th>
<th width="20%">Leave Org</th>
</tr>
</thead>

<?php foreach ($user_orgs as $org): ?>
<tr>
    <td><?php echo $org['org_name'] ?></td>
    <td><?php echo $org['is_exec'] ?></td>
    <td>
        <form action="userProfile.php" method="post">
        <input type="submit" name="btnAction" value="Leave Org" class="btn btn-danger" />
        <input type="hidden" name="org_to_leave" value="<?php echo $org['org_name'] ?>" />      
        </form>
    </td>
    <!-- <td><form action="viewEventsPage.php" method="post">
        <input type="submit" name="btnAction" value="ShowDetails" class="btn btn-primary" />
        <input type="hidden" name="event_to_display" value="<?php echo $event['event_id'] ?>" />      
      </form></td> -->
    <!-- <td><button class="btn btn-primary"><a href="updateEventPage.php?event_to_update=<?=$event['event_id']?>" style="color: white">UpdateEvent</a></button></td>
    <td><form action="viewEventsPage.php" method="post">
      <input type="submit" name="btnAction" value="DeleteEvent" class="btn btn-primary" />
      <input type="hidden" name="event_to_delete" value="<?php echo $event['event_id'] ?>" />      
    </form></td> -->
</tr>
 <?php endforeach; ?>

  </table>

  <table class="w3-table w3-bordered w3-card-4" style="width:90%">
<thead>
<tr style="background-color:#b0b0b0">
<th width="80%">Subscribed Events</th>
<th width="20%">Unsubscribe</th>


<!--

<th width="12%">Delete ?</th>
/> -->
</tr>
</thead>

<?php foreach ($user_subs as $sub): ?>
<tr>
    <td><?php echo $sub['name']; ?></td>
    <td>
        <form action="userProfile.php" method="post">
        <input type="submit" name="btnAction" value="Unsubscribe" class="btn btn-danger" />
        <input type="hidden" name="event_to_unsubscribe" value="<?php echo $sub['event_id'] ?>" />      
        </form>
    </td>
    <!-- <td><?php echo $event['date_of_event']; ?></td>
    <td><?php echo $event['org_name']; ?></td>
    <td><form action="viewEventsPage.php" method="post">
        <input type="submit" name="btnAction" value="ShowDetails" class="btn btn-primary" />
        <input type="hidden" name="event_to_display" value="<?php echo $event['event_id'] ?>" />      
      </form></td>
    <td><button class="btn btn-primary"><a href="updateEventPage.php?event_to_update=<?=$event['event_id']?>" style="color: white">UpdateEvent</a></button></td>
    <td><form action="viewEventsPage.php" method="post">
      <input type="submit" name="btnAction" value="DeleteEvent" class="btn btn-primary" />
      <input type="hidden" name="event_to_delete" value="<?php echo $event['event_id'] ?>" />      
    </form></td> -->
</tr>
 <?php endforeach; ?>

  </table>

  <table class="w3-table w3-bordered w3-card-4" style="width:90%">
<thead>
<tr style="background-color:#b0b0b0">
<th width="80%">Interests</th>
<th width="20%">Remove Interest</th>

<!--

<th width="12%">Delete ?</th>
/> -->
</tr>
</thead>

<?php foreach ($user_interests as $interest): ?>
<tr>
    <td><?php echo $interest['interest']; ?></td>
    <td>
        <form action="userProfile.php" method="post">
        <input type="submit" name="btnAction" value="Remove Interest" class="btn btn-danger" />
        <input type="hidden" name="interest_to_remove" value="<?php echo $interest['interest'] ?>" />      
        </form>
    </td>
    <!-- <td><?php echo $event['date_of_event']; ?></td>
    <td><?php echo $event['org_name']; ?></td>
    <td><form action="viewEventsPage.php" method="post">
        <input type="submit" name="btnAction" value="ShowDetails" class="btn btn-primary" />
        <input type="hidden" name="event_to_display" value="<?php echo $event['event_id'] ?>" />      
      </form></td>
    <td><button class="btn btn-primary"><a href="updateEventPage.php?event_to_update=<?=$event['event_id']?>" style="color: white">UpdateEvent</a></button></td>
    <td><form action="viewEventsPage.php" method="post">
      <input type="submit" name="btnAction" value="DeleteEvent" class="btn btn-primary" />
      <input type="hidden" name="event_to_delete" value="<?php echo $event['event_id'] ?>" />      
    </form></td> -->
</tr>
 <?php endforeach; ?>

  </table>
  
</div> 
  
</body>
</html>