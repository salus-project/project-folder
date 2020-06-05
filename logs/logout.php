<?php
    session_start();
    if(isset($_POST['logout'])){
        echo 'logout';
        session_unset();
        session_destroy();
        $_SESSION = [];
        header('location:/logs/login.php');
    }