<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/confi/verify.php";
    $member_id=$_POST['member_id'];
    $role=$_POST['role'];
    $query="UPDATE org_members SET role='".$role."' where id=".$member_id;
    echo $query;
    $result=mysqli_query($con,$query);
    if($result){
        echo 'updated';
    }else{
        echo "not updated";
    }
?>