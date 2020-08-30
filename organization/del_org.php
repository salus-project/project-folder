<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/confi/verify.php";
    $result=array_column($con->query("SELECT event_id FROM `disaster_events` where status='active'")->fetch_all(),0);
    $query ="";

    foreach ($result as $id){
        $query .= "delete from event_".$id."_pro_don_content where don_id in ( select id from event_".$id."_pro_don where by_org=".$_GET['org_id']."); 
                    delete from event_".$id."_pro_don where by_org=".$_GET['org_id'].";";

    }
    $query .='delete from org_members where org_id='.$_GET['org_id'].';
            delete from organizations where org_id='.$_GET['org_id'].';';
    //echo $query;
    $con->multi_query($query);
    header('location:/organization');
?>