<?php
    session_start();
    require_once $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";
        
        $nic_num=$_POST['nic'];
        $password=$_POST['password'];
        $query="select * from civilian_detail where NIC_num='$nic_num' AND password='$password'";
        //$query_run = mysqli_query($con,$query);
        $result=$con->query($query);
        if($result->num_rows>0){
            
            while($row=$result->fetch_assoc()){
                //$_SESSION['']=$row[''];
                $_SESSION['user_nic'] = $row["NIC_num"];
                $_SESSION['first_name']=$row["first_name"];
                $_SESSION['last_name']=$row['last_name'];
                $_SESSION['side_nav']=1;
                $_SESSION['role']='civilian';
            }
            
            echo "true";
            

        }else{
            echo "false";
        }
?>