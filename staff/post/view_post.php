<?php
    require $_SERVER['DOCUMENT_ROOT']."/staff/header.php";
    $query='select g.*, e.name as event_name from goveposts as g left join disaster_events as e on g.event = e.event_id where post_index='.$_GET['post_index']; 
    $arr=$con->query($query)->fetch_assoc();
?>

<link rel="stylesheet" href="/css_codes/publ.css">
<script src="/govpost/govpost.js"></script>
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
    .comment_box_container {
        display: inline-block;
    }
    .comment_box_active{
        display:inline-block;
    }
    .but_2{
        cursor: auto;
    }
</style>
<?php 
echo "<div class='posts'>
    <input type='hidden' class='post_index' value='".$arr['post_index']."'>
    <div>
        <div class='post_title'>
            <div class='profile'>
                <div class='author post_a'>
                    <b>".$arr['heading']."</b>";
                    if(!$arr['event']==''){
                        echo " <i class='fa fa-toggle-right'></i> for <a class='post_a' href='/event?event_id=".$arr['event']."'>".$arr['event_name']."</a>";
                    }
                    echo "<div class='view_post_div'>
                    <a href='' class='vie_post_a'><button class='view_post_but'>Edit</button></a>
                </div>
        </div>
                <div class='post_date'> Date: ".$arr['date']."</div>
            </div>
        </div>
    </div>
    <div><div class='post_content'>".$arr['content'] ."</div></div>";
    if(!$arr['img']==''){
        echo "<div class=post_image_container><img class=post_image src='http://d-c-a.000webhostapp.com/".$arr['img']."'/></div>";
    }
    $likes = explode(" ",$arr['likes']);
        echo  "<div class='like_bar'>
                    <div class='likes'>
                        <span class='like_count'>"
                            .count($likes). " likes
                        </span>
                    </div>
                    <div class='buttons_container'>
                        
                        <div class='button_div'>
                            <button class='button_con' onclick='show_comment(this)'>
                                <i class='far fa-comment-alt'></i><b>" 
                                    .$arr['comments'] . " comments</b>
                            </button>
                        </div>
                        
                    </div>
                </div>
                <div class='comment_box_container'>
                    <div class='comment_box'></div>
                    <div class='new_comment'>
                        <div class='comment_div'>
                            <input type='text' class='comment_input' placeholder='Enter your comment..'>
                        </div>
                        <div class='tooltip send_icon' onclick='comment(this)'>
                            <span class='send_btn'><i class='fa fa-send'></i></span>
                            <span class='tooltiptext'>SEND</span>
                        </div>
                    </div>
                </div>";
    echo "</div>";
    
?>
<?php include $_SERVER['DOCUMENT_ROOT']."/staff/footer.php" ?>
<script>
    show_comment();
    function show_comment(){
        var cmt_btn = document.querySelector('.comment_box_container');
        cmt_btn.classList.toggle('comment_box_active');
        var post_index = cmt_btn.parentElement.querySelector('.post_index').value;
        var send = "view_cmt=true&post_index=".concat(post_index);
        response(send,cmt_btn.querySelector('.comment_box'));
    }
    function response(send_str,element){
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
                if(typeof element !== 'undefined'){
                    element.innerHTML =  this.responseText;
                }
            }
        };
        xhttp.open('POST', '/govpost/govpost_action_ajax.php',true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send(send_str);
    }
</script>
