<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";

    $nic=$_POST['nic'];
    $passsword=$_POST['password'];
    $sql="Update civilian_detail set password='$passsword' where NIC_num='$nic'";
    if($con->query($sql)){
        header("Location:/govpost");
    }
    
?>