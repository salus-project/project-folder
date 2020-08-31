<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/confi/verify.php";
    $sql_="SELECT id FROM `org_members` WHERE org_id=".$_GET['org_id']." and NIC_num='".$_SESSION['user_nic']."' and role='leader'";
    echo $sql;
    $result_=$con->query($sql_);
    if (mysqli_num_rows($result_)==0){
        header("location:".(isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] :"/organization/all_org.php"));
        ob_end_flush();
        ob_flush();
        flush();
    }else{

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
}
?>