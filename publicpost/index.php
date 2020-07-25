<?php
    require $_SERVER['DOCUMENT_ROOT']."/includes/header.php";
?>

        <title>Public posts</title>
        <link rel="stylesheet" href="/css_codes/publ.css">
        <link rel="stylesheet" href="/css_codes/auto_complete.css">
        <script src="https://kit.fontawesome.com/b17fa3a18c.js" crossorigin="anonymous"></script>
        <script src="/common/post/post.js"></script>

        <script>
            btnPress(3);
        </script>
        <div id="post_title">
            POSTS 
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

            var post = new Post('select civilian_detail.first_name, civilian_detail.last_name, organizations.org_name, fundraisings.name, public_posts.* from (((public_posts LEFT JOIN civilian_detail on public_posts.author = civilian_detail.NIC_num) LEFT JOIN organizations on public_posts.org = organizations.org_id)  LEFT JOIN fundraisings on public_posts.fund = fundraisings.id)');
            post.get_post();

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
