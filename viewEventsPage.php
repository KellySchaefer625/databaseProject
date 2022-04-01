<?php
 require('connect-db.php');
 

 require('database_functions.php');

 $list_of_events = getAllEvents();
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
      if(!empty($_POST['btnAction']) && $_POST['btnAction'] == "ShowDetails") {
        $event_details = getEventDetail($_POST['event_to_display']);
        $event_audience = getEventAudience($_POST['event_to_display']);
        $event_categories = getEventCategories($_POST['event_to_display']);
        $event_restrictions = getEventRestrictions($_POST['event_to_display']);
      }
       else if(!empty($_POST['btnAction']) && $_POST['btnAction'] == "Update") {

        $zombie_to_update = getZombie_byName($_POST['zombie_to_update']);
      }

      else if(!empty($_POST['btnAction']) && $_POST['btnAction'] == "Confirm Update" && $zombie_to_update != null) {
        updateZombie($_POST['name'], $_POST['Danger'], $_POST['Speed']); 
        $list_of_zombies = getAllZombies();
      }

      else if(!empty($_POST['btnAction']) && $_POST['btnAction'] == "Delete") {
        $zombie_to_delete = getZombie_byName($_POST['zombie_to_delete']);
        deleteZombie($zombie_to_delete['name'], $zombie_to_delete['Danger'], $zombie_to_delete['Speed']);
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

<h1>UVA Calendar</h1>
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
  </table>
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
<?php endif; ?>

<!--<h2> List of Zombies </h2>/> -->
<table class="w3-table w3-bordered w3-card-4" style="width:90%">
<thead>
<tr style="background-color:#b0b0b0">
<th width="25%">Name</th>
<th width="20%">Date of Event</th>
<th width="25%">Host Organization</th>
<th width="12%">Event Details</th>
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
        <input type="submit" value="ShowDetails" name="btnAction" class="btn btn-primary" />
        <input type="hidden" name="event_to_display" value="<?php echo $event['event_id'] ?>" />      
      </form></td>
    <!--
    <td>
     <form action="simpleform.php" method="post">
        <input type="submit" value="Delete" name="btnAction" class="btn btn-primary" />
        <input type="hidden" name="zombie_to_delete" value="<?php echo $zombie['name'] ?>" />      
      </form>
    </td>
    /> -->
</tr>
 <?php endforeach; ?>

  </table>
  
</div> 
</body>
</html>