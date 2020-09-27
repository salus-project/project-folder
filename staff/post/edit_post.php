<link rel="stylesheet" href="/css_codes/publ.css">
<link rel="stylesheet" href="/staff/css_codes/post.css">
<script src='/common/autocomplete/auto_complete.js'></script>
<link rel='stylesheet' type='text/css' href='/common/autocomplete/auto.css'>
<style>
    .post_content, .post_heading{
        margin: 2px 20px 0px 10px;
    }
    .posts{
        width: 700px;
        min-height:400px;
    }
    .posts:hover{
        transform: scale(1);
    }
    #post_text_area:active{
        margin:0 20px 0 20px;
        border: 2px solid #d8e0e7;
    }
    #post_text_rea{
        border: 2px solid #d8e0e7; 
    }
    .img_edit{
        position: relative;
    }
    .edit_post_btn{
        border: 1px solid #ccc;
        height: 30px;
        width: 150px;
        border-radius: 12px;
        line-height: 1;
        padding: 6px 8px 7px;
        text-align: center;
        font-size: 14px;
        margin: 5px 0;
        cursor: pointer;
        color: #6b7c93;
        background: white;
    }
    .del_btn{
        position: absolute;
        top: 317px;
        left: 25px;
    }
    #tag_container {
        display: block;
    }
    .posts {
        width: 700px;
        min-height: 400px;
    }
    .posts {
        display: table;
    }
    #tag_input_field{
        width: 97%;
        height: 40px;
        font-size: 16px;
        margin: 8px;
        resize: none;
        outline: none;
        border: 1px solid #d8e0e7;
        font-family: open Sans, sans-serif;
        color: #6b7c93;
    }
</style> 
  
<?php
    ob_start();
    ignore_user_abort();

    require $_SERVER['DOCUMENT_ROOT']."/staff/header.php";
    $post_index=$_GET['post_index'];
    $query='select g.*, e.name as event_name from goveposts as g left join disaster_events as e on g.event = e.event_id where post_index='.$_GET['post_index']; 
    $arr=$con->query($query)->fetch_assoc();

   /* if($view_result['author']  != $_SESSION['user_nic']){
        header("location:".(isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] :"/publicpost/"));
        ob_end_flush();
        ob_flush();
        flush();
    }*/

    echo "<div class='posts'>";
            echo"<form action='/common/documents/govpost.php' method='post' style='display: inline-block;width: 100%;border: 1px solid #d8e0e7;padding: 5px;margin-top: 5px;'>
                    <input type='hidden' name='post_index' class='post_index' value='".$post_index."'>
                    <div class='post_heading'> heading:</div>
                    <input type='text' name='heading' id='heading' value='".$arr['heading']."'>
                    <div class='post_content'> Content:</div>
                    <textarea id='post_text_area' name='content' rows=3 cols=5>".$arr['content'] ."</textarea>
                    <div class='post_content'> Event:</div>
                    <div>
                        <input type='hidden' name='event' value='".$arr['event']."'>
                        <input id='tag_input_field' type='text' placeholder='Tag an event' spellcheck='false' aria-autocomplete='none' value='".$arr['event_name']."'>
                    </div>
                <button type='submit' class='edit_post_btn' style='float: right; display: inline-block;' name='update' value='1'>Save changes</button>
            </form>
            <form action='/common/documents/govpost.php' method='post'>
                <input type='hidden' name='post_index' value='".$post_index."'>
                <button type='submit' class='edit_post_btn del_btn' name='delete' value='1'>Delete Post</button>
            </form>";

            ?>
            
        <?php
                if(!$arr['img']==''){
                echo "<div class='img_edit'>";
                    echo "<div id=image_container>  
                            <img id='preview'/ src='/common/documents/gov_posts/".$arr['img'].".jpg'/>
                        </div>
                        <div for=upload_file id='change_img_btn' class='edit_post_btn' onclick='document.getElementById(\"change_img\").click()' style='display: inline-block;'><i class='fa fa-camera' aria-hidden='true'></i>Change photo</div>
                        <form method='post' action='/common/documents/upload.php' enctype='multipart/form-data' id=upload_profile_form style='display: inline-block;'>
                            <input type='file' name='upload_file' accept='image/jpeg' id='change_img' style='display:none' onchange='this.parentElement.submit()'>
                            <input type='hidden' name='directory' value='gov_posts/'>
                            <input type='hidden' name='filename' value='".$arr['img']."'>
                            <input type='hidden' name='header' value='true'>
                            <input type='hidden' name='resize' value='false'>
                        </form>
                        
                        <div id='remove_img' class='edit_post_btn' onclick='document.getElementById(\"remove_img_form\").submit()' style='float: right; display: inline-block;'><i class='fas fa-trash-alt' aria-hidden='true'></i>Remove photo</div>
                        <form method='post' action='/common/documents/post_remove_img.php' id='remove_img_form'>
                            <input type='hidden' name='file' value='".$arr['img']."'>
                            <input type='hidden' name='post_id' value='".$arr['post_index']."'>
                            <input type='hidden' name='remove' value='1'>
                        </form>
                    </div>";
                }
    echo "</div>";

?>
<script>
    autocomplete_ready(document.getElementById("tag_input_field"),  'events', 'ready', 'set_id');

    var choose_file = document.getElementById('hidden_upload_file');
    function upload(){
        choose_file.click();
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
<?php include $_SERVER['DOCUMENT_ROOT'] . "/staff/footer.php" ?>