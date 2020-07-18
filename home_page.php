<?php
    require $_SERVER['DOCUMENT_ROOT']."/includes/header.php";
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Home Page</title>
        <link rel="stylesheet" href="css_codes/homePage.css">
        

    </head>

    <body>

        <script>
            btnPress(1);
        </script>
        <div class="title">
            <div id='cover'>
                <?php
                    $cover_path = "http://d-c-a.000webhostapp.com/Covers/" . $_SESSION['user_nic'] . ".jpg";
                    $cover_path_header = get_headers($cover_path);
                    if($cover_path_header[0] != 'HTTP/1.1 200 OK'){
                        $cover_path = "http://d-c-a.000webhostapp.com/Covers/default.jpg";
                    }
                ?>
                <img id="cover_photo" src="<?php echo $cover_path;?>" alt="Opps..." class="cover_pic">
                <form method='post' action="http://d-c-a.000webhostapp.com/upload.php" enctype="multipart/form-data" id=upload_cover_form>

                    <input type=file name=upload_file accept="image/jpeg" id=upload_cover_btn style="display:none" onchange="this.parentElement.submit()">
                    <input type=hidden name="directory" value="Covers/">
                    <input type=hidden name="filename" value="<?php echo $_SESSION['user_nic']?>">
                    <input type=hidden name="header" value="true">
                </form>
                <button id='edit_cover' onclick="document.getElementById('upload_cover_btn').click()">Change</button>
            </div>
            <div class="profile_container">
                <?php
                    $profile_path = "http://d-c-a.000webhostapp.com/Profiles/" . $_SESSION['user_nic'] . ".jpg";
                    $profile_path_header = get_headers($profile_path);
                    if($profile_path_header[0] != 'HTTP/1.1 200 OK'){
                        $profile_path = "http://d-c-a.000webhostapp.com/Profiles/default.jpg";
                    }
                ?>
                <img src="<?php echo $profile_path;?>" alt="Opps..." class="profile_pic">
                <form method='post' action="http://d-c-a.000webhostapp.com/upload.php" enctype="multipart/form-data" id=upload_profile_form>

                    <input type=file name=upload_file accept="image/jpeg" id=upload_profile_btn style="display:none" onchange="this.parentElement.submit()">
                    <input type=hidden name="directory" value="Profiles/">
                    <input type=hidden name="filename" value="<?php echo $_SESSION['user_nic']?>">
                    <input type=hidden name="header" value="true">
                    <input type=hidden name="resize" value="true">
                </form>
                <button id='edit_profile' onclick="document.getElementById('upload_profile_btn').click()">Change</button>
            </div>
            <div id='name_container'>
                <span id='name'><?php echo $_SESSION['first_name'] . " " . $_SESSION['last_name']; ?></span>
            </div>
        </div>


        <div id='home_sub_body'>
            <div class="detail">
                <div id='intro_heading'>Intro</div>
                <div class="edit_btn">
                    <a href='update_cd.php'><button id='edit_info_button'>Edit info</button></a>
                </div>
                <table style="width:100%">
                    <tr>
                        <td><?php echo "Name" ?></td>
                        <td><?php echo $_SESSION['first_name'] . " " . $_SESSION['last_name']; ?></td>
                    </tr>
                    <tr>
                        <td><?php echo "Gender" ?></td>
                        <td><?php echo $_SESSION['gender']; ?></td>
                    </tr>
                    <tr>
                        <td><?php echo "District" ?></td>
                        <td><?php echo $_SESSION['district']; ?></td>
                    </tr>
                    <tr>
                        <td><?php echo "Occupation" ?></td>
                        <td><?php echo $_SESSION['Occupation']; ?></td>
                    </tr>
                    <tr>
                        <td><?php echo "Address" ?></td>
                        <td><?php echo $_SESSION['address']; ?></td>
                    </tr>
                </table>
            </div>
            <div id="content">
                <div id=new_post>
                    <form method=post action=publicpost.php>
                        <textarea id=post_text_area name=post_text_area rows=3 cols=5></textarea>
                        <button type=submit id=submit name=submit value=post>POST</button>
                    </form>
                </div>
                <?php
                    $author=$_SESSION['user_nic'];

                    $query="select * from public_posts  WHERE author='$author' ORDER BY post_index DESC";
                    $result=$con->query($query);
                    while($row=$result->fetch_assoc()){
                        echo "<div id='posts'>";
                            echo "<div id='post_title'>";

                                echo  "<div id='post_date'> Date: " . $row['date'] . "</div>";
                            echo "</div>";
                            echo "<div id='post_content'>" . $row['content'] . "</div>";
                        echo "</div>";
                    }
                ?>
            </div>
        </div>
            <?php include $_SERVER['DOCUMENT_ROOT']."/includes/footer.php" ?>
    </body>
</html>