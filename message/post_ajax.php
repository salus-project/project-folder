<?php 
    $notification_DB = mysqli_connect("remotemysql.com","LlvvpTpgPp","t6rKpohvCB") or die("Unable to connect");
	mysqli_select_db($notification_DB,"LlvvpTpgPp");
	
	date_default_timezone_set("Asia/Colombo");
	
	$time= date("H:i:s");
	$date= date("Y-m-d");
	$timedate=$date." ".$time;
	$to_person=$_POST["to_person"];
	$id=$_POST["id"];
	$message=$_POST["message"];

	$table_1='user_message_'.$id;
	$table_2='user_message_'.$to_person;
	$sql="INSERT INTO $table_1 ( `from`,`to`, `time`,`content`) VALUES (NUll,'$to_person','$timedate' ,'$message');INSERT INTO $table_2 ( `from`,`to`, `time`, `content`) VALUES ('$id',NUll,'$timedate' , '$message');";
	if($notification_DB -> multi_query($sql))
	{
		echo"Message sent";
		mysqli_close($notification_DB);
	}
	else
	{
		echo"Error";
		mysqli_close($notification_DB);
	}
	
?>