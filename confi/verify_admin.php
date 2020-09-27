<?php
    session_start();
    if(!((isset($_SESSION['role'])) && ($_SESSION['role']=='admin'))) {
        header("location:/admin/login.php");
    }