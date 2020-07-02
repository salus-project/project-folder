<?php 	
	require $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";
	require $_SERVER['DOCUMENT_ROOT']."/confi/verify.php"; 

	$string1= $_POST["datas"];
	$org_id= $_POST["org_id"];
	$event_id= $_POST["event_id"];
	$event_name1="event_".$event_id."_pro_don";
	$event_name2="event_".$event_id."_pro_don_content";
	$string2 = explode ("++", $string1);
	$array1=unserialize($_POST["array1"]);
	$array2=unserialize($_POST["array2"]);

	foreach($string2 as $str_data) {
		$str = explode ("--", $str_data);
		if (array_key_exists($str[0], $array1)){
			$query="UPDATE $event_name1 SET `note` = '$str[2]' WHERE by_org=$org_id AND to_person='$str[0]';";
			$query_run=mysqli_query($con,$query);
			

			$ids=$array1[$str[0]];
			$str_items=explode (",", $str[1]);
			$i=0;

			if (sizeof($str_items)==sizeof($ids)){
				foreach($str_items as $items){
					$item=explode (":", $items);
					$query="UPDATE $event_name2 SET `item` = '$item[0]', `amount` = '$item[1]' WHERE `id` = '$ids[$i]';";
					$query_run=mysqli_query($con,$query);
					$i=$i+1;
				}
			}
			if (sizeof($str_items) < sizeof($ids)){
				foreach($str_items as $items){
					$item=explode (":", $items);
					$query="UPDATE $event_name2 SET `item` = '$item[0]', `amount` = '$item[1]' WHERE `id` = '$ids[$i]';";
					$query_run=mysqli_query($con,$query);
					$i=$i+1;
				}
				while (sizeof($ids) > $i ) {
					$sql = "DELETE FROM $event_name2 WHERE id=$ids[$i]";
					$con->query($sql); 
					$i=$i+1;
				}
			}
			if (sizeof($str_items) > sizeof($ids)){
				foreach($str_items as $items){
					$item=explode (":", $items);
					if(sizeof($ids) > $i ){
						$query="UPDATE $event_name2 SET `item` = '$item[0]', `amount` = '$item[1]' WHERE `id` = '$ids[$i]';";
						$query_run=mysqli_query($con,$query);
						$i=$i+1;
					}
					else{
						$pro_id=$array2[$str[0]];
						$query1="INSERT INTO `$event_name2` (`don_id`,`item`,`amount` ) VALUES ($pro_id, '$item[0]', '$item[1]');";
						$query_run=mysqli_query($con,$query1);
					}
				}
			}
			
		}else{
			if ($str[1] !=""){
				$str_items=explode (",", $str[1]);

				$sub_query = "INSERT INTO `$event_name2`(`don_id`,`item`,`amount`) VALUES ";
				$querry_arr = array();
				foreach ($str_items as $items) {
					$item=explode (":", $items);
				array_push($querry_arr, "(last_insert_id(),'$item[0]','$item[1]')");
				}
		
				$sub_query = $sub_query . implode(", ", $querry_arr).";";
		
				$query = "INSERT INTO `$event_name1` (`pro_don`, `by_org`, `to_person`,`note` ) VALUES ( 'promise', '$org_id', '$str[0]', '$str[2]');".$sub_query;
				mysqli_multi_query($con,$query);
			}
			
		}
	}
	header("location:".$_SERVER['HTTP_REFERER']);
?>