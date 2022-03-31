<?php
 require('connect-db.php');
 

 require('database_functions.php');
 latest_event_id = getLatestEvent_ID();
 if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      if(!empty($_POST['btnAction']) && $_POST['btnAction'] == "Add") {
        addToEvent_By_ID($_POST['name'], $_POST['time_start'], $_POST['time_end'], $_POST['building'], $_POST['room'], $_POST['date_of_event'], $_POST['cost'], $_POST['food']);
        addToHost()
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

<h1>Zombie Book</h1>
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

<h2> List of Zombies </h2>
<table class="w3-table w3-bordered w3-card-4" style="width:90%">
<thead>
<tr style="background-color:#b0b0b0">
<th width="25%">Name</th>
<th width="20%">Danger</th>
<th width="25%">Speed</th>
<th width="12%">Update ?</th>
<th width="12%">Delete ?</th>
</tr>
</thead>

<?php foreach ($list_of_zombies as $zombie): ?>
<tr>
    <td><?php echo $zombie['name']; ?></td>
    <td><?php echo $zombie['Danger']; ?></td>
    <td><?php echo $zombie['Speed']; ?></td>
    <td>
    <form action="simpleform.php" method="post">
        <input type="submit" value="Update" name="btnAction"
            class="btn btn-primary" />
        <input type="hidden" name="zombie_to_update"
            value="<?php echo $zombie['name'] ?>" />
    </form>
    </td>
    <td>
     <form action="simpleform.php" method="post">
        <input type="submit" value="Delete" name="btnAction" class="btn btn-primary" />
        <input type="hidden" name="zombie_to_delete" value="<?php echo $zombie['name'] ?>" />      
      </form>
    </td>
</tr>
 <?php endforeach; ?>

  </table>
  
</div> 
</body>
</html>
