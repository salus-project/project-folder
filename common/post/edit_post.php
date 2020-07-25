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
    require $_SERVER['DOCUMENT_ROOT']."/includes/header.php";
    $post_index=$_GET['post_index'];
    $view_query="select public_posts.*,civilian_detail.first_name,civilian_detail.last_name from public_posts inner join civilian_detail on public_posts.author=civilian_detail.NIC_num where public_posts.post_index=".$post_index;
    //echo $view_query;
    $view_result=mysqli_query($con,$view_query)->fetch_assoc();
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
            echo "<form>";
                echo"<div>
                    <div class='post_content'><textarea id=post_text_area name=post_text_area rows=3 cols=5>". $view_result['content']."</textarea></div>
                </div>";
                if(!$view_result['img']==''){
                echo "<div class='img_edit'>";
                    echo "<div id=image_container>  
                            <img id='preview'/ src='".$view_result['img']."'/>
                        </div>
                        <div for=upload_file id=upload_file class='post_btn' onclick=upload()>Change photo</div>
                        <input type=file name=upload_file accept='image/*' id=hidden_upload_file style='display:none' onchange='loadFile(event)'>
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