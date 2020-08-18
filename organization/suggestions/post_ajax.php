<?php
require_once $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";
require_once $_SERVER['DOCUMENT_ROOT']."/confi/verify.php";

$org_DB = OrgDb::getConnection();

$sql=$_POST['sql'];
$result=$org_DB->query($sql);
?>