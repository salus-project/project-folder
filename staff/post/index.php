<?php
    require $_SERVER['DOCUMENT_ROOT']."/staff/header.php";
?>

<!DOCTYPE html>
<html> 
    <head>
        <title>Posts</title>
        <link rel="stylesheet" href="/staff/css_codes/post.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <script src="https://kit.fontawesome.com/b17fa3a18c.js" crossorigin="anonymous"></script>
        <script src="/staff/post/govpost.js"></script>

        <link rel="stylesheet" href="/css_codes/auto_complete.css">
        <!-- <script src="/common/post/post.js"></script>
        <script src='/common/post/create_post.js'></script> -->

    </head>
    <body>
    
<script>
    btnPress(4);
</script>

    <div id="post_title">
        Posts
    </div>

    <div id=new_post onclick='load_tag_data()'>
        <form method=post action='http://d-c-a.000webhostapp.com/createpost.php' enctype="multipart/form-data" autocomplete="off">
            <input type=hidden name=location value=<?php echo $_SERVER['HTTP_REFERER'] ?>>
            <input type=hidden name=user_nic value=<?php echo $_SESSION['user_nic'] ?>>
            <div class='post_heading'> heading:</div>
            <input type=text name=heading id=heading>
            <div class='post_content'> Content:</div>
            <textarea id=post_text_area name=post_text_area rows=3 cols=5></textarea>
            <div id=image_container>
                <img id='preview' />
            </div>
            <button type=submit id=submit name=submit value=post>POST</button>
            <div for=upload_file id=upload_file class="post_btn" onclick=upload()>Upload photo</div>
            <input type=file name=upload_file accept="image/*" id=hidden_upload_file style="display:none" onchange="loadFile(event)">
            <!--div id=tag_button class="post_btn" onclick='add_tag()'><i class="fa fa-plus-square-o"></i> Tag</div-->
            <div id="tag_container">
                <input id="tag_input_field" type="text" name="tag" placeholder="Search here" placeholder="Search here" spellcheck="false" aria-autocomplete="none">
                <input type="hidden" name="tag_link">
            </div>
        </form>
    </div>



    <div id="content">
    </div>
    <script>
        var post = new Post('<?php echo $_SESSION['user_nic'] ?>');
        post.get_post();
    </script>