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
		if(str[1]!="" and str[2]!=""){
			$query="INSERT INTO `$event_name` (`pro_don`, `by_org`, `to_person`,`content`,`note` ) VALUES ( 'promise', '$org_id', '$str[0]', '$str[1]', '$str[2]')";
			$query_run=mysqli_query($con,$query);
		}
	}
	$location="org_view_event.php?event_id=".$event_id."&selected_org=".$org_id."";
	header("Location:".$location."");
	
?>