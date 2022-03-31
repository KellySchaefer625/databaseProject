<?php
 require('connect-db.php');
 

 require('database_functions.php');
 $latest_event_id = null;

 if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      if(!empty($_POST['btnAction']) && $_POST['btnAction'] == "Add") {
        $latest_event_id = getLatestEventId();
        addToEvent_By_ID($_POST['name'], $_POST['time_start'], $_POST['time_end'], $_POST['building'], $_POST['room'], $_POST['date_of_event'], $_POST['cost'], $_POST['food']);
        addToHost($_POST['org_name'], $latest_event_id);
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
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css"> -->

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
echo $latest_event_id;
<h1>Add Event</h1>
<form name="mainForm" action="addEventPage.php" method="post">   
  <div class="row mb-3 mx-3">
    Event Name:
    <input type="text" class="form-control" name="name" required />      
  </div>  
 
  <div class="row mb-3 mx-3">
    Event Host:
        <input type="text" class="form-control" name="org_name" required />        
    </div>  
 
  <div class="row mb-3 mx-3">
    Event Date:
        <input type="date" class="form-control" name="date_of_event"  />        
    </div>  
 
    <div class="row mb-3 mx-3">
    Start Time:
        <input type="time" class="form-control" name="time_start"  />        
    </div>  
 
   <div class="row mb-3 mx-3">
    End Time:
        <input type="time" class="form-control" name="time_end"  />        
    </div>  
 
  <div class="row mb-3 mx-3">
    Building:
        <input type="text" class="form-control" name="building" required />        
    </div>  
 
  <div class="row mb-3 mx-3">
    Room:
        <input type="text" class="form-control" name="room" required />        
    </div>  
 
 <div class="row mb-3 mx-3">
    Cost:
        <input type="int" class="form-control" name="cost" required />        
    </div>  
 
 <div class="row mb-3 mx-3">
    Food?
        <input type="text" class="form-control" name="food" required />        
    </div>  

    <input type="submit" value="Add" name="btnAction" class="btn btn-dark"

        title = "Add Event" />
</form>    
</div> 
</body>
</html>
