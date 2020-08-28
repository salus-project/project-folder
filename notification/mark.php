<?php
    require $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";
    require $_SERVER['DOCUMENT_ROOT']."/confi/verify.php";
    $notification_DB = NotificationDb::getConnection();
    if(isset($_POST['allow'])){
        $query = "update user_notif_ic_{$_SESSION['user_nic']} set status='seen' where Notification_id={$_POST['id']}";
        $notification_DB->query($query);
    }else if(isset($_POST['all_allow'])){
        $query = "update user_notif_ic_{$_SESSION['user_nic']} set status='seen';";
        $notification_DB->query($query);
    } else{
        header("location:/login.php");
    }