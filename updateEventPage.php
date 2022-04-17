<?php

session_start(); 
if($_SESSION["validlogin"] !== true){
  header("location: userReg.php");
  exit;
}
 require('connect-db.php');
 require('database_functions.php');
 $event_details = getEventDetail($_GET['event_to_update']);
 $event_audience = getEventAudience($_GET['event_to_update']);
 $event_categories = getEventCategories($_GET['event_to_update']);
 $event_restrictions = getEventRestrictions($_GET['event_to_update']);

 if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   try{
      if(!empty($_POST['btnAction']) && $_POST['btnAction'] == "Update") {
        updateEvent_By_ID($_GET['event_to_update'], $_POST['name'], $_POST['time_start'], $_POST['time_end'], $_POST['building'], $_POST['room'], $_POST['date_of_event'], $_POST['cost'], $_POST['food']);
        updateHost($_POST['org_name'], $_GET['event_to_update']);
        updateEvent_audience($_GET['event_to_update'],$_POST['audience']);
        updateEvent_categories($_GET['event_to_update'],$_POST['categories']);
        // updateEvent_restrictions($_GET['event_to_update'],$_POST['restrictions']);

      }
     }

    catch(Exception $except){
      throw new Exception("Error updating event page");
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
    <div style="float:left;">
    <div style="float:left;">
    <form action="addEventPage.php" method="post">
    <button class="btn btn-primary">Create Event</a></button>
    </form>
  </div>
<div style="float:left;">
    <form action="userProfile.php" method="post">
    <button class="btn btn-primary" class="glyphicon glyphicon-user">User Profile</a></button>
    </form>
  </div>
</div>
  <div style="float:left;">
    <form action="logoutUser.php" method="post">
    
    <button class="btn btn-primary">Logout</a></button>
   
    </form>
  </div>
    </div>
  </header>

<div class="container">
<td><button class="btn btn-primary"><a href="viewEventsPage.php">Go Back</a></button></td>

<h1>Update Event</h1>
<form name="mainForm" action="updateEventPage.php?event_to_update=<?=$_GET['event_to_update']?>" method="POST">   
  <div class="row mb-3 mx-3">
    Event Name:
    <input type="text" class="form-control" name="name" value="<?php echo $event_details[0]['name'] ?>" required />      
  </div>  
 
  <div class="row mb-3 mx-3">
    Event Host:
        <input type="text" class="form-control" name="org_name" value="<?php echo $event_details[0]['org_name'] ?>" required />        
    </div>  
 
  <div class="row mb-3 mx-3">
    Event Date:
        <input type="date" class="form-control" name="date_of_event" value="<?php echo $event_details[0]['date_of_event'] ?>" />        
    </div> 

  <div class="row mb-3 mx-3">
    Event Categories:
    <input type="text" class="form-control" name="categories" value="<?php echo $event_categories[0]['category_name'] ?>" />      
  </div>

  <div class="row mb-3 mx-3">
    Event Audience:
    <input type="text" class="form-control" name="audience" value="<?php echo $event_audience[0]['audience_type'] ?>"   />      
  </div> 

  <!-- <div class="row mb-3 mx-3">
    Event Details:
    <input type="text" class="form-control" name="details" required />      
  </div> -->

    <div class="row mb-3 mx-3">
    Start Time:
        <input type="time" class="form-control" name="time_start" value="<?php echo $event_details[0]['time_start'] ?>"  />        
    </div>  
 
   <div class="row mb-3 mx-3">
    End Time:
        <input type="time" class="form-control" name="time_end" value="<?php echo $event_details[0]['time_end'] ?>"  />        
    </div>  
 
  <div class="row mb-3 mx-3">
    Building:
        <input type="text" class="form-control" name="building" required value="<?php echo $event_details[0]['building'] ?>"/>        
    </div>  
 
  <div class="row mb-3 mx-3">
    Room:
        <input type="text" class="form-control" name="room" required value="<?php echo $event_details[0]['room'] ?>"/>        
    </div>  
 
 <div class="row mb-3 mx-3">
    Cost:
        <input type="number" class="form-control" name="cost" value="<?php echo $event_details[0]['cost'] ?>" required />        
    </div>  

    <div class="row mb-3 mx-3">
    Food:
        <input type="text" class="form-control" name="food" required value="<?php echo $event_details[0]['food'] ?>"/>        
    </div>  
    <!-- <input type="hidden" name="event_to_update" value="<?=$_GET['event_to_update']?>"> -->
    <input type="submit" value="Update" name="btnAction" class="btn btn-dark"

        title = "Update Event" />
</form>    
</div> 
</body>
</html>
