<?php  
    session_start();
    require 'dbconfi/confi.php';
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

           $query="select * from organizations where org_id=".$org_id;
            $result=($con->query($query))->fetch_assoc();
            $status=explode(" ",$result['members']);
            $leader=$result['leader'];
            $co_leader=$result['co_leader'];

            if ($leader===$nic ){
                $query="UPDATE `organizations` SET `leader` = '".$value."' where org_id='$org_id'";
            }
            elseif($co_leader===$nic){
                $query="UPDATE `organizations` SET `co_leader` = '".$value."' where org_id='$org_id'";

            }
            elseif(in_array($nic, $status)){
                $key = array_search($nic,$status);
                unset($status[$key]);
                $my=join(" ",$status);
                $query="UPDATE `organizations` SET `members` = '".$my."' where org_id='$org_id'";
            }else{
                array_push($status,$nic);
                $my=join(" ",$status);
                $query="UPDATE `organizations` SET `members` = '".$my."' where org_id='$org_id'";
            }   

            $query_run= mysqli_query($con,$query);
            if($query_run ){
                echo '<script type="text/javascript"> alert ("Data Uploaded") </script>';
                header('location:view_org.php?selected_org='.$org_id);
            }
        ?>
    </body>
</html>