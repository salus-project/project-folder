<?php
require $_SERVER['DOCUMENT_ROOT'] . "/includes/header.php";
?>

<title>Public posts</title>
<link rel="stylesheet" href="/css_codes/publ.css">
<link rel="stylesheet" href="/css_codes/auto_complete.css">
<script src="https://kit.fontawesome.com/b17fa3a18c.js" crossorigin="anonymous"></script>
<script src="/common/post/post.js"></script>
<script src='/common/post/create_post.js'></script>

<script>
    btnPress(3);
</script>
<div id="post_title">
    POSTS
</div>
<div id='new_post'>
    <!--form method=post action='/common/documents/createpost.php' enctype="multipart/form-data" autocomplete="off">
        <input type=hidden name=location value=<?php echo $_SERVER['HTTP_REFERER'] ?>>
        <input type=hidden name=user_nic value=<?php echo $_SESSION['user_nic'] ?>>
        <textarea id=post_text_area name=post_text_area rows=3 cols=5></textarea>
        <div id=image_container>
            <img id='preview' />
        </div>
        <button type=submit id=submit name=submit value=post>POST</button>
        <div for=upload_file id=upload_file class="post_btn" onclick=upload()>Upload photo</div>
        <input type=file name=upload_file accept="image/*" id=hidden_upload_file style="display:none" onchange="loadFile(event)">
        <div id="tag_container">
            <input id="tag_input_field" type="text" name="tag" placeholder="Search here" placeholder="Search here" spellcheck="false" aria-autocomplete="none">
            <input type="hidden" name="tag_link">
        </div>
    </form-->
</div>

<div id="content">

</div>
 
<?php include $_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php" ?>
<script>
    var newPost = new NewPost('individual', '<?php echo $_SESSION['user_nic'] ?>');
    var post = new Post('select civilian_detail.first_name, civilian_detail.last_name, organizations.org_name, fundraisings.name, public_posts.* from (((public_posts LEFT JOIN civilian_detail on public_posts.author = civilian_detail.NIC_num) LEFT JOIN organizations on public_posts.org = organizations.org_id)  LEFT JOIN fundraisings on public_posts.fund = fundraisings.id)');
    post.get_post();
</script>