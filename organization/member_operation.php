<?php
    require $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";
    require $_SERVER['DOCUMENT_ROOT']."/confi/verify.php";
        
    $org_id=$_GET['org_id'];
    $type=$_GET['type'];
    $nic=$_GET['nic'];

    $query_role = "select * from org_members where NIC_num='".$_SESSION['user_nic']."' and org_id='".$org_id."';";
    $result= mysqli_query($con,$query_role);
    if($result->num_rows>0){
        $row=$result->fetch_assoc();
        $role=$row['role'];    
    } 
    
    /* this is for leader remove a member or leader remove a coleader or co-leader remove a member*/ 
    if ($type=="member_remove" or $type=="coleader_remove"){
        if($role=='leader' || $role=='coleader'){
            $query="delete from org_members where org_id='".$org_id."' and NIC_num='".$nic."';";
        }
    }

    /* this is for leader promote a member to co-leader or co-leader promote a member to co-leader*/
    else if ($type=="member_promote_to_coleader"){
        if($role=='leader' || $role=='coleader'){
            $query="update org_members set role='coleader' where org_id='".$org_id."' and NIC_num='".$nic."';";
        }
    }

    /* this is for leader promote a co-leader to leader or leader promote a member to leader and leader become co-leader*/ 
    else if ($type=="member_promote_to_leader" or $type=="coleader_promote_to_leader"){
        if($role=='leader'){
            $query="update org_members set role='leader' where org_id='".$org_id."' and NIC_num='".$nic."';
                update org_members set role='coleader' where org_id='".$org_id."' and NIC_num='".$_SESSION['user_nic']."';";
        }
    }

    /* this is for leader de-promote a co-leader to member */ 
    else if ($type=="coleader_depromote_to_member"){
        if($role=='leader'){
            $query="update org_members set role='member' where org_id='".$org_id."' and NIC_num='".$nic."'";
        }
    }


    if(mysqli_multi_query($con, $query)){
        echo '<script type="text/javascript"> alert ("Data updated") </script>';
    }
    else{
        echo '<script type="text/javascript"> alert ("Data not updated") </script>';
    }
    header("location:".$_SERVER['HTTP_REFERER']);

?>
            