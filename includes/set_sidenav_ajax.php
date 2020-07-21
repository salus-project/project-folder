<?php
require_once $_SERVER['DOCUMENT_ROOT']."/confi/verify.php";
$_SESSION['side_nav']= $_POST['side_nav'];
echo $_SESSION['side_nav'];