<?php
    session_start();
    require '../dbconfi/confi.php';
 
    if(isset($_POST['submit_button'])){
        $event_id=$_POST['event_id'];
       $user_nic=$_SESSION['user_nic'];
       $district=$_POST['district'];
       $money_description=$_POST['money_description']??'';
       $good_description=$_POST['good_description']??'';
       $type_arr=explode(',',$_POST["type"]);
       $help_type="";
       
       if(count($type_arr)==2){
           $help_type="money and good"; 
       }elseif(count($type_arr)==1){
           if($type_arr[0]=="money"){
               $help_type="money";
           }elseif($type_arr[0]=="good"){
               $help_type="good";
           }
       }
        $data="SELECT * from event_".$event_id."_help_requested where NIC_num='".$_SESSION['user_nic']."'";
        $result=$con->query($data);
        $query_run = $query_now_run = false;
        if($result->num_rows>0){
            $query_now="UPDATE `event_".$event_id."_help_requested` SET `district` = '$district', `now` = 'yes', `help_type` = '$help_type', `money_discription` = '$money_description', `good_discription` = '$good_description' WHERE `event_".$event_id."_help_requested`.`NIC_num` = '$user_nic'";
            $query_now_run= mysqli_query($con,$query_now);
        }
        else{
            $query="INSERT INTO event_".$event_id."_help_requested (NIC_num, district, help_type, money_discription, good_discription) VALUES ('$user_nic', '$district', '$help_type', '$money_description', '$good_description')";
            //echo $query;
            $query_run= mysqli_query($con,$query);
        }
        if($query_run || $query_now_run){

           $data="SELECT * from disaster_events where event_id='$event_id'";
           $result=($con->query($data))->fetch_assoc();
           $status=explode(" ",$result['user_'.$_SESSION['user_nic']]);

           $status[1]='requested';
           $data1=join(" ",$status);
           $query1="UPDATE `disaster_events` SET `user_".$_SESSION['user_nic']."` = '".$data1."' WHERE `disaster_events`.`event_id` = $event_id";
           $query_run1= mysqli_query($con,$query1);

           if($query_run1){
                echo 'success';
           }else{
               echo 'unsucessful';
           }
        }
        else{
           echo 'unsucessful in starting';

       }
    }
      
    if(isset($_POST['update_button'])){
        $event_id=$_POST['event_id'];
        $user_nic=$_SESSION['user_nic'];
        $district=$_POST['district'];
        $money_description=$_POST['money_description'];
        $good_description=$_POST['good_description'];
        $type_arr=$_POST["type"];
        $help_type="";
        
        if(count($type_arr)==2){
            $help_type="money and good"; 
        }elseif(count($type_arr)==1){
            if($type_arr[0]=="money"){
                $help_type="money";
            }elseif($type_arr[0]=="good"){
                $help_type="good";
            }
        }
        
        $query_edit="UPDATE `event_".$event_id."_help_requested` SET `district` = '$district', `help_type` = '$help_type', `money_discription` = '$money_description', `good_discription` = '$good_description' WHERE `event_".$event_id."_help_requested`.`NIC_num` = '$user_nic'";
        $query_run= mysqli_query($con,$query_edit);
 
        if($query_run){
            header('location:view_event.php?event_id='.$event_id);
        }else{
            echo '<script type="text/javascript"> alert ("Not edited") </script>';
        }
    }
    if(isset($_POST['cancel_button'])){
    
        $event_id=$_POST['event_id'];
        $data1="SELECT * from disaster_events where event_id='$event_id'";
        $result1=($con->query($data1))->fetch_assoc();
        $status=explode(" ",$result1['user_'.$_SESSION['user_nic']]);
        
        $status[1]='not_requested';
        $data2=join(" ",$status);
        $query1="UPDATE `disaster_events` SET `user_".$_SESSION['user_nic']."` = '".$data2."' WHERE `disaster_events`.`event_id` = $event_id";
        $query_run1= mysqli_query($con,$query1);

        if($query_run1){
            $query_now="UPDATE `event_".$event_id."_help_requested` SET `now` = 'no' WHERE `event_".$event_id."_help_requested`.`NIC_num` = '".$_SESSION['user_nic']."'";
            $query_now_run= mysqli_query($con,$query_now);

            if($query_now_run){
                echo 'cancelled';
            }else{
                echo '<script type="text/javascript"> alert ("No updated") </script>';
            }
        }else{
        echo '<script type="text/javascript"> alert ("Not requested updated") </script>';
        }
        
    }

?>