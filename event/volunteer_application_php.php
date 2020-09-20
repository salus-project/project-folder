<?php
    ob_start();
    ignore_user_abort();

    require $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";
    require $_SERVER['DOCUMENT_ROOT']."/confi/verify.php";
 
    if(isset($_POST['update_button'])){
        
        $event_id=$_POST['event_id'];
        $user_nic=$_SESSION['user_nic'];

        $district=$_POST['district'];
        for($x=0 ; $x < count($district) ; $x++){
            filt_inp($district[$x]);
        }
        $district= implode(",", $district);

        $type=isset($_POST['type'])?$_POST['type']:array();
        for($x=0 ; $x < count($type) ; $x++){
            filt_inp($type[$x]);
        }
        $type= implode("&", $type);

        $item = array_filter($_POST['item']);
        $amount = $_POST['amount'];
        $update_id=$_POST['update_id'];
        $pri_query = '';

        if($_POST['entry_update_id']!=0){
            $del_detail = array_filter(explode(',', $_POST['del_details']));
            foreach( $del_detail as $row_del){
                $pri_query.= "delete from event_".$event_id."_abilities where id=".$row_del.";";
            }
            for($x=0 ; $x < count($item) ; $x++){
                if(!empty($item[$x])){
                    if(empty($amount[$x])){
                        $amount[$x]=0;
                    }
                    
                    if($update_id[$x]=='0'){
                        $pri_query .= "INSERT INTO event_".$event_id."_abilities (donor, item, amount) VALUES ('$user_nic', '".ready_input(filt_inp($item[$x]))."', '".filt_inp($amount[$x])."');";
                    
                    }else{
                        $pri_query .= "UPDATE `event_".$event_id."_abilities` SET `item` = '".ready_input(filt_inp($item[$x]))."', `amount` = '".filt_inp($amount[$x])."' WHERE `event_".$event_id."_abilities`.`id` = '".$update_id[$x]."';";
                    }
                    $pri_query.= "UPDATE `event_".$event_id."_volunteers` SET `now` = 'yes',`service_district` = '$district',`type` = '$type' WHERE `NIC_num` = '".$user_nic."';";
                }
            }
        }else{
           $pri_query= "INSERT INTO event_".$event_id."_volunteers (NIC_num, service_district, type) VALUES ('$user_nic', '$district', '$type');";
           if(count($item)>0){
                $querry_arr = array();
                for($x=0; $x < count($item); $x++ ){
                    $row_item = $item[$x]?ready_input(filt_inp($item[$x])):'NULL';
                    $row_amount = $amount[$x]?filt_inp($amount[$x]):'0';
                    array_push($querry_arr, "('$user_nic','$row_item','$row_amount')");
                }
                $pri_query.= "INSERT INTO `event_".$event_id."_abilities`(`donor`, `item`, `amount`) VALUES ". implode(", ", $querry_arr).";";
            }      
        }
 
        $status1=$_POST['status'];
        $status=explode(" ",$status1);
        $status[2]='applied';
        $data1=join(" ",$status);
        $pri_query.="UPDATE `disaster_events` SET `user_".$_SESSION['user_nic']."` = '".$data1."' WHERE `disaster_events`.`event_id` = $event_id";
        
        $sql="SELECT NIC_num FROM `event_".$event_id."_help_requested`;";
        if(mysqli_multi_query($con,$sql.$pri_query)){
            $sql_res=mysqli_store_result($con);
            $result1=$sql_res->fetch_all();
            mysqli_free_result($sql_res);

            $size = ob_get_length();
            header("Content-Encoding: none");
            header("Content-Length: {$size}");
            header("location:".$_SERVER['HTTP_REFERER']);
            header("Connection: close");

            header("location:".$_SERVER['HTTP_REFERER']);

            ob_end_flush();
            ob_flush();
            flush();

            if ($type != "" and $_POST['entry_update_id']==0){
                $name= $_SESSION['first_name']." ".$_SESSION['last_name'];
                $to=implode(",",array_column($result1,0));
                $mssg=$name." is ready to help";
                $link="/event/volunteer.php?event_id=".$event_id."&nic=".$user_nic;
                require $_SERVER['DOCUMENT_ROOT']."/notification/notification_sender.php";
                $sender = new Notification_sender($to,$mssg,$link,true);
                $sender->send();
            }
        
        }
        else{
            echo '<script type="text/javascript"> alert ("Data not Uploaded") </script>';
        }
    }elseif(isset($_POST['cancel'])){
        $event_id=$_POST['event_id'];
        $status=$_POST['status'];

        $pri_query="UPDATE `disaster_events` SET `user_".$_SESSION['user_nic']."` = '".$status."' WHERE `disaster_events`.`event_id` = ".$event_id.";
            UPDATE `event_".$event_id."_volunteers` SET `now` = 'no' WHERE `NIC_num` = '".$_SESSION['user_nic']."';";
        if(mysqli_multi_query($con,$pri_query)){
            echo 'sucess';
        }else{
            echo "unsucess";
        }
    }
?>