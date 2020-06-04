<?php
    require $_SERVER['DOCUMENT_ROOT']."/includes/header.php";
?>

<!DOCTYPE html>

<html>
    <head>
        <title>Public posts</title>
        <link rel="stylesheet" href="/css_codes/publ.css">
        <script src="https://kit.fontawesome.com/b17fa3a18c.js" crossorigin="anonymous"></script>
    </head>
    <body>

        <script>
            btnPress(3);
        </script>
        <div id=main_body>
            <div id="sub_body">
                <div id="title">
                    Public posts 
                </div>
                <div id=new_post>
                    <form method=post action='http://eme-service.000webhostapp.com/createpost.php' enctype="multipart/form-data">
                        <input type=hidden name=location value=<?php echo $_SERVER['HTTP_REFERER'] ?>>
                        <input type=hidden name=user_nic value=<?php echo $_SESSION['user_nic'] ?>>
                        <textarea id=post_text_area name=post_text_area rows=3 cols=5></textarea>
                        <div id=image_container>
                            <img id='preview'/>
                        </div>
                        <button type=submit id=submit name=submit value=post>POST</button>
                        <div for=upload_file id=upload_file onclick=upload()>Upload photo</div>
                        <input type=file name=upload_file accept="image/*" id=hidden_upload_file style="display:none" onchange="loadFile(event)">
                    </form>
                </div>

                <div id="content">
                    <?php
                        $query='select civilian_detail.first_name, civilian_detail.last_name, organizations.org_name, public_posts.* from ((public_posts LEFT JOIN civilian_detail on public_posts.author = civilian_detail.NIC_num) LEFT JOIN organizations on public_posts.org = organizations.org_id) ORDER BY post_index DESC limit 5';
                        $result=$con->query($query);
                        while($row=$result->fetch_assoc()){
                            echo "<div id='posts'>";
                                echo "<input type='hidden' class='post_index' value='".$row['post_index']."'>";
                                echo "<div id='post_title'>";
                                    $author_nic=$row['author'];
                                    if($author_nic!=$_SESSION['user_nic']){$author=(($con->query("select first_name, last_name from civilian_detail where NIC_num='$author_nic'"))->fetch_assoc());
                                        $author=($row['first_name'] . $row['last_name']) ?: $row['org_name'];
                                    }else{
                                        $author="You";
                                    }
                                    echo "<div id='author'>" . $author . "</div>" . "<div id='post_date'> Date: " . $row['date'] . "</div>";
                                echo "</div>";
                                echo "<div id='post_content'>" . $row['content'] . "</div>";
                                if(!$row['img']==''){
                                    echo "<div id=post_image_container><img id=post_image src='".$row['img']."'/></div>";
                                }
                                $likes = array_filter(explode(" ",$row['likes']));
                                echo    "<div class='like_bar'>
                                            <span class='like_count'>
                                                " . sizeof($likes) . " likes
                                            </span>
                                            <div class='like_buttons_container'>
                                                <button class='like_button' ";
                                                    if((in_array($_SESSION['user_nic'],$likes))){
                                                        echo "onclick='unlike(this)'><i class='fas fa-thumbs-up'></i> liked";
                                                    }else{
                                                        echo "onclick='like(this)'><i class='far fa-thumbs-up'></i> like";
                                                    }
                                echo            "</button>
                                                <button onclick='show_comment(this)'>
                                                <i class='far fa-comment-alt'></i> "
                                                    . $row['comments'] . " comments
                                                </button>
                                                <button>
                                                    <i class='fa fa-share'></i> share
                                                </button>
                                            </div>
                                        </div>
                                        <div class='comment_box_container'>
                                            <div class='comment_box'>
                                            </div>
                                            <div class='new_comment'>
                                                <input type='text' class='comment_input' placeholder='Enter comment here'><span class='send_btn' onclick='comment(this)'>send</span>
                                            </div>
                                        </div>";
                            echo "</div>";
                        }
                    ?>
                </div>
            </div>
            <?php include $_SERVER['DOCUMENT_ROOT']."/includes/side_nav.php" ?>
        </div>
        <script>
            var choose_file = document.getElementById('hidden_upload_file');
            function upload(){
                choose_file.click();
            }
            window.addEventListener('scroll',loadpage);

            var first = true;
            var offset=5;

            function loadpage() {
                //console.log(document.body.scrollTop, document.body.scrollHeight );
                if (document.body.scrollTop > document.body.scrollHeight - window.innerHeight -100 || document.documentElement.scrollTop > document.body.scrollHeight - window.innerHeight -100) {
                    if(first){
                        var body = document.getElementById('content');
                        send_str="from="+offset;

                        var xhttp = new XMLHttpRequest();
                        xhttp.onreadystatechange = function(){
                            if(this.readyState == 4 && this.status == 200){
                                body.querySelector('#page_loader').outerHTML='';
                                if(this.responseText==''){
                                    body.innerHTML += "<div>End of posts</div>";
                                    first = false;
                                }else{
                                    body.innerHTML+= this.responseText;
                                    first = true;
                                }
                            }
                            if(this.readyState == 1){
                                body.innerHTML += "<div class='page_loader' id='page_loader'></div>";
                                first = false;
                            }
                        };
                        xhttp.open('POST', '/publicpost/load_page.php',true);
                        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                        xhttp.send(send_str);

                        
                        offset+=5;
                    }
                }
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
            function like(element){
                var parent = element.parentElement.parentElement.parentElement;
                var post_index = parent.querySelector('.post_index').value;
                var send = "like=true&post_index=".concat(post_index);
                response(send);
                element.outerHTML = " <button class='like_button' onclick='unlike(this)'><i class='fas fa-thumbs-up' aria-hidden='true'></i> liked</button>";
            }
            function unlike(element){
                var parent = element.parentElement.parentElement.parentElement;
                var post_index = parent.querySelector('.post_index').value;
                var send = "unlike=true&post_index=".concat(post_index);
                response(send);
                element.outerHTML = " <button class='like_button' onclick='like(this)'><i class='far fa-thumbs-up' aria-hidden='true'></i> like</button>";
            }
            function show_comment(element){
                var cmt_btn = element.parentElement.parentElement.parentElement.querySelector('.comment_box_container');
                cmt_btn.classList.toggle('comment_box_active');
                var post_index = cmt_btn.parentElement.querySelector('.post_index').value;
                var send = "view_cmt=true&post_index=".concat(post_index);
                response(send,cmt_btn.querySelector('.comment_box'));
            }
            function comment(element){
                var comment = element.parentElement.querySelector('.comment_input').value;
                if(comment!==''){
                    var parent = element.parentElement.parentElement.parentElement;
                    var post_index = parent.querySelector('.post_index').value;
                    send = "comment=true&post_index=".concat(post_index,"&content=",comment);
                    response(send);
                    send = "view_cmt=true&post_index=".concat(post_index);
                    response(send,element.parentElement.previousElementSibling);
                    element.parentElement.firstElementChild.value = '';
                }
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
                xhttp.open('POST', 'public_post_get.php',true);
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send(send_str);
            }
        </script>
    </body>
</html>