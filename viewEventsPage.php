<?php
session_start(); 
if($_SESSION["validlogin"] !== true){
  header("location: userReg.php");
  exit;
}
 require('connect-db.php');
 

 require('database_functions.php');

 $list_of_events = getAllEventsByDate();
 $list_of_orgs = getAllOrgs();
 $list_of_categories = getAllCats();
 $list_of_sub_events = getUserSubs($_SESSION['uName']);
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
      else if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Filter"){
        $list_of_events = getEventsByOrg($_POST['org_to_filter']);
      }

      else if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "<3"){
        // echo $_POST['org_to_filter'];
        // print_r($_SESSION['uName']);
        addToSub($_POST['event_to_like'],$_SESSION['uName']);
        $list_of_sub_events = getUserSubs($_SESSION['uName']);
      }

      else if (!empty($_POST['btnAction']) && $_POST['btnAction'] == ":("){
        // echo $_POST['org_to_filter'];
        // print_r($_SESSION['uName']);
        removeFromSub($_POST['event_to_unlike'],$_SESSION['uName']);
        $list_of_sub_events = getUserSubs($_SESSION['uName']);
      }

      else if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Filter "){
        $list_of_events = getEventsByCat($_POST['cat_to_filter']);
      }

      else if(!empty($_POST['btnAction']) && $_POST['btnAction'] == "Confirm Update" && $zombie_to_update != null) {
        updateZombie($_POST['name'], $_POST['Danger'], $_POST['Speed']); 
        $list_of_zombies = getAllZombies();
      }

      // else if(!empty($_POST['btnAction']) && $_POST['btnAction'] == "DeleteEvent") {
      //   // $exec_roles = getUserExecRoles($_SESSION['uName'],$_POST['event_to_delete']);
      //   // if ($exec_roles == null) {

      //   // }
      //   deleteEvent_By_ID($_POST['event_to_delete']);
      //   deleteHost($_POST['event_to_delete']);
      //   deleteEvent_audience($_POST['event_to_delete']);
      //   deleteEvent_categories($_POST['event_to_delete']);
      //   deleteEvent_restrictions($_POST['event_to_delete']);
      // }
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
    <div style="float:right;">
    <div style="float:right;">
    <form action="userProfile.php" method="post">
    <button class="btn btn-primary">User Profile</a></button>
    </form>
  </div>
<!-- <div style="float:right;">
    <form action="userProfile.php" method="post">
    <button class="btn btn-primary" class="glyphicon glyphicon-user">User Profile</a></button>
    </form>
  </div> -->
<!-- </div> -->
  <div style="float:right;">
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

  <table class="w3-table w3-bordered w3-card-4" style="width:90%">
<h2>Events you have subscribed to:</h2>
<thead>
<tr style="background-color:#b0b0b0">
<th width="25%">Name</th>
<th width="20%">Date of Event</th>
<th width="25%">Host Organization</th>
<th width="12%">Event Details</th>
<th width="12%">Update Event</th>
<th width="12%">Unlike Event</th>
<!--

<th width="12%">Delete ?</th>
/> -->
</tr>
</thead>

<?php foreach ($list_of_sub_events as $event): ?>
<tr>
    <td><?php echo $event['name']; ?></td>
    <td><?php echo $event['date_of_event']; ?></td>
    <td><form action="viewOrgDetail.php" method="post">
        <input type="submit" name="btnOrgDetails" value="<?php echo $event['org_name']; ?>" class="btn btn-link" />
        <input type="hidden" name="org_to_display" value="<?php echo $event['org_name']; ?>" />      
      </form></td>
    <td><form action="viewEventDetail.php" method="post">
        <input type="submit" name="btnAction" value="ShowDetails" class="btn btn-primary" />
        <input type="hidden" name="event_to_display" value="<?php echo $event['event_id'] ?>" />      
      </form></td>
    <td><button class="btn btn-primary"><a href="updateEventPage.php?event_to_update=<?=$event['event_id']?>" style="color: white">UpdateEvent</a></button></td>
    <!-- <td><form action="viewEventsPage.php" method="post">
      <input type="submit" name="btnAction" value="DeleteEvent" class="btn btn-primary" />
      <input type="hidden" name="event_to_delete" value="<?php echo $event['event_id'] ?>" />      
    </form></td> -->
    <td><form action="viewEventsPage.php" method="post">
        <input type="submit" name="btnAction" value=":(" class="btn btn-danger" /> 
        <input type="hidden" name="event_to_unlike" value="<?php echo $event['event_id'] ?>" />      
      </form></td>
</tr>
 <?php endforeach; ?>

  </table>
  
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

<!-- source: https://blog.hubspot.com/website/html-dropdown and https://www.w3schools.com/tags/att_option_value.asp and https://stackoverflow.com/questions/3518002/how-can-i-set-the-default-value-for-an-html-select-element-->
<form action="viewEventsPage.php" method="post">
  <label for="cat-names">Choose a category to filter on:</label>
  <select name="cat-names" id="cat-names" onChange="update2()">
    <option value="" selected disabled hidden>Choose here</option>
    <?php foreach ($list_of_categories as $cat): ?>
      <option value="<?php echo $cat['category_name'] ?>"><?php echo $cat['category_name'] ?></option>
    <?php endforeach; ?>
  </select>
  <input type="submit" name="btnAction" value='Filter '>
  <input type="hidden" name ="cat_to_filter" id="value" value="<?php $val2 ?>">
  <!-- source: https://ricardometring.com/getting-the-value-of-a-select-in-javascript -->
		<script type="text/javascript">
			function update2() {
				var select = document.getElementById('cat-names');
				var option = select.options[select.selectedIndex];

				document.getElementById('value').value = option.value;
        var val2 = option.val
			}

			update2();
		</script>
  <!-- <input type="hidden" name="org_to_filter" value=<?php $text ?>/>  -->
</form>

<form action="viewEventsPage.php" method="post">
  <label for="org-names">Choose an organization to filter on:</label>
  <select name="org-names" id="org-names" onChange="update1()">
    <option value="" selected disabled hidden>Choose here</option>
    <?php foreach ($list_of_orgs as $org): ?>
      <option value="<?php echo $org['org_name'] ?>"><?php echo $org['org_name'] ?></option>
    <?php endforeach; ?>
  </select>
  <input type="submit" name="btnAction" value='Filter'>
  <input type="hidden" name ="org_to_filter" id="value1" value="<?php $val ?>">
  <!-- source: https://ricardometring.com/getting-the-value-of-a-select-in-javascript -->
		<script type="text/javascript">
			function update1() {
				var select = document.getElementById('org-names');
				var option = select.options[select.selectedIndex];

				document.getElementById('value1').value = option.value;
        var val = option.val
			}

			update1();
		</script>
  <!-- <input type="hidden" name="org_to_filter" value=<?php $text ?>/>  -->
</form>


<!--<h2> List of Zombies </h2>/> -->
<table class="w3-table w3-bordered w3-card-4" style="width:90%">
<thead>
<tr style="background-color:#b0b0b0">
<th width="25%">Name</th>
<th width="20%">Date of Event</th>
<th width="25%">Host Organization</th>
<th width="15%">Event Details</th>
<!-- <th width="12%">Update Event</th> -->
<th width="15%">Like Event</th>
<!--

<th width="12%">Delete ?</th>
/> -->
</tr>
</thead>

<?php foreach ($list_of_events as $event): ?>
<tr>
    <td><?php echo $event['name']; ?></td>
    <td><?php echo $event['date_of_event']; ?></td>
    <!-- <td><?php echo $event['org_name']; ?></td> -->
    <td><form action="viewOrgDetail.php" method="post">
        <input type="submit" name="btnOrgDetails" value="<?php echo $event['org_name']; ?>" class="btn btn-link" />
        <input type="hidden" name="org_to_display" value="<?php echo $event['org_name']; ?>" />      
      </form></td>
    <td><form action="viewEventDetail.php" method="post">
        <input type="submit" name="btnAction" value="ShowDetails" class="btn btn-primary" />
        <input type="hidden" name="event_to_display" value="<?php echo $event['event_id'] ?>" />      
      </form></td>
    <!-- <td><button class="btn btn-primary"><a href="updateEventPage.php?event_to_update=<?=$event['event_id']?>" style="color: white">UpdateEvent</a></button></td> -->
    <!-- <td><form action="viewEventsPage.php" method="post">
      <input type="submit" name="btnAction" value="DeleteEvent" class="btn btn-primary" />
      <input type="hidden" name="event_to_delete" value="<?php echo $event['event_id'] ?>" />      
    </form></td> -->
    <td><form action="viewEventsPage.php" method="post">
        <input type="submit" name="btnAction" value="<3" class="btn btn-danger" /> 
        <input type="hidden" name="event_to_like" value="<?php echo $event['event_id'] ?>" />      
      </form></td>
</tr>
 <?php endforeach; ?>

  </table>
  
</div> 
</body>
</html>