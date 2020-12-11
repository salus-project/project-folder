<?php
    require $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";
    require $_SERVER['DOCUMENT_ROOT']."/confi/verify.php";

    $user_nic=$_SESSION['user_nic'];
    $sql="SELECT * FROM user_notif_ic_$user_nic ORDER BY Notification_id ASC";
    $data=mysqli_query($notification_DB,$sql);

    date_default_timezone_set("Asia/Colombo");
    $current_date= date("Y-m-d");
?>

<link rel="stylesheet" href="/css_codes/notification.css">
<div id='event_overlay' onclick='remove(this)'></div>
<?php
    if($data->num_rows>0){
        echo"<div id='notif'>
                <table id='notif_table'>";
        while($row=$data->fetch_assoc()) {

            $rowtime = date("h:i:s a ", strtotime($row['Time']));
            $rowdate = date("Y M d ", strtotime($row['Date']));


            echo "<tr><td class='{$row['status']}'><a class='notif_a' href='{$row['link']}' onclick='notification_click(\"{$row['status']}\",{$row['Notification_id']})'><div class='notif_box'>";
            echo
            "<div class='content'>
                            {$row['Content']}
                        </div>";
            echo
            "<div class='datetime'>";
            if ($row['Date'] == $current_date) {
                echo " Today at ";
            } else {
                echo $rowdate;
            }
            echo "{$rowtime}
                        </div>";
            echo "</div>";

            echo "</div></a></td></tr>";
        }

        echo    "</table>
            </div>";
    }
?>
