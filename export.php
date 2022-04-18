<?php
session_start(); 
if($_SESSION["validlogin"] !== true){
  header("location: login.php");
  exit;
}
 require('connect-db.php');
 require('database_functions.php');
 header('Content-Type: text/csv; charset=utf-8');
 header('Content-Disposition: attachment; filename=eventDetails.csv');

 $fields = array('ID','Name','start','end','building','room','date','cost','food','host'); 

 $event_details = getEventDetail($_POST['event_to_export']);
 $condensed_arr = array();
 $i = 0;
  foreach($event_details[0] as $key => $value){
      if($i%2 == 0){
          $condensed_arr[$key] = $value;
      }
      $i++;
  }
 $output = fopen('php://output','w');
 fputcsv($output,$fields);
 fputcsv($output, $condensed_arr);
 fclose($output);
 


 ?>
 
  
  
