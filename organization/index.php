<?php 
    require 'view_org_header.php';
    $org_id = $_GET['selected_org'];
?>
<!DOCTYPE html>
<html>
    <head>
        <title>view organization</title>
        <link rel="stylesheet" href='/css_codes/view_org.css'>
        <link rel="stylesheet" href='/css_codes/publ.css'>
        <script src="https://kit.fontawesome.com/b17fa3a18c.js" crossorigin="anonymous"></script>
        <script src="/common/post/post.js"></script>
    </head>
    <body>
        <div id="my_posts">
            OUR POSTS 
        </div>
        <div >
            <?php $viewer->show_post_button(); ?>
        </div>
        
        <div id="content">

        </div>
        <script>
            var post = new Post("select public_posts.*,organizations.org_name from public_posts inner join organizations on public_posts.org=organizations.org_id where public_posts.org="+<?php echo $org_id?>);
            post.get_post();
        </script>
        <?php require $_SERVER['DOCUMENT_ROOT']."/organization/org_footer.php"; ?>
    </body>
</html>