<?php
    require $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";
    require $_SERVER['DOCUMENT_ROOT']."/confi/verify.php";

    $notification_DB = NotificationDb::getConnection();

    $user_nic=$_SESSION['user_nic'];
    $sql="SELECT * FROM user_notif_ic_$user_nic ORDER BY Notification_id DESC";
    $data=mysqli_query($notification_DB,$sql);

    date_default_timezone_set("Asia/Colombo");
    $current_date= date("Y-m-d");
?>

<link rel="stylesheet" href="/css_codes/notification.css">
<div id='event_overlay' onclick='remove(this)'></div>
<?php
    if($data->num_rows>0){
        echo"<div id='header_notif'>
            <div class='notif_table_con'>
                <table id='notif_header_table'>";
                echo "<div class=view_all>NOTIFICATION</div><button class='notif_setting_btn' type=button><i class='fa fa-cog'  aria-hidden='true'></i></button>";
                echo "<div class='hidden_notif_div'>
                        <button type=button class='notif_name view_all_btn' name='event_id' onclick='notification_mark_all()'>Mark All As Read</button>
                    </div>";
                
        while($row=$data->fetch_assoc()) {

            $rowtime = date("h:i:s a ", strtotime($row['Time']));
            $rowdate = date("Y M d ", strtotime($row['Date']));


            echo "<tr><td class='notif_td header_{$row['status']}'><a class='notif_a' href='{$row['link']}' onclick='notification_click(\"{$row['status']}\",{$row['Notification_id']})'><div class='notif_header_box'>";
            echo
            "<div class='header_content'><p>
                            {$row['Content']}
                        </p></div>";
            echo
            "<div class='header_datetime'>";
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
            </div>
        </div>";
    }
?>