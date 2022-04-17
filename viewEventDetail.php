<?php
session_start(); 
if($_SESSION["validlogin"] !== true){
  header("location: login.php");
  exit;
}
 require('connect-db.php');
 

 require('database_functions.php');

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
 $eventId = '';

 if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   try{
      if(!empty($_POST['btnAction']) && $_POST['btnAction'] == "DeleteEvent") {
        print_r($_POST['event_to_delete']);
        deleteHost($_POST['event_to_delete']);
        deleteEvent_audience($_POST['event_to_delete']);
        deleteEvent_categories($_POST['event_to_delete']);
        deleteEvent_restrictions($_POST['event_to_delete']);
        deleteEvent_subscriptions($_POST['event_to_delete']);
        deleteEvent_By_ID($_POST['event_to_delete']);
        header("location: viewEventsPage.php");
      }
    else {
      $event_details = getEventDetail($_POST['event_to_display']);
      $event_audience = getEventAudience($_POST['event_to_display']);
      $event_categories = getEventCategories($_POST['event_to_display']);
      $event_restrictions = getEventRestrictions($_POST['event_to_display']);
      $exec_roles = getUserExecRoles($_SESSION['uName'],$_POST['event_to_display']);
    }
     }

    catch(Exception $except){
      throw new Exception("Error loading event detail page");
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
    <form action="logoutUser.php" method="post">
      <button class="btn btn-primary">Logout</a></button>
    </form>
    </div>
</header>
<?php if ($event_audience!=null):?>
  <?php foreach ($event_audience as $event_a): ?>
    <?php $audience_str.=$event_a['audience_type']; ?>
    <?php $audience_str.=', '; ?>
  <?php endforeach; ?>
  <?php endif; ?>

  <?php if ($event_categories!=null):?>
  <?php foreach ($event_categories as $event_c): ?>
    <?php $category_str.=$event_c['category_name']; ?>
    <?php $category_str.=', '; ?>
  <?php endforeach; ?>
  <?php endif; ?>

  <?php if ($event_restrictions!=null):?>
  <?php foreach ($event_restrictions as $event_r): ?>
    <?php $restrictions_str.=$event_r['restrictions']; ?>
    <?php $restrictions_str.=', '; ?>
  <?php endforeach; ?>
  <?php endif; ?>

  <?php if ($event_details!=null):?>
  <?php foreach ($event_details as $event_d): ?>
    <?php $name=$event_d['name']; ?>
    <?php $date=$event_d['date_of_event']; ?>
    <?php $start_time=$event_d['time_start']; ?>
    <?php $end_time=$event_d['time_end']; ?>
    <?php $cost=$event_d['cost']; ?>
    <?php $building=$event_d['building']; ?>
    <?php $room=$event_d['room']; ?>
    <?php $organization_name=$event_d['org_name']; ?>
    <?php $eventId=$event_d['event_id']; ?>
  <?php endforeach; ?>
  <?php endif; ?>
<?php if ($event_details!=null):?>
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
        <td><?php echo $name?></td>
      </tr>
  </tbody>
  <tbody>
      <tr>
        <th scope="row">Host Organization</th>
        <td><?php echo $organization_name?></td>
      </tr>
  </tbody>
  <tbody>
      <tr>
        <th scope="row">Date</th>
        <td><?php echo $date?></td>
      </tr>
  </tbody>
  <tbody>
      <tr>
        <th scope="row">Start Time</th>
        <td><?php echo $start_time?></td>
      </tr>
  </tbody>
  <tbody>
      <tr>
        <th scope="row">End Time</th>
        <td><?php echo $end_time?></td>
      </tr>
  </tbody>
  <tbody>
      <tr>
        <th scope="row">Building</th>
        <td><?php echo $building?></td>
      </tr>
  </tbody>
  <tbody>
      <tr>
        <th scope="row">Room</th>
        <td><?php echo $room?></td>
      </tr>
  </tbody>
  <tbody>
      <tr>
        <th scope="row">Cost</th>
        <td><?php echo $cost?></td>
      </tr>
  </tbody>
  <tbody>
      <tr>
        <th scope="row">Categories</th>
        <td><?php echo $category_str?></td>
      </tr>
  </tbody>
  <tbody>
      <tr>
        <th scope="row">Restricitons</th>
        <td><?php echo $restrictions_str?></td>
      </tr>
  </tbody>
  <tbody>
      <tr>
        <th scope="row">Audience Type</th>
        <td><?php echo $audience_str?></td>
      </tr>
  </tbody>
  <tbody>
      <tr>
        <th scope="row">Event ID</th>
        <td><?php echo $eventId?></td>
      </tr>
  </tbody>
  <tbody>
 <?php if ($exec_roles==null):?>
    <tr>
        <th scope="row">Delete Event</th>
        <td>You do not have permission to delete this event</td>
      </tr>
  <?php endif; ?>
 </tbody>
 <tbody>
  <?php if ($exec_roles!=null):?>
    <td><form action="viewEventDetail.php" method="post">
      <input type="submit" name="btnAction" value="DeleteEvent" class="btn btn-primary" />
      <input type="hidden" name="event_to_delete" value=<?php echo $eventId?> />      
    </form></td>
  <?php endif; ?>
  </tbody>
  <tbody>
      <tr>
        <th scope="row">Exit</th>
        <td><a href="viewEventsPage.php">Return to Full Events List</a></td>
      </tr>
 </tbody>
  </table>
  <?php endif; ?>
</body>
</html>
