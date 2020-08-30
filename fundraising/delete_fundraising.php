<?php  
    require $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";
    require $_SERVER['DOCUMENT_ROOT']."/confi/verify.php";
    
    $query="";
    //delete fundraising posts
    $query.="delete from public_posts where fund = ".$_GET['delete']." or tag='".$_GET['name']."';";

    //delete fundraising pro don and contents
    $query.="delete from fundraising_pro_don_content where don_id in(select id 
        from fundraising_pro_don WHERE for_fund =".$_GET['delete'].");";
    $query.="delete from fundraising_pro_don where for_fund =".$_GET['delete'].";";
        
    //delete fundraising and expects
    $query.="delete from fundraisings_expects where fund_id = ".$_GET['delete'].";";
    $query.="delete from fundraisings where id = ".$_GET['delete'].";";
    

    $query_run= mysqli_multi_query($con,$query);
    if($query_run){
       header('location:/fundraising/');
    }
?>

