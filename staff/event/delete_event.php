<?php  
    require_once $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/confi/verify_staff.php";

    $query="";

    if ($_GET['del']=="1"){
        $query.="delete from disaster_events where event_id = ".$_GET['delete'].";";
        $query.="DROP TABLE event_".$_GET['delete']."_volunteers,event_".$_GET['delete']."_requests,event_".$_GET['delete']."_pro_don_content,event_".$_GET['delete']."_pro_don,event_".$_GET['delete']."_locations,event_".$_GET['delete']."_help_requested,event_".$_GET['delete']."_abilities;";
    }else if  ($_GET['del']=="0"){
        $query.="delete from disaster_events where event_id = ".$_GET['delete'].";";
    }

    $query_run= mysqli_multi_query($con,$query);
    if($query_run){
        header('location:/staff/event/');
    }  
?>

