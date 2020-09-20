<?php
    //error_reporting(0);
    try{
        $con = new mysqli("remotemysql.com","kfm2yvoF5R","4vkzHfeBh6");
        if($con->connect_error){
            die('Unable to connect ' . $con->connect_error);
        }else{
            echo 'success';
        }
        //or die('Unable to connect ' . $con->connect_error)/*header('location:'.$_SERVER['DOCUMENT_ROOT'].'/confi/error.html')*/;
        mysqli_select_db($con,"kfm2yvoF5R");
    }catch(Exception $e){
        //header('location:'.$_SERVER['DOCUMENT_ROOT'].'/confi/error.html');
    }

    function shutdown(){
        global $con;
        $con->close();

        ob_end_flush();
    }
    register_shutdown_function('shutdown');

    function filt_inp($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function ready_input($input){
        return strtolower(trim($input));
    }
    
?>