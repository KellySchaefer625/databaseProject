<?php
 require('connect-db.php');
 

 require('database_functions.php');

 $list_of_events = getAllEventsByDate();
 $event_details = null;
 $event_audience = null;
 $event_categories = null;
 $event_restrictions = null;
 $audience_str = '';
 $category_str = '';
 $restrictions_str = '';
 $name = '';
 $date = '';
 $start_time = '';
 $end_time  ='';
 $cost = '';
 $building = '';
 $room = '';
 $organization_name = '';

 if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   try{
      if(!empty($_POST['btnAction']) && $_POST['btnAction'] == "Exit Event Detail") {
        $event_details = null;
      }
      // else if(!empty($_POST['btnAction']) && $_POST['btnAction'] == "ShowDetails") {
      //   $event_details = getEventDetail($_POST['event_to_display']);
      //   $event_audience = getEventAudience($_POST['event_to_display']);
      //   $event_categories = getEventCategories($_POST['event_to_display']);
      //   $event_restrictions = getEventRestrictions($_POST['event_to_display']);
      // }
      else if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Sort By Event Name") {
        $list_of_events = getAllEventsByName();

      }
      else if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Sort By Organization Name") {
        $list_of_events = getAllEventsByOrg();
      }
      else if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Sort By Date") {
        $list_of_events = getAllEventsByDate();
      }
       else if(!empty($_POST['btnAction']) && $_POST['btnAction'] == "Update") {

        // $zombie_to_update = getZombie_byName($_POST['zombie_to_update']);
      }

      else if(!empty($_POST['btnAction']) && $_POST['btnAction'] == "Confirm Update" && $zombie_to_update != null) {
        updateZombie($_POST['name'], $_POST['Danger'], $_POST['Speed']); 
        $list_of_zombies = getAllZombies();
      }

      else if(!empty($_POST['btnAction']) && $_POST['btnAction'] == "DeleteEvent") {
        deleteEvent_By_ID($_POST['event_to_delete']);
        deleteHost($_POST['event_to_delete']);
        deleteEvent_audience($_POST['event_to_delete']);
        deleteEvent_categories($_POST['event_to_delete']);
        deleteEvent_restrictions($_POST['event_to_delete']);
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
</head>
<body>



<div class="container">
  <!-- <header>
    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/d/dd/University_of_Virginia_Rotunda_logo.svg/1200px-University_of_Virginia_Rotunda_logo.svg.png" class="logo floatLeft" alt="UVA Logo" width="300" height="300">
    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/d/dd/University_of_Virginia_Rotunda_logo.svg/1200px-University_of_Virginia_Rotunda_logo.svg.png" class="logo floatRight" alt="UVA Logo" width="300" height="300">
    <h1>UVA Calendar</h1>
  </header> -->
  <!-- <div class="header">
    <div class="content-right">
        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/d/dd/University_of_Virginia_Rotunda_logo.svg/1200px-University_of_Virginia_Rotunda_logo.svg.png" style="vertical-align: middle" width="300" height="300">
    </div>

    <div class="content-left">
        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/d/dd/University_of_Virginia_Rotunda_logo.svg/1200px-University_of_Virginia_Rotunda_logo.svg.png" style="vertical-align: middle" width="300" height="300">
    </div>
    <div class="content">
      <h1>UVA Calendar</h1>
    </div>
  </div> -->
  <!-- Source: https://stackoverflow.com/questions/19697585/text-between-two-image/19697666 , https://www.computerhope.com/issues/ch001968.html-->
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
  

<!--
<form name="mainForm" action="simpleform.php" method="post">   
  <div class="row mb-3 mx-3">
    Your name:
    <input type="text" class="form-control" name="name" required
    value = "<?php if ($zombie_to_update!=null) echo $zombie_to_update['name']?>" />      
  </div>  
    <div class="row mb-3 mx-3">
        Danger:
        <input type="number" class="form-control" name="Danger" required 
        value = "<?php if ($zombie_to_update!=null) echo $zombie_to_update['Danger'] ?>"/>        
    </div>  

    <div class="row mb-3 mx-3">
        Speed:
        <input type="text" class="form-control" name="Speed" required 
        value = "<?php if ($zombie_to_update!=null) echo $zombie_to_update['Speed'] ?>"/>        
    </div> 

    <input type="submit" value="Add" name="btnAction" class="btn btn-dark"

        title = "insert a zombie" />

    <input type="submit" value="Confirm Update" name="btnAction" class="btn btn-dark"

        title = "Confirm Changes" />
</form>  
/> -->


  <!-- <table class="w3-table w3-bordered w3-card-4" style="width:90%">
  <thead>
  <tr style="background-color:#b0b0b0">
  <th width="25%">Name</th>
  <th width="20%">Date of Event</th>
  <th width="25%">Host Organization</th>
  <tr>
      <td><?php echo $name; ?></td>
      <td><?php echo $date; ?></td>
      <td><?php echo $audience_str; ?></td>
  </tr>
  </table> -->
  <form action="viewEventsPage.php" method="post">
  <div class="row">
    <div class="col-auto">
        <input type="submit" value="Sort By Event Name" name="btnAction" class="btn btn-light" />
        <!-- <input type="hidden" name="event_to_display" value="<?php echo $event['event_id'] ?>" />  -->
    </div>
    <div class="col-auto">
        <input type="submit" value="Sort By Organization Name" name="btnAction" class="btn btn-light" />
        <!-- <input type="hidden" name="event_to_display" value="<?php echo $event['event_id'] ?>" />  -->
    </div>
    <div class="col-auto">
        <input type="submit" value="Sort By Date" name="btnAction" class="btn btn-light" />
        <!-- <input type="hidden" name="event_to_display" value="<?php echo $event['event_id'] ?>" />  -->
    </div>
  </div>
</form>

<!--<h2> List of Zombies </h2>/> -->
<table class="w3-table w3-bordered w3-card-4" style="width:90%">
<thead>
<tr style="background-color:#b0b0b0">
<th width="25%">Name</th>
<th width="20%">Date of Event</th>
<th width="25%">Host Organization</th>
<th width="12%">Event Details</th>
<th width="12%">Update Event</th>
<th width="12%">Delete Event</th>
<!--

<th width="12%">Delete ?</th>
/> -->
</tr>
</thead>

<?php foreach ($list_of_events as $event): ?>
<tr>
    <td><?php echo $event['name']; ?></td>
    <td><?php echo $event['date_of_event']; ?></td>
    <td><?php echo $event['org_name']; ?></td>
    <td><form action="viewEventsPage.php" method="post">
        <input type="submit" name="btnAction" value="ShowDetails" class="btn btn-primary" />
        <input type="hidden" name="event_to_display" value="<?php echo $event['event_id'] ?>" />      
      </form></td>
    <td><button class="btn btn-primary"><a href="updateEventPage.php?event_to_update=<?=$event['event_id']?>">UpdateEvent</a></button></td>
    <td><form action="viewEventsPage.php" method="post">
      <input type="submit" name="btnAction" value="DeleteEvent" class="btn btn-primary" />
      <input type="hidden" name="event_to_delete" value="<?php echo $event['event_id'] ?>" />      
    </form></td>
</tr>
 <?php endforeach; ?>

  </table>
  
</div> 
</body>
</html>