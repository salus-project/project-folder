<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/confi/verify.php";

    $query='delete from org_members where org_id='.$_GET['org_id'].';
            delete from organizations where org_id='.$_GET['org_id'].';';
    
    $con->multi_query($query);
    header('location:/organization');
?>