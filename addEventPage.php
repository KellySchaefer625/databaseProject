<?php
session_start(); 
if($_SESSION["validlogin"] !== true){
  header("location: login.php");
  exit;
 }
 require('connect-db.php');
 require('database_functions.php');

 $latest_event_id = null;
 $submitted = false;
 $addInfo = false;
  $addType = '';
  $fieldName = '';
  if(isset($_POST["import"])){
    $fileName = $_FILES["file"]["tmp_name"];
     if(($_FILES["file"]["size"] > 0)){
      $file = fopen($fileName, "r");
       while(($data = fgetcsv($file, 1000, ","))!==FALSE){
         for($c=0;$c<12;$c++){
          $arr[$c] = $data[$c];
          //echo $arr[$c] . "<br />\n";
         }
       }
       
       
  
      $name = $arr[0];
      $time_start = $arr[1];
      $time_end = $arr[2];
      $building = $arr[3];
      $room = $arr[4];
      $date_of_event = $arr[5];
      $cost = $arr[6];
      $food = $arr[7];
      $org_name = $arr[8];
      $audience = $arr[9];
      $categories = $arr[10];
      $restrictions = $arr[11];
      $latest_event_id = getLatestEventId();
       addToEvent_By_ID($name, $time_start, $time_end, $building, $room, $date_of_event, $cost, $food);
          addToHost($org_name, $latest_event_id);
          addToEvent_audience($latest_event_id,$audience);
          addToEvent_categories($latest_event_id,$categories);
          addToEvent_restrictions($latest_event_id,$restrictions);
  
     }
   }
 if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   try{
 
      if(!empty($_POST['btnAction']) && $_POST['btnAction'] == "Add") {
        $temp_event_id = getLatestEventId();
        foreach ($temp_event_id as $id_num) {
         $latest_event_id = $id_num;      
        }
        $latest_event_id = $latest_event_id+1;
        addToEvent_By_ID($_POST['name'], $_POST['time_start'], $_POST['time_end'], $_POST['building'], $_POST['room'], $_POST['date_of_event'], $_POST['cost'], $_POST['food']);
        addToHost($_POST['org_name'], $latest_event_id);
        addToEvent_audience($latest_event_id,$_POST['audience']);
        addToEvent_categories($latest_event_id,$_POST['categories']);
        addToEvent_restrictions($latest_event_id,$_POST['restrictions']);
        $submitted = true;
    
      }

        if(!empty($_POST['btnAction']) && $_POST['btnAction'] == "AddHost") {
        $addInfo = true;
        $addType = "Host";
        $fieldName = "Additional Host: ";
        $submitted = true;
        }

        if(!empty($_POST['btnAction']) && $_POST['btnAction'] == "AddAudience") {
        $addInfo = true;
        $addType = "Audience";
        $fieldName = "Additional Audience: ";
        $submitted = true;
  
        }

         if(!empty($_POST['btnAction']) && $_POST['btnAction'] == "AddCategory") {
        $addInfo = true;
        $addType = "Category";
        $fieldName = "Additional Category: ";
        $submitted = true;
        }

        if(!empty($_POST['btnAction']) && $_POST['btnAction'] == "AddRestriction") {
        $addInfo = true;
        $addType = "Restriction";
        $fieldName = "Additional Restriction: ";
        $submitted = true;
        }

       if(!empty($_POST['btnAction']) && $_POST['btnAction'] == "newAdd") {
        $addType = $_POST['addType'];
        $temp_event_id = getLatestEventId();
        foreach ($temp_event_id as $id_num) {
         $latest_event_id = $id_num;      
         }
        $addInfo = false;
        $submitted = true;
        if($addType == "Host") {
          addToHost($_POST['additionalInput'], $latest_event_id);
          $addType = "";
   
        }
        if($addType == 'Audience') {
          addToEvent_audience($latest_event_id,$_POST['additionalInput']);
          $addType = '';
        }
        if($addType == 'Category') {
          addToEvent_categories($latest_event_id,$_POST['additionalInput']);
          $addType = '';
       }
       if($addType == 'Restriction') {
          addToEvent_restrictions($latest_event_id,$_POST['additionalInput']);
          $addType= '';
        }
  
        }

      }
  
      

    catch(Exception $except){
      throw new Exception("Error adding event page");
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
    <meta name="description" content="This is a subpage to add events to the UVA calendar page">

    <title>Add Event Page</title>
   
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
<header>
    <div style="float:right;">
    <form action="logoutUser.php" method="post">
    <button class="btn btn-primary">Logout</a></button>
    </form>
    </div>
</header>
<form class="form-horizontal" action="" method="post"
                name="frmCSVImport" id="frmCSVImport"
                enctype="multipart/form-data">
                <div class="input-row">
                    <label class="col-md-4 control-label">Choose CSV
                        File</label> <input type="file" name="file"
                        id="file" accept=".csv">
                    <button type="submit" id="submit" name="import"
                        class="btn-submit">Import</button>
                    <br />

                </div>

            </form>

<div class="container">
<h1>Add Event</h1>
<div visibility: <?php if ($submitted == true) echo 'hidden'; ?>>
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
    <input type="date" class="form-control" name="date_of_event" required />        
 </div> 

  <div class="row mb-3 mx-3">
    Event Categories: 
       <input type="text" class="form-control" name="categories" required/>
  </div> 
 
  <div class="row mb-3 mx-3">
    Event Audience:
    <input type="text" class="form-control" name="audience" required />      
  </div>

  <div class="row mb-3 mx-3">
    Event Details:
    <input type="text" class="form-control" name="details" required/>      
  </div>

    <div class="row mb-3 mx-3">
    Start Time:
        <input type="time" class="form-control" name="time_start" required />        
    </div>  
 
   <div class="row mb-3 mx-3">
    End Time:
        <input type="time" class="form-control" name="time_end"  required/>        
    </div>  
 
  <div class="row mb-3 mx-3">
    Building:
        <input type="text" class="form-control" name="building" required/>        
    </div>  
 
  <div class="row mb-3 mx-3">
    Room:
        <input type="text" class="form-control" name="room" required  />        
    </div>  
 
 <div class="row mb-3 mx-3">
    Cost:
        <input type="number" class="form-control" name="cost" required/>        
    </div>
 
 <div class="row mb-3 mx-3">
    Food?
        <input type="text" class="form-control" name="food" required />         
    </div>  
 
 <div class="row mb-3 mx-3">
    Restrictions
        <input type="text" class="form-control" name="restrictions" required/>
 </div>
       
    <input type="submit" value="Add" name="btnAction" class="btn btn-dark"
        title = "Add Event" />
  </div>
  </form>

  <form name="subForm" action="addEventPage.php" method="post">
  <div visibility: <?php if ($submitted == false || $addInfo == true) echo 'hidden'; ?>>
  <div class="row mb-3 mx-3">
  <button type="submit" value="AddHost" name="btnAction" class="btn btn-dark btn-block"
        title = "Add Additional Host?" /> Add Additional Host </button>
  </div>
  </div>

    <div class="row mb-3 mx-3">
                 &nbsp
  </div>

  <div class="row mb-3 mx-3">
  <div visibility: <?php if ($submitted == false || $addInfo == true) echo 'hidden'; ?>>
  <button type="submit" value="AddCategory" name="btnAction" class="btn btn-dark btn-block"
        title = "Add Additional Category?"/> Add Additional Category </button>
  </div>
  </div>

  
  <div class="row mb-3 mx-3">
                 &nbsp
  </div>

  <div class="row mb-3 mx-3">
  <div visibility: <?php if ($submitted == false || $addInfo == true) echo 'hidden'; ?>>
  <button type="submit" value="AddAudience" name="btnAction" class="btn btn-dark btn-block"
        title = "Add Additional Audience?" />Add Additional Audience </button>
  </div>
  </div>

    <div class="row mb-3 mx-3">
                 &nbsp
  </div>


  <div class="row mb-3 mx-3">
  <div visibility: <?php if ($submitted == false || $addInfo == true) echo 'hidden'; ?>>
  <button type="submit" value="AddRestriction" name="btnAction" class="btn btn-dark btn-block"
        title = "Add Additional Event Restriction" /> Add Addditional Event Restriction </button>
  </div>
  </div>

    <div class="row mb-3 mx-3">
                 &nbsp
  </div>
  
  <div class="row mb-3 mx-3">
  <div visibility: <?php if ($submitted == false || $addInfo == true) echo 'hidden'; ?>>
  <button type="submit" value="AddCategory" name="btnAction" class="btn btn-dark btn-block"
        title = "Add Additional Category?"/> Add Additional Category </button>
  </div>
  </div>

  <div class="row mb-3 mx-3">
  <div visibility: <?php if ($addInfo == false) echo 'hidden'; ?>>
  <?php echo $fieldName ?>
  <input type="text" class="form-control" name="additionalInput"  />
     <div class="row mb-3 mx-3">
                 &nbsp
  </div>
  <div> 
  <input type="hidden" id="addType" name="addType" value=<?php echo $addType; ?> >
  </div>
   <button type="submit" value="newAdd" name="btnAction" class="btn btn-dark"
        title = "Add Info" /> Add To Event </button>
  </div>
  </div>
 

    <div class="row mb-3 mx-3">
                 &nbsp
  </div>


   <div visibility: <?php if ($submitted == false || $addInfo == true) echo 'hidden'; ?>>
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
