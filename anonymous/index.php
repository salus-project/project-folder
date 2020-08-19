<?php
    require $_SERVER['DOCUMENT_ROOT']."/anonymous/ano_header.php";
?>
<link rel="stylesheet" href="/css_codes/publ.css">
<script src="https://kit.fontawesome.com/b17fa3a18c.js" crossorigin="anonymous"></script>
<script src="/govpost/govpost.js"></script>

<div id="post_title">
    Goverment posts
</div>
<div id="content">
</div>

<script>
    btnPress(2);
    var post = new Post('<?php echo isset($_SESSION['user_nic'])?$_SESSION['user_nic']:'' ?>');
    post.get_post();
</script>
