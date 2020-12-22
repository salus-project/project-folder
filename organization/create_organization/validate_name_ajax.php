<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";
    session_start();
    $query = "select org_name from organizations where org_name = '" . $_GET['name'] . "';";
    $result = $con->query($query);
    if($result->num_rows>0){
        echo '1';
    }else{
        echo '0';
    }