<?php
    require $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/confi/verify_staff.php";
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $event_id=$_POST['event_id'];
        $geoJson=$_POST['geoJson']?"'".$_POST['geoJson']."'":'NULL';

        $query = "UPDATE `disaster_events` SET `geoJson`=$geoJson where event_id = $event_id";
        if(mysqli_query($con, $query)){
            echo "success";
        }
        header('location:/staff/event/view_event.php?event_id='.$event_id);
    }
?>