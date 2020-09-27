<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/confi/verify_admin.php";
    if (isset($_POST['update_button'])){
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $nic_num = $_POST['nic_num'];
        $password = $_POST['password'];
        $gender = $_POST['gender'];
        $district = $_POST['district']; 
        $address = $_POST['address']; 
        $user_name = $_POST['user_name']; 
        $email_address = $_POST['email_address']; 
        $phone_num = $_POST['phone_num']; 

        $query= "INSERT INTO `staff_detail`(`first_name`, `last_name`, `NIC_num`, `password`, `gender`,`district`,  `address`, `user_name`, `email_address`, `phone_num`) VALUES ('$first_name','$last_name','$nic_num','$password','$gender','$district','$address','$user_name','$email_address','$phone_num')";
        $query_run= mysqli_query($con,$query);
        echo $query;
        if($query_run){
            header('location:/admin/staff.php');
        }
    }
?>

