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
        <script src="/govpost/govpost.js"></script>

        <script src='/common/autocomplete/auto_complete.js'></script>
        <link rel='stylesheet' type='text/css' href='/common/autocomplete/auto.css'>
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

    <div id='new_post'>
        <form method=post action='http://d-c-a.000webhostapp.com/govpost.php' enctype="multipart/form-data" autocomplete="off">
            <input type='hidden' name='location' value='<?php echo $_SERVER['HTTP_REFERER'] ?>'>
            <input type='hidden' name='user_nic' value='<?php echo $_SESSION['user_nic'] ?>'>
            <div class='post_heading'> heading:</div>
            <input type='text' name='heading' id='heading'>
            <div class='post_content'> Content:</div>
            <textarea id='post_text_area' name='content' rows=3 cols=5></textarea>
            <div id='image_container'>
                <img id='preview' />
            </div>
            <button type='submit' id='submit' name='post' value='post'>POST</button>
            <div for=upload_file id=upload_file class="post_btn" onclick=upload()>Upload photo</div>
            <input type=file name=upload_file accept="image/*" id=hidden_upload_file style="display:none" onchange="loadFile(event)">
            <!--div id=tag_button class="post_btn" onclick='add_tag()'><i class="fa fa-plus-square-o"></i> Tag</div-->
            <div id="tag_container">
                <input type="hidden" name="event">
            </div>
        </form>
    </div>



    <div id="content">
    </div>
    <?php include $_SERVER['DOCUMENT_ROOT']."/staff/footer.php" ?>
    <script>
        autocomplete_ready(document.getElementById("tag_container"), 'events', document.getElementById("new_post"), 'set_id');
        var post = new Post('staff');
        post.get_post();

        function upload(){
            document.getElementById('hidden_upload_file').click();
        }

        var loadFile = function(event){
            var output = document.getElementById('preview');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function(){
                URL.revokeObjectURL(output.src)
                setHeight();
            }
        };
        function setHeight(img){
            
            document.getElementById('image_container').style.margin = "10px";
            //document.getElementById('image_container').style.height = img.height;
        }
    </script>