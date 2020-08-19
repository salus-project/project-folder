<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="css_codes/header.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>

    <body>
        <div class="titlebar">
            <div class="web_name">
                DCA
            </div>
            <div class="logout">
                <div class ="person_name">
                    <?php echo $_SESSION['first_name'] . " " . $_SESSION['last_name']; ?>
                </div>
                <div><img src="Profiles/login_img.png" alt="Avatar" class="avatar"></div>
                <div  class="logout_anchor" ><a href="login.php"><i class="fa fa-sign-out" style="font-size:18px;color:white;" aria-hidden="true"> Log out</i></a></div>
            </div>  
        </div>
        <div class="topnav">
            <a href="homepage.php">HOME</a>
            <a href="member.php">MEMBER</a>
            <a href="event.php">EVENT</a>
            <a href="post.php">POST</a>
            <a href="about.php">ABOUT</a>
            </div>
        <div>
    </body>

</html>