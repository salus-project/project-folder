<?php

	session_start();
	$org_db = mysqli_connect("remotemysql.com","LvFAfm4fFA","JGhOtcM4ez") or die("Unable to connect");
    mysqli_select_db($org_db,"LvFAfm4fFA");
	
	$org_id=$_GET["org_id"];
	$sql="SELECT * FROM $org_id ORDER BY msg_id ASC";
	$result=$org_db->query($sql);
	if ($result->num_rows>0)
	{
		while ($row=$result->fetch_assoc())
		{
			$date=date("d M Y ", strtotime($row['date']));
			$time=date("H:i:s ", strtotime($row['time']));
			if ($row['sender']==$_SESSION['first_name'] . ' ' . $_SESSION['last_name'])
			{
				echo"<div id='msg_box'>";
					echo
					"<div>
						<i id='mydate'>{$time}</i> 
						<i id='mytime'>{$date}</i>
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
						<i id='date'>{$time}</i>
						<i id='time'>{$date}</i>
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