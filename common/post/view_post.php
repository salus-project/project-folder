<?php
    require $_SERVER['DOCUMENT_ROOT']."/includes/header.php";
?>
   <link rel="stylesheet" href="/css_codes/publ.css">
    <script src="https://kit.fontawesome.com/b17fa3a18c.js" crossorigin="anonymous"></script>
    <script src="/common/post/post.js"></script>
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
        $post_index=$_GET['post_index'];
        $query="select * from public_posts where post_index=".$post_index;
    // echo $query;
        $result=mysqli_query($con,$query)->fetch_assoc();

        if($result['type']=='organization'){
            $view_query="select public_posts.*,organizations.org_name from public_posts inner join organizations on public_posts.org=organizations.org_id where public_posts.post_index=".$post_index;
        // echo $view_query;
            $view_result=mysqli_query($con,$view_query)->fetch_assoc();
            $author = $view_result['org_name'];
            $author_link = "/organization?selected_org=".$view_result['org'];
            $profile_url = '';
        
        }elseif($result['type']=='fundraising'){
            $view_query="select public_posts.*,fundraisings.name from public_posts inner join fundraisings on public_posts.fund=fundraisings.id where public_posts.post_index=".$post_index;
            //echo $view_query;
            $view_result=mysqli_query($con,$view_query)->fetch_assoc();
            $author = $view_result['name'];
            $author_link = "/fundraising/view_fundraising.php?view_fun=".$view_result['fund'];
            $profile_url = '';
        }elseif($result['type']=='individual'){
            $view_query="select public_posts.*,civilian_detail.first_name,civilian_detail.last_name from public_posts inner join civilian_detail on public_posts.author=civilian_detail.NIC_num where public_posts.post_index=".$post_index;
            //echo $view_query;
            $view_result=mysqli_query($con,$view_query)->fetch_assoc();
            $author = $view_result['first_name']. " ".$view_result['last_name'];
            $author_link = "/view_profile.php?id=".$view_result['author'];
            $profile_url = "http://d-c-a.000webhostapp.com/Profiles/resized/".$view_result['author'].".jpg";
        }
        echo "<div class='posts'>
                <input type='hidden' class='post_index' value='".$post_index."'>
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
                        if($view_result['author']==$_SESSION['user_nic']){
                            echo "<div class='view_post_div'>
                                <a href='/common/post/edit_post.php?post_index=".$post_index."' class='vie_post_a'><button class='view_post_but'>Edit</button></a>
                            </div>";
                        }
                echo"</div>
                </div>";
            echo"<div>
                    <div class='post_content'>" . $view_result['content'] . "</div>
                </div>";
                if(!$view_result['img']==''){
                    echo "<div class=post_image_container><img class=post_image src='".$view_result['img']."'/></div>";
                }
                $likes = array_filter(explode(" ",$view_result['likes']));
        echo    "<div class='like_bar'>
                    <div class='likes'>
                        <span class='like_count'>
                            " . sizeof($likes) . " likes
                        </span>
                    </div>
                    <div class='buttons_container'>
                        <div class='button_div'>
                            <button class='button_con  but_1_2' ";
                                if((in_array($_SESSION['user_nic'],$likes))){
                                    echo "onclick='unlike(this)' style='color:#4c5fd7'><i class='fas fa-thumbs-up' style='color:#4c5fd7'></i><b> liked</b>";
                                }else{
                                    echo "onclick='like(this)'><i class='far fa-thumbs-up'></i> <b>like</b>";
                                }
        echo                "</button>
                        </div>
                        <div class='button_div'>
                            <button class='button_con  but_1_2 but_2'>
                                <i class='far fa-comment-alt'></i><b> "
                                . $view_result['comments'] . " comments</b>
                            </button>
                        </div>
                        <div class='button_div'>
                            <button class='button_con  but_3'>
                                <i class='fa fa-share'></i><b> share</b>
                            </button>
                        </div>                           
                    </div>
                </div>
                <div class='comment_box_container'>
                    <div class='comment_box'>

                    </div>
                        <div class='new_comment'>
                            <div class='comment_div'>
                                <input type='text' class='comment_input' placeholder='Enter your comment..' required>
                            </div>
                            <div class='tooltip send_icon' onclick='comment(this)'>
                                <span class='send_btn'><i class='fa fa-send'></i></span>
                                <span class='tooltiptext'>SEND</span>
                            </div>
                        </div>
                    
                </div>";
    echo    "</div>";
?>
<script>
show_comment();
    function show_comment(){
        var cmt_btn = document.querySelector('.comment_box_container');
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
    xhttp.open('POST', '/common/post/post_event_ajax.php',true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(send_str);
}
</script>