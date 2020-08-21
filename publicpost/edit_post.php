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
#post_text_area{
    border: 2px solid #d8e0e7; 
}
.img_edit{
    position: relative;
}
.post_btn{
    margin-left: 550px;
    margin-top: 10px;
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
                                if(!$view_result['tag']==''){
                                    echo " <i class='fa fa-toggle-right'></i> ".$view_result['tag'];
                                }
                        echo "</div>
                        <div class='post_date'> Date: {$view_result['date']}</div>
                    </div>";
                echo"</div>
            </div>";
                echo"<div>
                    <div class='post_content'><textarea id=post_text_area name=post_text_area rows=3 cols=5>". $view_result['content']."</textarea></div>
                </div>";
                if(!$view_result['img']==''){
                echo "<div class='img_edit'>";
                    echo "<div id=image_container>  
                            <img id='preview'/ src='".$view_result['img']."'/>
                        </div>
                        <div for=upload_file id='change_img_btn' class='post_btn' onclick='document.getElementById(\"change_img\").click()'>Change photo</div>
                        <form method='post' action='http://d-c-a.000webhostapp.com/upload.php' enctype='multipart/form-data' id=upload_profile_form>
                            <input type='file' name='upload_file' accept='image/jpeg' id='change_img' style='display:none' onchange='this.parentElement.submit()'>
                            <input type='hidden' name='directory' value='public_posts/'>
                            <input type='hidden' name='filename' value='".explode('.jpg',(explode('http://d-c-a.000webhostapp.com/public_posts/',$view_result['img'])[1]))[0]."'>
                            <input type='hidden' name='header' value='true'>
                            <input type='hidden' name='resize' value='false'>
                        </form>
                        
                        <div id='remove_img' class='post_btn' onclick='document.getElementById(\"remove_img_form\").submit()'>Remove photo</div>
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
<?php include $_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php" ?>