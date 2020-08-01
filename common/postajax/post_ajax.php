<?php
require_once $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";
require_once $_SERVER['DOCUMENT_ROOT']."/confi/verify.php";

$sql=$_POST['sql'];
$result=$con->query($sql);
echo $sql;

?>