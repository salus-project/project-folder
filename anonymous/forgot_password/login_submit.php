<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";

    $nic=$_POST['nic'];
    $passsword=$_POST['password'];
    $hash_passwd= md5($passsword);
    $sql="Update civilian_detail set password='$hash_passwd' where NIC_num='$nic'";
    if($con->query($sql)){
        header("Location:/govpost");
    }
    
?>