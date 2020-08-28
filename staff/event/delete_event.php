<?php  
    require_once $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/confi/verify_staff.php";

    $query="";

    if ($_GET['del']=="1"){
        $query.="delete from disaster_events where event_id = ".$_GET['delete'].";";
        $query.="DROP TABLE event_".$_GET['delete']."_volunteers,event_".$_GET['delete']."_requests,event_".$_GET['delete']."_pro_don_content,event_".$_GET['delete']."_pro_don,event_".$_GET['delete']."_locations,event_".$_GET['delete']."_help_requested,event_".$_GET['delete']."_abilities;";
        $query.="delete from goveposts where event = ".$_GET['delete'].";";

        //delete fundraising pro don and contents
        $query.="delete from fundraising_pro_don_content where don_id in(select id 
        from fundraising_pro_don WHERE for_fund in(select id 
        from fundraisings WHERE for_event =".$_GET['delete']."));";
        $query.="delete from fundraising_pro_don where for_fund in(select id 
        from fundraisings WHERE for_event =".$_GET['delete'].");";

        //delete fundraising and expects
        $query.="delete from fundraisings_expects where fund_id in(select id 
        from fundraisings WHERE for_event =".$_GET['delete'].");";
        $query.="delete from fundraisings where for_event = ".$_GET['delete'].";";

    
    }else if  ($_GET['del']=="0"){
        $query.="delete from disaster_events where event_id = ".$_GET['delete'].";";
        $query.="delete from goveposts where event = ".$_GET['delete'].";";
        //delete fundraising pro don and contents
        $query.="delete from fundraising_pro_don_content where don_id in(select id 
        from fundraising_pro_don WHERE for_fund in(select id 
        from fundraisings WHERE for_event =".$_GET['delete']."));";
        $query.="delete from fundraising_pro_don where for_fund in(select id 
        from fundraisings WHERE for_event =".$_GET['delete'].");";

        //delete fundraising and expects
        $query.="delete from fundraisings_expects where fund_id in(select id 
        from fundraisings WHERE for_event =".$_GET['delete'].");";
        $query.="delete from fundraisings where for_event = ".$_GET['delete'].";";
    }

    $query_run= mysqli_multi_query($con,$query);
    if($query_run){
        header('location:/staff/event/');
    } 
?>

