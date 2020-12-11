<!DOCTYPE html>
<html>
    <head>
        <title>view organization</title>
        <link rel="stylesheet" href='/css_codes/view_org.css'>
        <link rel="stylesheet" href='/css_codes/publ.css'>
    </head>
    <body>
        <?php require 'view_org_header.php' ?>
        
        <div id='org_body'>
            
            <table class='view_org_table'>
                <tr>
                    <td>leader</td>
                    <td><?php echo $result['leader'] ?></td>
                </tr>
                <tr>
                    <td>District</td>
                    <td><?php echo $result['district'] ?></td>
                </tr>
                <tr>
                    <td>Contact email</td>
                    <td><?php echo $result['email'] ?></td>
                </tr>
                <tr>
                    <td>Contact number</td>
                    <td><?php echo $result['phone_num'] ?></td>
                </tr>
            </table>
        </div>

<!-- post part should modify  -->
        <div id="title">
            Posts 
        </div>

        <div id="content">
            <?php
                $org_id = $_GET['selected_org'];
                $query="select * from public_posts  WHERE org='$org_id'  ORDER BY post_index DESC";
                $result=$con->query($query);
                while($row=$result->fetch_assoc()){
                    echo "<div id='posts'>";
                        echo "<input type='hidden' class='post_index' value='".$row['post_index']."'>";
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
        <?php include $_SERVER['DOCUMENT_ROOT']."/includes/footer.php" ?>
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
<!-- end of post part-->

    </body>

</html>