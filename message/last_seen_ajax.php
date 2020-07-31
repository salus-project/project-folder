<?php
require_once $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";
require_once $_SERVER['DOCUMENT_ROOT']."/confi/verify.php";

$sql=$_GET['sql4'];
$result=$con->query($sql)->fetch_assoc();
echo findLast($result['last_seen']);

function findLast($date){
    $date = new DateTime($date);
    $now = new DateTime();
    $diff=explode(',',$date->diff($now)->format("%y,%m,%d,%h,%i,%s"));
    if ((int)$diff[0]>=1){
        return $diff[0]." years";
    }elseif ((int)$diff[1]>=1){
        return $diff[1]." months";
    }elseif ((int)$diff[2]>=1){
        return $diff[2]." days";
    }elseif ((int)$diff[3]>=1){
        return $diff[3]." hrs";
    }elseif((int)$diff[4]>=1){
        return $diff[4]." mins";
    }elseif((int)$diff[5]>0){
        return "online";
    }else{
        return "long ago";
    }
}
?>