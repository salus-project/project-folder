<?php
    try{
        $con = mysqli_connect("remotemysql.com","kfm2yvoF5R","4vkzHfeBh6") or header('location:dbconfi/error.html');
        mysqli_select_db($con,"kfm2yvoF5R");

        $org_DB = mysqli_connect("remotemysql.com","LvFAfm4fFA","JGhOtcM4ez") or die("Unable to connect");
        mysqli_select_db($org_DB,"LvFAfm4fFA");

        $notification_DB = mysqli_connect("remotemysql.com","LlvvpTpgPp","t6rKpohvCB") or die("Unable to connect");
        mysqli_select_db($notification_DB,"LlvvpTpgPp");
    }catch(Exception $e){
        header('location:error.html');
    }
?>