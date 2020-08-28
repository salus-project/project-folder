<?php
    require $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";
    require $_SERVER['DOCUMENT_ROOT']."/confi/verify.php";
 
    if(isset($_POST['submit_button'])){
        function test_input($data){
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        
        $district = test_input($_POST['district']);
        $village = test_input($_POST['village']);
        $street = test_input($_POST['street']);
        
        $event_id=$_POST['event_id'];
        $user_nic=$_SESSION['user_nic'];
        $item = array_filter($_POST['item']);
        $amount = $_POST['amount'];
        $update_id=$_POST['update_id'];

        $lat=$_POST['lat'];
        $lng=$_POST['lng'];

        $pri_query = '';

        if($_POST['entry_update_id']!=0){
            $del_detail = array_filter(explode(',', $_POST['del_details']));
            foreach( $del_detail as $row_del){
                $pri_query.= "delete from event_".$event_id."_requests where id=$row_del;";
            }
            for($x=0 ; $x < count($item) ; $x++){
                if(!empty($item[$x])){
                    if(empty($amount[$x])){
                        $amount[$x]=0;
                    }
                    if($update_id[$x]==0){
                        $pri_query .= "INSERT INTO event_".$event_id."_requests (requester, item, amount) VALUES ('$user_nic', '".test_input($item[$x])."', '".test_input($amount[$x])."');";
                    
                    }else{
                        $pri_query .= "UPDATE `event_".$event_id."_requests` SET `item` = '".test_input($item[$x])."', `amount` = '".test_input($amount[$x])."' WHERE `event_2_requests`.`id` = ".$update_id[$x].";";
                    }
                }
            }
            $pri_query.= "UPDATE `event_".$event_id."_help_requested` SET `now` = 'yes' WHERE `NIC_num` = '".$user_nic."';";
                
        }else{
        $pri_query= "INSERT INTO event_".$event_id."_help_requested (NIC_num, district, village, street, lat, lng) VALUES ('$user_nic', '$district', '$village', '$street', $lat, $lng);";
        if(count($item)>0){
                $querry_arr = array();
                for($x=0; $x < count($item); $x++ ){
                    $row_item = $item[$x]?test_input($item[$x]):'NULL';
                    $row_amount = $amount[$x]?test_input($amount[$x]):'0';
                    array_push($querry_arr, "('$user_nic','$row_item','$row_amount')");
                }
                $pri_query.= "INSERT INTO `event_".$event_id."_requests`(`requester`, `item`, `amount`) VALUES ". implode(", ", $querry_arr).";";
            }      
        }

        $status1=$_POST['status'];
        $status=explode(" ",$status1);
        $status[1]='requested';
        $data1=join(" ",$status);
        $pri_query.="UPDATE `disaster_events` SET `user_".$_SESSION['user_nic']."` = '".$data1."' WHERE `disaster_events`.`event_id` = $event_id;";

        
        if(mysqli_multi_query($con,$pri_query)){
            header("location:".$_SERVER['HTTP_REFERER']);
        }
        else{
            echo 'unsucessful in starting';
        }
    }

        
    if(isset($_POST['cancel_button'])){  
        $event_id=$_POST['event_id'];
        $status1=$_POST['status'];
        $status=explode(" ",$status1);
        $status[1]='not_requested';
        $data1=join(" ",$status);
        $pri_query="UPDATE `disaster_events` SET `user_".$_SESSION['user_nic']."` = '".$data1."' WHERE `disaster_events`.`event_id` = ".$event_id.";
            UPDATE `event_".$event_id."_help_requested` SET `now` = 'no' WHERE `event_".$event_id."_help_requested`.`NIC_num` = '".$_SESSION['user_nic']."';";
        mysqli_query($con,$pri_query);
        echo $pri_query;
        
    }
?>