<?php
    require $_SERVER['DOCUMENT_ROOT']."/includes/header.php";
?>

<!DOCTYPE html>

<html>
    <head>
        <title>Public posts</title>
        <link rel="stylesheet" href="/css_codes/publ.css">
        <link rel="stylesheet" href="/css_codes/auto_complete.css">
        <script src="https://kit.fontawesome.com/b17fa3a18c.js" crossorigin="anonymous"></script>
    </head>
    <body>

        <script>
            btnPress(3);
        </script>
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
                <div for=upload_file id=upload_file class="post_btn" onclick=upload()>Upload photo</div>
                <input type=file name=upload_file accept="image/*" id=hidden_upload_file style="display:none" onchange="loadFile(event)">
                <div id=tag_button class="post_btn" onclick=add_tag()><i class="fa fa-plus-square-o"></i> Tag</div>
                <div id="tag_container">
                    <div id="tag_inner_container">
                        <div id="tag_topic_container">
                            <select name="tag_topic" class='post_select' onchange="change_tag_topic(this)">
                                <option value="event">Event</option>
                                <option value="organization">Organization</option>
                                <option value="fundraising">Fundraising</option>
                                <option value="person">Person</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div id="tag_content">

                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div id="content">

        </div>
        <?php include $_SERVER['DOCUMENT_ROOT']."/includes/footer.php" ?>
        <script>
            var choose_file = document.getElementById('hidden_upload_file');
            function upload(){
                choose_file.click();
            }
            window.addEventListener('scroll',loadpage);

            var first = true;
            var offset=0;
            get_post();

            function loadpage() {
                //console.log(document.body.scrollTop, document.body.scrollHeight );
                if (document.body.scrollTop > document.body.scrollHeight - window.innerHeight -100 || document.documentElement.scrollTop > document.body.scrollHeight - window.innerHeight -100) {
                    if(first){
                        get_post();
                    }
                }
            }

            function get_post(){
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
                var parent = element.parentElement.parentElement.parentElement.parentElement;
                var post_index = parent.querySelector('.post_index').value;
                var send = "like=true&post_index=".concat(post_index);
                response(send);
                element.outerHTML = " <button class='button_con  but_1_2' onclick='unlike(this)'><i class='fas fa-thumbs-up' aria-hidden='true'></i><b> liked</b></button>";
            }
            function unlike(element){
                var parent = element.parentElement.parentElement.parentElement.parentElement;
                var post_index = parent.querySelector('.post_index').value;
                var send = "unlike=true&post_index=".concat(post_index);
                response(send);
                element.outerHTML = " <button class='button_con but_1_2' onclick='like(this)'><i class='far fa-thumbs-up' aria-hidden='true'></i><b> like</b></button>";
            }
            function show_comment(element){
                var cmt_btn = element.parentElement.parentElement.parentElement.parentElement.querySelector('.comment_box_container');
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
            function add_tag(){
                //frsrgrsrfvgv
            }
            function change_tag_topic(topic){
                if(topic.value != 'other'){
                    require_tag(topic.value);
                }else{
                    var tag_content = document.getElementById("tag_content");
                    tag_content.innerHTML="<input type='text' name='tag_content' class='post_input inner' placeholder='Enter Tag'>" +
                        "<input type='text' name='tag_content' class='post_input inner' placeholder='link'>"
                }
            }
            function require_tag(tag_topic){
                send_str="topic="+tag_topic;
                console.log(send_str);
                var tag_content = document.getElementById("tag_content");

                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function(){
                    if(this.readyState == 4 && this.status == 200){
                        tag_content.innerHTML=this.responseText;
                    }
                    if(this.readyState == 1){
                        tag_content.innerHTML='Wait';
                    }
                };
                xhttp.open('POST', '/publicpost/add_tag.php',true);
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send(send_str);
            }
        </script>
        <script src="/js/auto_complete.js"></script>
    </body>
</html>