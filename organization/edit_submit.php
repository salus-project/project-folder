<?php
require $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";
require $_SERVER['DOCUMENT_ROOT']."/confi/verify.php";

$string1= $_POST["datas"];
$org_id= $_POST["org_id"];
$event_id= $_POST["event_id"];
$event_name="event_".$event_id."_pro_don";
$string2 = explode ("++", $string1);
foreach($string2 as $str_data) {
    $str = explode ("--", $str_data);
    $query="UPDATE $event_name SET `content` = '$str[1]', `note` = '$str[2]' WHERE `event_2_pro_don`.`id` = '$str[0]';";
    $query_run=mysqli_query($con,$query);

}
$location="org_view_event.php?event_id=".$event_id."&selected_org=".$org_id."";
header("Location:".$location."");

?>