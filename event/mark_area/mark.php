<?php
    require $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";
	require $_SERVER['DOCUMENT_ROOT']."/confi/verify.php"; 
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $event_id=$_POST['event_id'];
        $type=($_POST['mark']=='circle')?'suggested_circle':'suggested_area';
        $lat=$_POST['latitude']?:'0';
        $lng=$_POST['longitude']?:'0';
        $rad=$_POST['radius']?:'0';
        $geoJson=$_POST['geoJson']?"'".$_POST['geoJson']."'":'NULL';
        $detail=$_POST['detail']?"'".$_POST['detail']."'":'NULL';

        if($_POST['mark']=='circle'){
            $geoJson='NULL';
        }else{
            $lat='NULL';
            $lng='NULL';
            $rad='NULL';
        }

        $query = "INSERT INTO `event_".$event_id."_locations`(`type`, `latitude`, `longitude`, `radius`, `geojson`, `by_person`, `detail`) VALUES ('".$type."', $lat, $lng, $rad, $geoJson,'{$_SESSION['user_nic']}',$detail)";
        if(mysqli_query($con, $query)){
            echo "success";
        }
        header("location:/event?event_id=".$_POST['event_id']);
    }
?>