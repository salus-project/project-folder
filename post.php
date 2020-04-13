<?php 
	$org_DB = mysqli_connect("remotemysql.com","LvFAfm4fFA","JGhOtcM4ez") or die("Unable to connect");
    mysqli_select_db($org_DB,"LvFAfm4fFA");
	
	$name=$_POST["name"];
	$id=$_POST["id"];
	$message=$_POST["message"];
	$org_id=$_POST["org_id"];
	$sql="INSERT INTO `$org_id` (`msg_id`, `NIC_num`, `sender`, `message`, `date`, `time`) VALUES (NULL, '$id', '$name', '$message', NOW(), NOW());";
	if($org_DB->query($sql))
	{
		echo"Message sent";
		mysqli_close($org_DB);
	}
	else
	{
		echo"Error";
		mysqli_close($org_DB);
	}
	
?>