<?php
    ob_start();
    if($_SERVER['REQUEST_METHOD']=='POST'){
      $copy = copy( $_POST['from'], $POST['to'] );
      header("location:".$_SERVER['HTTP_REFERER']);
    }
    ob_end_flush();
    ob_flush();
    flush();