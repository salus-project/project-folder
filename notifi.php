<?php
    ob_start();
    ignore_user_abort();
    
    
    $size = ob_get_length();
    header("Content-Encoding: none");
    header("Content-Length: {$size}");
    header("location:".$_SERVER['HTTP_REFERER']);
    header("Connection: close");

    ob_end_flush();
    ob_flush();
    flush();
    
    /* code */
    require $_SERVER['DOCUMENT_ROOT']."/notification/notification_sender.php";
    /*sample code*/
    /*$sender = new Notification_sender("982812763V","you got an message", "/organization.php");
    $sender->send();*/
    
