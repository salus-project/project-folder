<?php
    session_start();
    if(!((isset($_SESSION['role'])) && ($_SESSION['role']=='staff'))) {
        header("location:/staff/login.php");
    }