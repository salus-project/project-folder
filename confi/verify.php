<?php
    session_start();
    if (!((isset($_SESSION['role'])) && ($_SESSION['role'] =='civilian'))) {
        header("location:/anonymous?location=".$_SERVER['REQUEST_URI']);
    }