<?php
    require $_SERVER['DOCUMENT_ROOT']."/includes/header.php";
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