<?php
    session_start();
    require 'dbconfi/confi.php';

    $user_nic=$_SESSION['user_nic'];
    $sql="SELECT * FROM user_notif_ic_$user_nic ORDER BY Notification_id ASC";
    $data=mysqli_query($notification_DB,$sql);

    date_default_timezone_set("Asia/Colombo");
	$current_date= date("Y-m-d");
    
    if($data->num_rows>0){
        echo"<div id='notif'>";
        while($row=$data->fetch_assoc()){
            
            $rowtime=date("h:i:sa ",strtotime($row['Time']));
            $rowdate=date("Y M d ", strtotime($row['Date']));

            if ($row['Date']==$current_date){
                
                echo"<div id='notif_box'>";
					echo
					"<div id='content'>
						<b >{$row['Content']}</b>
                    </div>";
                    echo
                    "<div id='datetime'> Today at {$row['Time']}
                    </div>";
				echo "</div>";
				echo"<br>";
            }
            else {
                echo"<div id='notif_box'>";
					echo
					"<div id='content'>
						<b >{$row['Content']}</b>
                    </div>";
                    echo
                    "<div id='datetime'> {$row['Date']}.' at '.{$row['Time']}
                    </div>";
				echo "</div>";
				echo"<br>";
            }
           
        }
        echo"</div>";
        mysqli_close($notification_DB);
    }
?>
<!DOCTYPE html>
<head>
    <link rel="stylesheet" href="css_codes/notification.css">
</head>
</html>