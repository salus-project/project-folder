<?php

	session_start();
	$org_db = mysqli_connect("remotemysql.com","LvFAfm4fFA","JGhOtcM4ez") or die("Unable to connect");
    mysqli_select_db($org_db,"LvFAfm4fFA");
	
	$dat=null;
	
	$org_id=$_GET["org_id"];
	$sql="SELECT * FROM $org_id ORDER BY msg_id DESC";
	$result=$org_db->query($sql);
	
	date_default_timezone_set("Asia/Colombo");
	$tdate= date("Y-m-d");
	$date_= date("Y-m-d");
	if ($result->num_rows>0)
	{
		while ($row=$result->fetch_assoc())
		{	
			$time=date("h:i:sa ", strtotime($row['time']));
			$rowdate=date("Y M d ", strtotime($row['date']));
			

			if ($date_ !=$row['date']){
				if($date_==$tdate){
					echo "<div id='pdate'>Today</div>";
				}
				else{
					echo "<div id='pdate'>{$date_}</div>";
				}
				$date_ =$row['date'];
			}
					
			if ($row['sender']==$_SESSION['first_name'] . ' ' . $_SESSION['last_name'])
			{
				echo"<div class='in_msg_box' id='msg_box'>";
					echo
					"<div>
						<div id='mymsg'>".$row['message']."</div>
						<div class='in_time_box'>
							<i id='mytime'>".$time."</i> 
						</div>
					</div>";
				echo "</div>";
			}
			else
			{
				echo"<div class='out_msg_box' id='msg_box'>";
					echo
					"<div>
						<div id='sender'>".$row['sender']."</div>
						<div id='msg'>".$row['message']."</div>
						<div class='out_time_box'>
							<i id='time'>{$time}</i>
						</div>
					</div>";
				echo "</div>";
			}
		}
	mysqli_close($org_db);
	}
	else
	{
		echo "<p>No chat yet....</p>";
	}
?>