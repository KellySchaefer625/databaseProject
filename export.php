<?php
session_start(); 
if($_SESSION["validlogin"] !== true){
  header("location: login.php");
  exit;
}
 require('connect-db.php');
 require('database_functions.php');
 header('Content-type: application/csv');
// Set the file name option to a filename of your choice.
header('Content-Disposition: attachment; filename=myCSV.csv');
// Set the encoding
header("Content-Transfer-Encoding: UTF-8");

 $event_details = getEventDetail($_POST['event_to_export']);
 $output = fopen('php://output','w');
 fputcsv($output, $event_details);
 fclose($output);

 


 ?>
 
  
  
