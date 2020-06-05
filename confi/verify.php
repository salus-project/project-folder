<?php
    session_start();
    if(!isset($_SESSION['user_nic'])){
        header("location:/logs/login.php");
    }