<?php
    require $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";
    require $_SERVER['DOCUMENT_ROOT']."/confi/verify.php";
 
    if(isset($_POST['submit_button'])){
        $event_id=$_POST['event_id'];
        $user_nic=$_SESSION['user_nic'];
        $district=$_POST['district'];
        $item = array_filter($_POST['item']);
        $amount = $_POST['amount'];
        $update_id=$_POST['update_id'];
        $village= $_POST['village'];
        $street= $_POST['street'];
        $pri_query = '';

        if($_POST['entry_update_id']!=0){
            echo $_POST['del_details'];
            $del_detail = array_filter(explode(',', $_POST['del_details']));
            foreach( $del_detail as $row_del){
                echo $row_del;
                $pri_query.= "delete from event_".$event_id."_requests where id=$row_del;";
            }
            for($x=0 ; $x < count($item) ; $x++){
                if(!empty($item[$x])){
                    if(empty($amount[$x])){
                        $amount[$x]=0;
                    }
                    
                    if($update_id[$x]=='0'){
                        $pri_query .= "INSERT INTO event_".$event_id."_requests (requester, item, amount) VALUES ('$user_nic', '$item[$x]', '$amount[$x]')";
                    
                    }else{
                        $pri_query .= "UPDATE `event_".$event_id."_requests` SET `item` = '$item[$x]', `amount` = '$amount[$x]' WHERE `event_2_requests`.`id` = '".$update_id[$x]."';";
                    }
                    $pri_query.= "UPDATE `event_".$event_id."_help_requested` SET `now` = 'yes' WHERE `NIC_num` = '".$user_nic."';";
                }
            }
        }else{
           $pri_query= "INSERT INTO event_".$event_id."_help_requested (NIC_num, district, village, street) VALUES ('$user_nic', '$district', '$village', '$street');";
           if(count($item)>0){
                $querry_arr = array();
                for($x=0; $x < count($item); $x++ ){
                    $row_item = $item[$x]?$item[$x]:'NULL';
                    $row_amount = $amount[$x]?:'0';
                    array_push($querry_arr, "('$user_nic','$row_item','$row_amount')");
                }
                $pri_query.= "INSERT INTO `event_".$event_id."_requests`(`requester`, `item`, `amount`) VALUES ". implode(", ", $querry_arr).";";
            }      
        }
 
        $status1=$_POST['status'];
        $status=explode(" ",$status1);
        $status[1]='requested';
        $data1=join(" ",$status);
        $pri_query.="UPDATE `disaster_events` SET `user_".$_SESSION['user_nic']."` = '".$data1."' WHERE `disaster_events`.`event_id` = $event_id";
        echo $pri_query;
        if(mysqli_multi_query($con,$pri_query)){
            echo "success";
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

        if(mysqli_multi_query($con,$pri_query)){
            echo 'cancelled';
        }else{
            echo '<script type="text/javascript"> alert ("Not cancelled") </script>';
        }
        
        
    }

?>