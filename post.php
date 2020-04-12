<?php 
include ("dbconfi/confi.php");
	$name=$_POST["name"];
	$id=$_POST["id"];
	$message=$_POST["message"];
	$sql="INSERT INTO org_1 (msg_id, NIC_num, sender, message, date, time) VALUES (NULL, '$id', '$name', '$message', NOW(), NOW())";
	if($org_DB->query($sql))
	{
		echo"Message sent";
	}
	else
	{
		echo"Error";
	}
	
?>