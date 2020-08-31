<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/confi/verify_staff.php";

    $nic= $_GET['nic'];
    $query="";

    $query_event="select event_id from disaster_events where status='active'";
    $result=$con->query($query_event);

    //delete event tables details
    while($row=$result->fetch_assoc()){
        $event_id=$row['event_id'];
        $query.="delete from `event_".$event_id."_locations` where by_person = '".$nic."';";

        $query.="delete from `event_".$event_id."_pro_don_content` where don_id in(select id 
        from `event_".$event_id."_pro_don` WHERE by_person ='".$nic."' or to_person ='".$nic."');";
        $query.="delete from `event_".$event_id."_pro_don` where by_person ='".$nic."' or to_person = '".$nic."';";

        $query.="delete from `event_".$event_id."_abilities` where donor = '".$nic."';";
        $query.="delete from `event_".$event_id."_volunteers` where NIC_num = '".$nic."';";

        $query.="delete from `event_".$event_id."_requests` where requester = '".$nic."';";
        $query.="delete from `event_".$event_id."_help_requested` where NIC_num = '".$nic."';";

    }

    //delete org members
    $query.="delete from org_members where NIC_num = '".$nic."';";

    //deleting rows in public post tables
    $query.="delete from public_post_comments where author = '".$nic."';";
    $query.="delete from public_posts where author = '".$nic."';";
    $query.="delete from public_posts where fund in(select id 
    from fundraisings WHERE by_civilian ='".$nic."');";

    //delete fundraising pro don and contents
    $query.="delete from fundraising_pro_don_content where don_id in((select id 
    from fundraising_pro_don WHERE by_person ='".$nic."'),(select id 
    from fundraising_pro_don WHERE for_fund in (select id 
    from fundraisings WHERE by_civilian ='".$nic."')));";
    $query.="delete from fundraising_pro_don where by_person = '".$nic."';";

    //delete fundraising and expects
    $query.="delete from fundraisings_expects where fund_id in(select id 
    from fundraisings WHERE by_civilian ='".$nic."');";
    $query.="delete from fundraisings where by_civilian = '".$nic."';";

    //finally delete column in disaster events, civilian table
    $query.="alter table disaster_events drop column `user_".$nic."`;";
    $query.="delete from civilian_detail where NIC_num = '".$nic."';";

    $query_run= mysqli_multi_query($con,$query);

    $query_noti="";
    $query_noti.="drop table `user_message_".$nic."`;";
    $query_noti.="drop table `user_notif_ic_".$nic."`;";

    $notification_DB = NotificationDb::getConnection();
    $query_noti_run= mysqli_multi_query($notification_DB,$query_noti);

    echo $query;
    echo $query_noti;
    if($query_run  && $query_noti_run){
        echo '<script type="text/javascript"> alert ("Data deleted") </script>';
    }
    else{
        echo '<script type="text/javascript"> alert ("Data not deleted") </script>';
    }
    header('location:member.php');
?>

