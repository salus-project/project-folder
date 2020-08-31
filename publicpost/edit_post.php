<link rel="stylesheet" href="/css_codes/publ.css">
<style>
    .post_content{
        margin: 10px 20px 10px 20px;
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
    .edit_post_btn:hover{
        background:#0c7dff47;
    }
    .del_btn{
        position: absolute;
        top: 238px;
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
</style> 
  
<?php
    ob_start();
    ignore_user_abort();

    require $_SERVER['DOCUMENT_ROOT']."/includes/header.php";
    $post_index=$_GET['post_index'];
    $view_query="select public_posts.*,civilian_detail.first_name,civilian_detail.last_name from public_posts inner join civilian_detail on public_posts.author=civilian_detail.NIC_num where public_posts.post_index=".$post_index;
    //echo $view_query;
    $view_result=mysqli_query($con,$view_query)->fetch_assoc();

    if($view_result['author']  != $_SESSION['user_nic']){

        header("location:".(isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] :"/publicpost/"));
        ob_end_flush();
        ob_flush();
        flush();
    }

    $author = $view_result['first_name']. " ".$view_result['last_name'];
    $author_link = "/view_profile.php?id=".$view_result['author'];
    $profile_url = "http://d-c-a.000webhostapp.com/Profiles/resized/".$view_result['author'].".jpg";
    
    echo "<div class='posts'>
            <input type='hidden' name='post_index' class='post_index' value='".$post_index."'>
            <div>  
                <div class='post_title'>".
                    "<div class='post_profile_pic'>
                        <img src='".$profile_url."' alt='pic'>
                    </div>
                    <div class='profile'>
                        <div class='author'>
                            <a class='post_a' href='".$author_link."'><b>". $author ."</b></a>";
                        echo "</div>
                        <div class='post_date'> Date: {$view_result['date']}</div>
                    </div>";
                echo"</div>
            </div>";
            echo"<form action='http://d-c-a.000webhostapp.com/createpost.php' method='post' style='display: inline-block;width: 100%;border: 1px solid #d8e0e7;padding: 5px;margin-top: 5px;'>
                <input type='hidden' name='post_index' value='".$view_result['post_index']."'>
                <div>
                    <div class='post_content'><textarea id=post_text_area name=post_text_area rows=3 cols=5>". $view_result['content']."</textarea></div>
                </div>
                <div id='tag_container' style='position: relative;margin: 0 35px 10px 35px;border: 1px solid #d8e0e7;'>";
                    $tag='';
                    if(!$view_result['tag']==''){
                        $tag=$view_result['tag'];
                    }
                    echo "<input type='hidden' name='tag_link' value='".$view_result['tag_link']."'>
                    <input id='tag_input_field' type='text' name='tag' placeholder='Add Tag' spellcheck='false' aria-autocomplete='none' value='".$tag."' oninput='tag_inp(this)'>
                </div>
                <button type='submit' class='edit_post_btn save_btn' style='float: right; display: inline-block;' name='update' value='1'>Save changes</button>
            </form>
            <form action='http://d-c-a.000webhostapp.com/createpost.php' method='post'>
                <input type='hidden' name='post_index' value='".$view_result['post_index']."'>
                <button type='submit' class='edit_post_btn del_btn' name='delete' value='1'>Delete Post</button>
            </form>";
            ?>
            
        <?php
                if(!$view_result['img']==''){
                echo "<div class='img_edit'>";
                    echo "<div id=image_container>  
                            <img id='preview'/ src='".$view_result['img']."'/>
                        </div>
                        <div for=upload_file id='change_img_btn' class='edit_post_btn' onclick='document.getElementById(\"change_img\").click()' style='display: inline-block;'><i class='fa fa-camera' aria-hidden='true'></i>Change photo</div>
                        <form method='post' action='http://d-c-a.000webhostapp.com/upload.php' enctype='multipart/form-data' id=upload_profile_form style='display: inline-block;'>
                            <input type='file' name='upload_file' accept='image/jpeg' id='change_img' style='display:none' onchange='this.parentElement.submit()'>
                            <input type='hidden' name='directory' value='public_posts/'>
                            <input type='hidden' name='filename' value='".explode('.jpg',(explode('http://d-c-a.000webhostapp.com/public_posts/',$view_result['img'])[1]))[0]."'>
                            <input type='hidden' name='header' value='true'>
                            <input type='hidden' name='resize' value='false'>
                        </form>
                        
                        <div id='remove_img' class='edit_post_btn' onclick='document.getElementById(\"remove_img_form\").submit()' style='float: right; display: inline-block;'><i class='fas fa-trash-alt' aria-hidden='true'></i>Remove photo</div>
                        <form method='post' action='http://d-c-a.000webhostapp.com/post_remove_img.php' id='remove_img_form'>
                            <input type='hidden' name='file' value='".explode('http://d-c-a.000webhostapp.com/public_posts/',$view_result['img'])[1]."'>
                            <input type='hidden' name='post_id' value='".$view_result['post_index']."'>
                            <input type='hidden' name='remove' value='1'>
                        </form>
                    </div>";
                }
    echo "</div>";

?>
<script>
    autocomplete_ready(document.getElementById("tag_input_field"), 'all', 'ready');

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
    function tag_inp(ele){
        if(ele.value===''){
            ele.previousElementSibling.value='';
        }
    }
</script>
<?php include $_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php" ?>