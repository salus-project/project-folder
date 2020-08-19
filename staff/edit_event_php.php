<?php  
    session_start();
    require 'dbconfi/confi.php';
    
?>

<?php
    if (isset($_POST['update_button'])){
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

        $query="update disaster_events SET name='$name',type='$type',affected_districts='$affected_districts',start_date='$start_date',status='$status',detail='$detail' where event_id='".$id."'";
        $query_run= mysqli_query($con,$query);
        if($query_run){
            echo '<script type="text/javascript"> alert ("Data Uploaded") </script>';   
        }else{
            echo '<script type="text/javascript"> alert ("Data not Uploaded") </script>';
        }
        header('location:/StaffSite/view_event.php?event_id='.$id);
    }
?>