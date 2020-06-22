<?php 	
require $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";
require $_SERVER['DOCUMENT_ROOT']."/confi/verify.php";
	
	$string1= $_POST["datas"];
	$org_id= $_POST["org_id"];
	$event_id= $_POST["event_id"];
	$event_name="event_".$event_id."_pro_don";
	$string2 = explode ("++", $string1);
	$array1=explode (",", $_POST["array1"]);
	$array3=explode ("++", $_POST["array3"]);
	
	foreach($string2 as $str_data) {
		$str = explode ("--", $str_data);
		if (in_array($str[0], $array1)){
			$key = array_search($str[0], $array1); 
			$ids=explode (",", $array3[$key]);
			$str_items=explode (",", $str[1]);
			$i=0;
			if (sizeof($str_items)==sizeof($ids)){
				foreach($str_items as $items){
					$item=explode (":", $items);
					$query="UPDATE $event_name SET `item` = '$item[0]', `amount` = '$item[1]', `note` = '$str[2]' WHERE `id` = '$ids[$i]';";
					$query_run=mysqli_query($con,$query);
					$i=$i+1;
				}
			}
			if (sizeof($str_items) < sizeof($ids)){
				foreach($str_items as $items){
					$item=explode (":", $items);
					$query="UPDATE $event_name SET `item` = '$item[0]', `amount` = '$item[1]', `note` = '$str[2]' WHERE `id` = '$ids[$i]';";
					$query_run=mysqli_query($con,$query);
					$i=$i+1;
				}
				while (sizeof($ids) > $i ) {
					$sql = "DELETE FROM $event_name WHERE id=$ids[$i]";
					$con->query($sql); 
					$i=$i+1;
				  }

			}
			if (sizeof($str_items) > sizeof($ids)){
				foreach($str_items as $items){
					$item=explode (":", $items);
					if(sizeof($ids) > $i ){
					$query="UPDATE $event_name SET `item` = '$item[0]', `amount` = '$item[1]', `note` = '$str[2]' WHERE `id` = '$ids[$i]';";
					$query_run=mysqli_query($con,$query);
					$i=$i+1;
					}
					else{
						if ($item[0]!="" or $item[1]!=""){
							$query="INSERT INTO `$event_name` (`pro_don`, `by_org`, `to_person`,`item`,`amount`,`note` ) VALUES ( 'promise', '$org_id', '$str[0]', '$item[0]', '$item[1]', '$str[2]')";
							$query_run=mysqli_query($con,$query);
						}
					}
				}
			}
		}
		else{
			$str_items=explode (",", $str[1]);
			foreach($str_items as $items){
				$item=explode (":", $items);
				if ($item[0]!="" or $item[1]!=""){
					$query="INSERT INTO `$event_name` (`pro_don`, `by_org`, `to_person`,`item`,`amount`,`note` ) VALUES ( 'promise', '$org_id', '$str[0]', '$item[0]', '$item[1]', '$str[2]')";
					$query_run=mysqli_query($con,$query);	
				}
			}
		}
	}
	$location="?event_id=".$event_id."&selected_org=".$org_id."";
	header("Location:".$location."");
	
?>