<?php
    require $_SERVER['DOCUMENT_ROOT']."/includes/header.php";
?>

<title>Goverment posts</title>
<link rel="stylesheet" href="/css_codes/publ.css">
<script src="https://kit.fontawesome.com/b17fa3a18c.js" crossorigin="anonymous"></script>
<script src="/govpost/govpost.js"></script>


<script>
    btnPress(2);
</script>
<div id="post_title">
    Goverment posts
</div>
<div id="content">
</div>
<script>
    var post = new Post('<?php echo $_SESSION['user_nic'] ?>');
    post.get_post();
</script>
<?php include $_SERVER['DOCUMENT_ROOT']."/includes/footer.php" ?>
