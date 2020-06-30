<?php
    try{
        $con = mysqli_connect("remotemysql.com","kfm2yvoF5R","4vkzHfeBh6") or header('location:'.$_SERVER['DOCUMENT_ROOT'].'/confi/error.html');
        mysqli_select_db($con,"kfm2yvoF5R");

        $org_DB = mysqli_connect("remotemysql.com","LvFAfm4fFA","JGhOtcM4ez") or die("Unable to connect");
        mysqli_select_db($org_DB,"LvFAfm4fFA");

        $notification_DB = mysqli_connect("remotemysql.com","LlvvpTpgPp","t6rKpohvCB") or die("Unable to connect");
        mysqli_select_db($notification_DB,"LlvvpTpgPp");
    }catch(Exception $e){
        header('location:'.$_SERVER['DOCUMENT_ROOT'].'/confi/error.html');
    }

    function shutdown(){
        global $con,$org_DB,$notification_DB;
        $con->close();
        $org_DB->close();
        $notification_DB->close();
    }
    register_shutdown_function('shutdown');

    function filter_input($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function ready_input($input){
        return strtolower(trim($input));
    }
    
?>