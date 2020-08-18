<?php
    session_start();
    if(!isset($_SESSION['user_nic'])){
        header("location:/anonymous?location=".$_SERVER['REQUEST_URI']);
    }