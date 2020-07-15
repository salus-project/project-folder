<?php  
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
            }else{
                $query1="INSERT INTO org_members (org_id, NIC_num, role) VALUES ('$org_id', '$nic', 'member')";
            }   

            $query_run= mysqli_query($con,$query1);
            if($query_run ){
                echo '<script type="text/javascript"> alert ("Data Uploaded") </script>';
                header('location:/organization/?selected_org='.$org_id);
            }
        ?>
    </body>
</html>