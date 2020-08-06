<?php  
    ob_start();
    ignore_user_abort();
    
    require $_SERVER['DOCUMENT_ROOT']."/includes/header.php";
?>

<!DOCTYPE html>
<html>
    <head>
        <title> Join and Leave</title>
    </head>

    <body>
        <?php
            if($_SERVER['REQUEST_METHOD']=='GET'){
                $org_id=$_GET['org_id'];
            }
            $nic=$_SESSION['user_nic'];    
            $value="null";

            $query="select * from org_members where org_id=".$org_id." and  NIC_num='".$nic."';";
            $result=$con->query($query);
            if(mysqli_num_rows($result)>0){
                $query1="DELETE FROM org_members where org_id=".$org_id." and  NIC_num='".$nic."';";
                $msss=" leave from ";
            }else{
                $query1="INSERT INTO org_members (org_id, NIC_num, role) VALUES ('$org_id', '$nic', 'member')";
                $msss=" joined with ";
            }   

            $sql="select NIC_num from org_members where org_id=".$org_id." and NIC_num <> '".$nic."';SELECT org_name FROM `organizations` where org_id=".$org_id.";" ;
            if(mysqli_multi_query($con,$sql.$query1)){
                $size = ob_get_length();
                header("Content-Encoding: none");
                header("Content-Length: {$size}");
                header("location:".$_SERVER['HTTP_REFERER']);
                header("Connection: close");

                header('location:'.$_SERVER['HTTP_REFERER']);

                ob_end_flush();
                ob_flush();
                flush();

                $sql_res=mysqli_store_result($con);
                $result1=$sql_res->fetch_all(MYSQLI_ASSOC);
                mysqli_free_result($sql_res);

                mysqli_next_result($con);
                $sql_res=mysqli_store_result($con);
                $result2=$sql_res->fetch_assoc();
                mysqli_free_result($sql_res);
        

                $to=implode(",",array_column($result1,'NIC_num'));
                $name= $_SESSION['first_name']." ".$_SESSION['last_name'];
                $mssg=$name.$msss.$result2['org_name'];
                $link="/organization/?selected_org=".$org_id;

                require $_SERVER['DOCUMENT_ROOT']."/notification/notification_sender.php";
                $sender = new Notification_sender($to,$mssg,$link,true);
                $sender->send();
            }
        ?>
    </body>
</html>