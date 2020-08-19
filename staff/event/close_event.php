<?php  
    require_once $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/confi/verify_staff.php";
?>

<?php
    $query="";
    $current_date=date("Y-m-d");
    $status="closed";
    $query.="update disaster_events set status='".$status."',end_date='".$current_date."' where event_id=".$_GET['close'].";";
    $query.="DROP TABLE event_".$_GET['close']."_volunteers,event_".$_GET['close']."_requests,event_".$_GET['close']."_pro_don_content,event_".$_GET['close']."_pro_don,event_".$_GET['close']."_locations,event_".$_GET['close']."_help_requested,event_".$_GET['close']."_abilities;";

    $query_run= mysqli_multi_query($con,$query);
    if($query_run){
        header("location:".$_SERVER['HTTP_REFERER']);
    }  
?>