<?php 	
	ob_start();
	ignore_user_abort();

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
	$query='';
	$id_arr1=[];
	$id_arr2=[];
	foreach($string2 as $str_data) {
		$str = explode ("--", $str_data);
		
		if (array_key_exists($str[0], $array1)){
			array_push($id_arr2,$str[0]);
			$query.="UPDATE $event_name1 SET `note` = '$str[2]' WHERE by_org=$org_id AND to_person='$str[0]';";

			$ids=$array1[$str[0]];
			$str_items=array_filter(explode (",", $str[1]));
			$i=0;

			if (sizeof($str_items)==sizeof($ids)){
				foreach($str_items as $items){
					$item=explode (":", $items);
					$query.="UPDATE $event_name2 SET `item` = '$item[0]', `amount` = '$item[1]',`pro_don` = '$item[2]' WHERE `id` = '$ids[$i]';";
					$i=$i+1;
				}
			}
			if (sizeof($str_items) < sizeof($ids)){
				foreach($str_items as $items){
					$item=explode (":", $items);
					$query.="UPDATE $event_name2 SET `item` = '$item[0]', `amount` = '$item[1]',`pro_don` = '$item[2]' WHERE `id` = '$ids[$i]';";
					$i=$i+1;
				}
				while (sizeof($ids) > $i ) {
					$query.= "DELETE FROM $event_name2 WHERE id='$ids[$i]';";
					$i=$i+1;
				}
			}
			if (sizeof($str_items) > sizeof($ids)){
				foreach($str_items as $items){
					$item=explode (":", $items);
					if(sizeof($ids) > $i ){
						$query.="UPDATE $event_name2 SET `item` = '$item[0]', `amount` = '$item[1]',`pro_don` = '$item[2]' WHERE `id` = '$ids[$i]';";
						$i=$i+1;
					}
					else{
						$pro_id=$array2[$str[0]];
						$query.="INSERT INTO `$event_name2` (`don_id`,`item`,`amount`,`pro_don` ) VALUES ($pro_id, '$item[0]', '$item[1]','$item[2]');";
					}
				}
			}
			
		}else{
			array_push($id_arr1,$str[0]);
			if ($str[1] !=""){
				$str_items=explode (",", $str[1]);

				$sub_query = "INSERT INTO `$event_name2`(`don_id`,`item`,`amount`) VALUES ";
				$querry_arr = array();
				foreach ($str_items as $items) {
					$item=explode (":", $items);
				array_push($querry_arr, "(last_insert_id(),'$item[0]','$item[1]')");
				}
		
				$sub_query = $sub_query . implode(", ", $querry_arr).";";
		
				$query.= "INSERT INTO `$event_name1` (`by_org`, `to_person`,`note` ) VALUES ('$org_id', '$str[0]', '$str[2]');".$sub_query;
			}
			
			
		}
		
	}
	$sql="SELECT org_name FROM `organizations` WHERE org_id=$org_id;";
	if (mysqli_multi_query($con,$sql.$query)){
	
		$size = ob_get_length();
		header("Content-Encoding: none");
		header("Content-Length: {$size}");
		header("location:".$_SERVER['HTTP_REFERER']);
		header("Connection: close");

		header("location:".$_SERVER['HTTP_REFERER']);

		ob_end_flush();
		ob_flush();
		flush();
		
		$sql_res=mysqli_store_result($con);
		$res=$sql_res->fetch_row();
		mysqli_free_result($sql_res);


		$to=implode(",",$id_arr1);
		$mssg=$res[0]." promised to help you";
		$link="/event/view_promises_on_me.php?event_id=".$event_id;
		require $_SERVER['DOCUMENT_ROOT']."/notification/notification_sender.php";
		$sender = new Notification_sender($to,$mssg,$link,true);
		$sender->send();

		$to2=implode(",",$id_arr2);
		$mssg2=$res[0]." edited their promise on you";
		$sender = new Notification_sender($to2,$mssg2,$link,true);
		$sender->send();

	}
    else{
        echo '<script type="text/javascript"> alert ("Data not Uploaded") </script>';
    }
?>