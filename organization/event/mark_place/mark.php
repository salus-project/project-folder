<?php
    require $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";
	require $_SERVER['DOCUMENT_ROOT']."/confi/verify.php"; 
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $event_id=$_POST['event_id'];
        $org_id=$_POST['org_id'];
        $type= $_POST['select_type'];
        $lat=$_POST['latitude']?:'0';
        $lng=$_POST['longitude']?:'0';
        $detail=$_POST['detail']?"'".$_POST['detail']."'":'NULL';

        $query = "INSERT INTO `event_".$event_id."_locations`(`type`, `latitude`, `longitude`, `by_org`, `detail`) VALUES ('".$type."', $lat, $lng, $org_id, $detail)";
        if(mysqli_query($con, $query)){
            echo "success";
        }
        echo $query;
        header("location:/organization/event/?event_id=".$event_id."&selected_org=".$org_id);
    }
?>