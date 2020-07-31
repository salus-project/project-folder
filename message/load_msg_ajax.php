<?php		
	$notification_DB = mysqli_connect("remotemysql.com","LlvvpTpgPp","t6rKpohvCB") or die("Unable to connect");
	mysqli_select_db($notification_DB,"LlvvpTpgPp");

	$sql=$_GET['sql'];
	$result=$notification_DB->multi_query($sql);
	$sql_res=mysqli_store_result($notification_DB);
	$result1=$sql_res->fetch_all(MYSQLI_ASSOC);
	mysqli_free_result($sql_res);

	mysqli_next_result($notification_DB);
	$sql_res=mysqli_store_result($notification_DB);
	$result2=$sql_res->fetch_all(MYSQLI_ASSOC);
	mysqli_free_result($sql_res);

	
	
	echo json_encode(array("ads"=>$result1,"adsf"=>$result2));
	//echo $notification_DB -> error;
	mysqli_close($notification_DB);
	
?>
