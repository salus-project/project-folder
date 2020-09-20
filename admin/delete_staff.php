<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/confi/verify_admin.php";
    
    $query="delete from staff_detail where NIC_num = '".$_GET['nic']."'";
    $query_run= mysqli_query($con,$query);
    if($query_run ){
        echo '<script type="text/javascript"> alert ("Data deleted") </script>';
    }
    else{
        echo '<script type="text/javascript"> alert ("Data not deleted") </script>';
    }
    header('location:staff.php');
?>

