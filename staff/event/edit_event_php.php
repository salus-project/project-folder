<?php  
    require_once $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/confi/verify_staff.php";
    $err="";
?>

<?php
    if (isset($_POST['update_button'])){
        $check=true;

        $id=$_POST['event_id'];
        $name=$_POST['name'];
        $type = $_POST['type'];
        $affected_districts="not_selected";
        if( ! empty( $_POST['district'] )){
            $values = $_POST['district'];
            $affected_districts = implode(",", $values);
        }
        $start_date = $_POST['start_date'];
        $status = $_POST['status'];
        $detail = $_POST['detail'];

        $name_check='SELECT name FROM `disaster_events` WHERE name="'.$name.'" and event_id != "'.$id.'"';
        $result_=$con->query($name_check);
        if (mysqli_num_rows($result_) > 0){
            $err="Name already exist";
            $check=false;
        }
        if(in_array(substr($name,0,1), ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9']) ){
            $err="Name should start with a letter";
            $check=false;
        }
        if(!preg_match("/^[a-zA-Z0-9 ]*$/",$name)){
            $err="Only letters and white space allowed";
            $check=false;
        } 

        if(in_array(substr($type,0,1), ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9']) ){
            $err="Event type should start with a letter";
            $check=false;
        }elseif(!preg_match("/^[a-zA-Z0-9 ]*$/",$type)){
            $err="Only letters and white space allowed for Event type";
            $check=false;
        } 

        if ($check){
            $query="update disaster_events SET name='$name',type='$type',affected_districts='$affected_districts',start_date='$start_date',detail='$detail' where event_id='".$id."'";
            $query_run= mysqli_query($con,$query);
            if($query_run ){
                echo '<script type="text/javascript"> alert ("Data Uploaded") </script>';   
            }else{
                echo '<script type="text/javascript"> alert ("Data not Uploaded") </script>';
            }
            header('location:/staff/event/view_event.php?event_id='.$id);
        }else{
            header('location:/staff/event/edit_event.php?event_id='.$id.'&err='.$err);
        }
    }
?>