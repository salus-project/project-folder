<?php
    session_start();
    require 'dbconfi/confi.php'
?>

<!DOCTYPE html>

<html>
    <head>
        <title>Public posts</title>
        <link rel="stylesheet" href="css_codes/publ.css">
    </head>
    <body>
        <?php require "header.php" ?>

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
                <div for=upload_file id=upload_file onclick=upload()>Upload photo</div>
                <input type=file name=upload_file accept="image/*" id=hidden_upload_file style="display:none" onchange="loadFile(event)">
            </form>
        </div>

        <div id="content">
            <?php
                $query='select * from public_posts ORDER BY post_index DESC';
                $result=$con->query($query);
                while($row=$result->fetch_assoc()){
                    echo "<div id='posts'>";
                        echo "<div id='post_title'>";
                            $author_nic=$row['author'];
                            if($author_nic!=$_SESSION['user_nic']){
                                $author=(($con->query("select first_name, last_name from civilian_detail where NIC_num='$author_nic'"))->fetch_assoc());
                                $author=$author['first_name'] . $author['last_name'];
                            }else{
                                $author="You";
                            }
                            echo "<div id='author'>" . $author . "</div>" . "<div id='post_date'> Date: " . $row['date'] . "</div>";
                        echo "</div>";
                        echo "<div id='post_content'>" . $row['content'] . "</div>";
                        if(!$row['img']==''){
                            echo "<div id=post_image_container><img id=post_image src='".$row['img']."'/></div>";
                        }
                    echo "</div>";
                }
            ?>
        </div>
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
    </body>
</html>