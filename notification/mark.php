<?php
    require $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";
    require $_SERVER['DOCUMENT_ROOT']."/confi/verify.php";
    if(isset($_POST['allow'])){
        $query = "update user_notif_ic_{$_SESSION['user_nic']} set status='seen' where Notification_id={$_POST['id']}";
        $notification_DB->query($query);
    }else{
        header("location:/login.php");
    }