<?php

	session_start();
	$org_db = mysqli_connect("remotemysql.com","LvFAfm4fFA","JGhOtcM4ez") or die("Unable to connect");
    mysqli_select_db($org_db,"LvFAfm4fFA");
	
	$dat=null;
	
	$org_id=$_GET["org_id"];
	$sql="SELECT * FROM $org_id ORDER BY msg_id ASC";
	$result=$org_db->query($sql);
	
	date_default_timezone_set("Asia/Colombo");
	$tdate= date("Y-m-d");
	
	if ($result->num_rows>0)
	{
		while ($row=$result->fetch_assoc())
		{	
			$time=date("h:i:sa ", strtotime($row['time']));
			$rowdate=date("Y M d ", strtotime($row['date']));
			
			if (($row['date']==$tdate) && ($dat !=$row['date'])){
				echo "<div id='pdate'>Today</div>";
				$dat=$row['date'];
			}
			elseif ($dat==null){
				echo "<div id='pdate'>{$rowdate}</div>";
				$dat=$row['date'];
			}
			else{
				if($dat !=$row['date']){
					echo "<div id='pdate'>{$rowdate}</div>";
					$dat=$row['date'];
				}
			}
					
			if ($row['sender']==$_SESSION['first_name'] . ' ' . $_SESSION['last_name'])
			{
				echo"<div id='msg_box'>";
					echo
					"<div>
						<i id='mytime'>{$time}</i> 
						<br>
						<div id='mymsg'>{$row['message']}</div>
					</div>";
				echo "</div>";
				echo"<br>";
			}
			else
			{
				echo"<div id='msg_box'>";
					echo
					"<div>
						<b id='sender'>{$row['sender']}</b>
						<i id='time'>{$time}</i>
						<br>
						<span id='msg'>{$row['message']}</span>
					</div>";
				echo "</div>";
				echo"<br>";
			}
		}
	mysqli_close($org_db);
	}
	else
	{
		echo "<p>No chat yet....</p>";
	}