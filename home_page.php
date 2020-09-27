<?php
    require $_SERVER['DOCUMENT_ROOT']."/includes/header.php";
    $query="select * from civilian_detail where NIC_num='".$_SESSION['user_nic']."'";
    $query_result=mysqli_query($con,$query)->fetch_assoc();
?>

    <title>Home Page</title>
    <link rel="stylesheet" href="css_codes/homePage.css">
    <link rel="stylesheet" href="css_codes/publ.css">
    <script src="https://kit.fontawesome.com/b17fa3a18c.js" crossorigin="anonymous"></script>
    <script src="/common/post/post.js"></script>

    <script>
        btnPress(1);
    </script>
<div class="title">
    <div id='cover'>
        <?php
            $cover_path = "/common/documents/Covers/" . $_SESSION['user_nic'] . ".jpg?n=1";
        ?>
        <img id="cover_photo" src="<?php echo $cover_path;?>" alt="Opps..." class="cover_pic">
        
        <div id='profile_edit'>
            <div class="profile_container">
                <?php
                    $profile_path = "/common/documents/Profiles/" . $_SESSION['user_nic'] . ".jpg?n=1";
                ?>
                <img src="<?php echo $profile_path;?>" alt="Opps..." class="my_profile_pic">
            </div>
            <form method='post' action="/common/documents/upload.php" enctype="multipart/form-data" id=upload_profile_form>
                <input type=file name=upload_file accept="image/jpeg" id=upload_profile_btn style="display:none" onchange="this.parentElement.submit()">
                <input type=hidden name="directory" value="Profiles/">
                <input type=hidden name="filename" value="<?php echo $_SESSION['user_nic']?>">
                <input type=hidden name="header" value="true">
                <input type=hidden name="resize" value="true">
            </form>
            <button id='edit_profile_btn' onclick="document.getElementById('upload_profile_btn').click()"><i class="fa fa-camera" aria-hidden="true"></i>CHANGE</button>
        </div>
    </div>
    <div id='gradient_div'>
        <div id='name_container'>
            <span id='name'><?php echo $query_result['first_name'] . " " . $query_result['last_name']; ?></span>
        </div>
        <form method='post' action="/common/documents/upload.php" enctype="multipart/form-data" id=upload_cover_form>
            <input type=file name=upload_file accept="image/jpeg" id=upload_cover_btn style="display:none" onchange="this.parentElement.submit()">
            <input type=hidden name="directory" value="Covers/">
            <input type=hidden name="filename" value="<?php echo $_SESSION['user_nic']?>">
            <input type=hidden name="header" value="true">
        </form>
        <button id='edit_cover_but' onclick="document.getElementById('upload_cover_btn').click()"><i class="fa fa-camera" aria-hidden="true"></i>CHANGE</button>
    </div>
    
</div>


<div id='home_sub_body'>
    <div class="person_detail">
        <div id='intro_heading'>Intro</div>
        
        <table class='home_table'>
            <tr>
                <td class='home_view_td'><?php echo "Name" ?></td>
                <td class='home_view_td'><?php echo $query_result['first_name'] . " " . $query_result['last_name']; ?></td>
            </tr>
            <tr>
                <td class='home_view_td'><?php echo "Gender" ?></td>
                <td class='home_view_td'><?php echo $query_result['gender']; ?></td>
            </tr>
            <tr>
                <td class='home_view_td'><?php echo "District" ?></td>
                <td class='home_view_td'><?php echo $query_result['district']; ?></td>
            </tr>
            <tr>
                <td class='home_view_td'><?php echo "Occupation" ?></td>
                <td class='home_view_td'><?php echo $query_result['Occupation']; ?></td>
            </tr>
            <tr>
                <td class='home_view_td'><?php echo "Address" ?></td>
                <td class='home_view_td'><?php echo $query_result['address']; ?></td>
            </tr>
        </table>
        <div class="edit_btn">
            <a href='update_cd.php'><button id='edit_info_button'><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Edit info</button></a>
        </div>
    </div>
    <div id='home_post'>
        <div id="my_posts">
            MY POSTS 
        </div>
        <div id="content">

        </div>
    </div>
    <script>
        var post = new Post("select civilian_detail.first_name, civilian_detail.last_name, organizations.org_name, fundraisings.name, public_posts.* from (((public_posts LEFT JOIN civilian_detail on public_posts.author = civilian_detail.NIC_num) LEFT JOIN organizations on public_posts.org = organizations.org_id)  LEFT JOIN fundraisings on public_posts.fund = fundraisings.id) WHERE author='"+<?php echo $_SESSION['user_nic']?>+"'");
        post.get_post();
    </script>

</div>
<?php include $_SERVER['DOCUMENT_ROOT']."/includes/footer.php" ?>