<?php
	session_start();
	$org_db = mysqli_connect("remotemysql.com","LvFAfm4fFA","JGhOtcM4ez") or die("Unable to connect");
    mysqli_select_db($org_db,"LvFAfm4fFA");
	
	$sql="SELECT * FROM org_1 ORDER BY msg_id ASC";
	$result=$org_db->query($sql);
	if ($result->num_rows>0)
	{
		while ($row=$result->fetch_assoc())
		{
			if ($row['sender']==$_SESSION['first_name'] . ' ' . $_SESSION['last_name'])
			{
				echo"<div id='msg_box'>";
					echo
					"<div>
						<i id='mydate'>{$row['date']}</i>
						<i id='mytime'>{$row['time']}</i>
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
						<i id='date'>{$row['date']}</i>
						<i id='time'>{$row['time']}</i>
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