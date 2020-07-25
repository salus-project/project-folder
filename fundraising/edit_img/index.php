<?php require $_SERVER['DOCUMENT_ROOT']."/includes/header.php";
    $id=intval($_GET['id']);
    $query="select * from fundraisings where id=".$id;
    $result=($con->query($query))->fetch_assoc();

    $id=$result['id'];
    $fundraising_name=$result['name'];
    $imgs=explode(',',$result['img']);
?>

<?php include $_SERVER['DOCUMENT_ROOT']."/includes/footer.php" ?>