<?php
 require('connect-db.php');
 require('database_functions.php');
 require('form-variables.php');

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
        echo "got here";
        $addInfo = true;
        $addHost = true;
        $fieldName = "Additional Host: ";
        }

        if(!empty($_POST['btnAction']) && $_POST['btnAction'] == "AddAudience") {
        $addInfo = true;
        $addAudience = true;
        $fieldName = "Additional Audience: ";

        }

         if(!empty($_POST['btnAction']) && $_POST['btnAction'] == "AddCategory") {
        $addInfo = true;
        $addCategory = true;
        $fieldName = "Additional Category: ";

        }

        if(!empty($_POST['btnAction']) && $_POST['btnAction'] == "AddRestriction") {
        $addInfo = true;
        $addRestriction = true;
        $fieldName = "Additional Restriction: ";

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
    <div class="container">
        <h1>Add Event</h1>
        <div visibility: <?php if ($submitted == true) echo 'hidden'; ?>>
<form name="mainForm" action="addEventPage.php" method="post">
 

