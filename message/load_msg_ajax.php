<?php		
	$notification_DB = mysqli_connect("remotemysql.com","LlvvpTpgPp","t6rKpohvCB") or die("Unable to connect");
	mysqli_select_db($notification_DB,"LlvvpTpgPp");

	$sql=$_GET['sql'];
	$result=$notification_DB->multi_query($sql);
	$sql_res=mysqli_store_result($notification_DB);

	$result1=$sql_res->fetch_all(MYSQLI_ASSOC);
	
	echo json_encode($result1);
	
	// date_default_timezone_set("Asia/Colombo");
	// $tdate= date("Y M d ");
	
	// if ($result->num_rows>0){
		// while ($row=$result->fetch_assoc()){	
		// 	//echo $row['content'];
	 	// 	$time=date("h:i:sa ", strtotime($row['time']));
		// 	$date=date("Y M d ", strtotime($row['time']));
		// 	if ($date==$tdate){
		// 		$date="Today";
		// 	}
			
		// 	if ($row['from']==null){
		// 		echo"<div id='msg_box'>";
		// 			echo
		// 			"<div>
		// 				<i id='mytime'>{$time}</i> 
		// 				<br>
		// 				<div id='mymsg'>{$row['content']}</div>
		// 			</div>";
		// 		echo "</div>";
		// 		echo"<br>";
		// 	}
		// 	else
		// 	{
		// 		echo"<div id='msg_box'>";
		// 			echo
		// 			"<div>
		// 				<i id='time'>{$time}</i>
		// 				<br>
		// 				<span id='msg'>{$row['content']}</span>
		// 			</div>";
		// 		echo "</div>";
		// 		echo"<br>";
		// 	}
	 	// }
	//  mysqli_close($notification_DB);
	// }
	// else{
	//  	echo "<p>No chat yet....</p>";
	// }
?>
