<?php
require $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";
require $_SERVER['DOCUMENT_ROOT']."/confi/verify.php"; 

$location_id= $_GET['location_id'];
$event_id=$_GET['event_id'];
$location_table="event_".$event_id."_locations";

$sql = "DELETE FROM $location_table WHERE id=$location_id";
$con->query($sql); 

header("location:".$_SERVER['HTTP_REFERER']);
?>